<?php

namespace App\Repositories;

use App\Http\Requests\Products\ActiveRequest;
use App\Http\Requests\Products\IndexRequest;
use App\Interfaces\ProductsInterface;
use App\Models\Product;

class Products implements ProductsInterface
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function query(IndexRequest $request)
    {
        $category = $request->validationData()['category'];
        $tags = $request->validationData()['tags'];
        $search = $request->validationData()['search'];
        $orderBy = $request->validationData()['orderBy'];

        return $this->product
            ->orderBy('created_at', $orderBy)
            ->byCategory($category)
            ->withTags($tags)
            ->search($search)
            ->paginate(15);
    }

    public function store($request)
    {
        $product = $this->product->create($request->all());

        foreach ($request->get('tags') as $tag) {
            $product->tags()->attach($tag);
        }

        return $product;
    }

    public function update($request, $product)
    {
        $product->tags()->sync($request->get('tags'));

        $product->update($request->all());

        return $product;
    }

    public function setActive(ActiveRequest $request, Product $product)
    {
        return $product->update($request->all());
    }

    public function destroy($product)
    {
        return $product->delete();
    }

    public function index()
    {
        return $this->product->all();
    }
}
