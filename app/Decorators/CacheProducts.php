<?php

namespace App\Decorators;

use App\Actions\Photos\DeletePhotoAction;
use App\Actions\Photos\SavePhotoAction;
use App\Http\Requests\Products\ActiveRequest;
use App\Http\Requests\Products\IndexRequest;
use App\Interfaces\ProductsInterface;
use App\Models\Product;
use App\Repositories\Products;
use Illuminate\Support\Facades\Cache;

class CacheProducts implements ProductsInterface
{
    protected $products;

    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    public function query(IndexRequest $request)
    {
        $query = $this->convertQueryToString($request);

        return Cache::tags(['products'])->rememberForever($query, function () use ($request){
           return $this->products->query($request);
        });
    }

    public function store($request)
    {
        $product = $this->products->store($request);

        Cache::tags('products')->flush();

        $savePhotoAction = new SavePhotoAction();
        $savePhotoAction->execute($product->id, $request->file('photos'));

        return $product;
    }

    public function update($request, $product)
    {
        $product = $this->products->update($request, $product);

        Cache::tags('products')->flush();

        $savePhotoAction = new SavePhotoAction();
        $deletePhotoAction = new DeletePhotoAction();
        $savePhotoAction->execute($product->id, $request->file('photos'));
        $deletePhotoAction->execute($request->get('delete_photos'));

        return $product;
    }

    public function setActive(ActiveRequest $request, Product $product)
    {
        $product = $this->products->setActive($request, $product);

        Cache::tags('products')->flush();

        return $product;
    }

    public function destroy($product)
    {
        $this->products->destroy($product);

        return Cache::tags('products')->flush();
    }

    public function index()
    {
        return Cache::tags(['products'])->rememberForever('all', function () {
            return $this->products->index();
        });
    }

    private function convertQueryToString(IndexRequest $request): string
    {
        $category = $request->get('category', null);
        $tags = implode(',', $request->get('tags', []) );
        $search = $request->get('search', null);
        $page = $request->get('page', 1);

        return 'products.page=' . $page . '$search=' . $search .'$category=' . $category . '$tags=' . $tags;
    }
}
