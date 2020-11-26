<?php

namespace App\Decorators;

use App\Actions\Photos\DeletePhotoAction;
use App\Actions\Photos\SavePhotoAction;
use App\Http\Requests\Admin\Products\ActiveRequest;
use App\Http\Requests\Admin\Products\IndexRequest;
use App\Interfaces\ProductsInterface;
use App\Models\Product;
use App\Repositories\Products;
use Illuminate\Support\Facades\Cache;

class CacheProducts implements ProductsInterface
{
    protected Products $products;

    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    public function query($request)
    {
        $query = $this->convertQueryToString($request);

        return Cache::tags('products')->rememberForever($query, function () use ($request) {
            return $this->products->query($request);
        });
    }

    public function store($request)
    {
        $product = $this->products->store($request);

        Cache::tags(['products', 'api.products'])->flush();

        SavePhotoAction::execute($product->id, $request->file('photos'));

        return $product;
    }

    public function update($request, $product)
    {
        $product = $this->products->update($request, $product);

        Cache::tags(['products', 'api.products'])->flush();
        $deletePhotoAction = new DeletePhotoAction();
        SavePhotoAction::execute($product->id, $request->file('photos'));
        $deletePhotoAction->execute($request->get('delete_photos'));

        return $product;
    }

    public function setActive(ActiveRequest $request, Product $product)
    {
        $this->products->setActive($request, $product);

        Cache::tags(['products', 'api.products'])->flush();

        return $product;
    }

    public function destroy($product)
    {
        $this->products->destroy($product);

        return Cache::tags(['products', 'api.products'])->flush();
    }

    public function index()
    {
        return Cache::tags(['products', 'api.products'])->rememberForever('all', function () {
            return $this->products->index();
        });
    }

    private function convertQueryToString(IndexRequest $request): string
    {
        $category = $request->get('category', null);
        $tags = implode(',', $request->get('tags', []));
        $search = $request->get('search', null);
        $page = $request->get('page', 1);
        $orderBy = $request->get('orderBy', 'desc');

        return 'orderBy=' . $orderBy . '.page=' . $page . '$search=' .
            $search . '$category=' . $category . '$tags=' . $tags;
    }

    /**
     * @param array $data
     * @return ?Product
     */
    public function create(array $data = []): ?Product
    {
        Cache::tags(['products', 'api.products'])->flush();

        return $this->products->create($data);
    }
}
