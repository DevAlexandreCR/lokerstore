<?php

namespace App\Repositories;

use App\Http\Requests\Admin\Products\ActiveRequest;
use App\Http\Requests\Admin\Products\IndexRequest;
use App\Interfaces\ProductsInterface;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Products implements ProductsInterface
{
    protected Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @param IndexRequest $request
     * @return mixed
     */
    public function query(IndexRequest $request)
    {
        $category = $request->validationData()['category'];
        $tags = $request->validationData()['tags'];
        $search = $request->validationData()['search'];
        $orderBy = $request->validationData()['orderBy'];
        return $this->product::with('category', 'category.parent', 'photos', 'tags', 'stocks')
            ->byCategory($category)
            ->withTags($tags)
            ->search($search)
            ->orderBy('created_at', $orderBy)
            ->paginate(15);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $product = $this->product->create($request->all());

        foreach ($request->get('tags') as $tag) {
            $product->tags()->attach($tag);
        }

        return $product;
    }

    /**
     * @param Request $request
     * @param Model $product
     * @return Model|mixed
     */
    public function update(Request $request, Model $product)
    {
        $product->tags()->sync($request->get('tags', null));

        $product->update($request->all());

        return $product;
    }

    /**
     * @param ActiveRequest $request
     * @param Product $product
     * @return bool|mixed
     */
    public function setActive(ActiveRequest $request, Product $product)
    {
        return $product->update($request->all());
    }

    public function destroy($product)
    {
        return $product->delete();
    }

    /**
     * @return Product[]|Collection|mixed
     */
    public function index()
    {
        return $this->product::all();
    }

    public function getForOrders()
    {
        return $this->product::with(
            'stocks',
            'category',
            'stocks.size',
            'stocks.color'
        )->get();
    }

    /**
     * @param array $data
     * @return Product|null
     */
    public function create(array $data = []): ?Product
    {
        $product = $this->product->updateOrCreate([
            'reference' => $data['reference'],
        ], $data);

        $tags = [];
        $tagsNames = explode(', ', $data['tags']);
        foreach ($tagsNames as $tag) {
            $tagDB = Tag::where('name', $tag)->first();
            $tags[] = $tagDB->id;
        }
        $product->tags()->sync($tags);

        return $product;
    }
}
