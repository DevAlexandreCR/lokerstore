<?php

namespace App\Decorators\Api;

use App\Actions\Photos\Base64ToImage;
use App\Actions\Photos\SavePhotoAction;
use App\Http\Requests\Admin\Products\IndexRequest;
use App\Interfaces\Api\ApiProductsInterface;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Stock;
use App\Models\Tag;
use App\Models\TypeSize;
use App\Repositories\Api\ApiProducts;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheApiProducts implements ApiProductsInterface
{
    protected ApiProducts $apiProducts;

    public function __construct(ApiProducts $apiProducts)
    {
        $this->apiProducts = $apiProducts;
    }

    /**
     * @param IndexRequest $request
     * @return array|mixed
     */
    public function query(IndexRequest $request)
    {
        $query = $this->convertQueryToString($request);

        return Cache::tags('api.products')->rememberForever($query, function () use ($request) {
            return $this->apiProducts->query($request);
        });
    }

    /**
     * @return mixed|void
     */
    public function index()
    {
        // TODO: Implement index() method.
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $product = $this->apiProducts->store($request);

        foreach ($request->get('tags') as $tag) {
            $tag_id = Tag::where('name', $tag)->firstOrFail();
            $product->tags()->attach($tag_id);
        }

        foreach ($request->get('stocks') as $stock) {
            $color_id = Color::where('name', $stock['color'])->first()->id;
            $type_id = TypeSize::where('name', $stock['size']['type'])->first()->id;
            $size_id = Size::where('name', $stock['size']['size'])->where('type_sizes_id', $type_id)->first()->id;

            Stock::create([
                'product_id' => $product->id,
                'color_id' => $color_id,
                'size_id' => $size_id,
                'quantity' => $stock['quantity'],
            ]);
        }

        foreach ($request->get('photos') as $image) {
            $name = $product->reference . '_' . time() . '.jpg';
            $outputFile = storage_path('app/public/photos/') . $name;
            Base64ToImage::execute($image, $outputFile);
            SavePhotoAction::savePhoto($product->id, $name);
        }

        Cache::tags(['products', 'api.products'])->flush();

        return $product;
    }

    public function update(Request $request, Model $product)
    {
        $this->apiProducts->update($request, $product);

        foreach ($request->get('tags') as $tag) {
            $tag_id = Tag::where('name', $tag)->firstOrFail();
            $product->tags()->attach($tag_id);
        }

        Cache::tags(['products', 'api.products'])->flush();

        return $product;
    }

    public function destroy(Model $model)
    {
        $this->apiProducts->destroy($model);

        Cache::tags(['products', 'api.products'])->flush();
    }

    private function convertQueryToString(IndexRequest $request): string
    {
        $category = $request->validationData()['category'];
        $tags = implode(',', $request->validationData()['tags'] ?: []);
        $colors = implode(',', $request->validationData()['colors'] ?: []);
        $sizes = implode(',', $request->validationData()['sizes'] ?: []);
        $price = $request->validationData()['price'];
        $search = $request->validationData()['search'];

        return '$search=' . $search . '$category=' . $category . '$tags=' . $tags .
            '$sizes=' . $sizes . '$colors=' . $colors . 'price=' . $price;
    }

    /**
     * @param Product $product
     * @return Collection
     */
    public function show(Product $product): Collection
    {
        return Cache::tags('api.products')->rememberForever($product->id, function () use ($product) {
            return $this->apiProducts->show($product);
        });
    }
}
