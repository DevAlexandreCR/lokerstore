<?php

namespace App\Decorators;

use App\Actions\Photos\DeletePhotoAction;
use App\Actions\Photos\SavePhotoAction;
use App\Http\Requests\Products\ActiveRequest;
use App\Http\Requests\Products\IndexRequest;
use App\Http\Requests\Products\StoreRequest;
use App\Http\Requests\Products\UpdateRequest;
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

    public function index(IndexRequest $request)
    {
        $page = 'products.page' . $request->get('page', 1);

        return Cache::tags(['products'])->rememberForever($page, function () use ($request){
           return $this->products->index($request);
        });
    }

    public function store(StoreRequest $request)
    {
        $product = $this->products->store($request);

        Cache::tags('products')->flush();

        $savePhotoAction = new SavePhotoAction();
        $savePhotoAction->execute($product->id, $request->file('photos'));

        return $product;
    }

    public function update(UpdateRequest $request, Product $product)
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

    public function destroy(Product $product)
    {
        $this->products->destroy($product);

        return Cache::tags('products')->flush();
    }
}
