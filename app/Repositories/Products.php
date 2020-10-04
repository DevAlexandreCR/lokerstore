<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Admin\Products\ActiveRequest;
use App\Http\Requests\Admin\Products\IndexRequest;
use App\Interfaces\ProductsInterface;
use App\Models\Product;

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

        return $this->product
            ->orderBy('created_at', $orderBy)
            ->byCategory($category)
            ->withTags($tags)
            ->search($search)
            ->with('category', 'photos', 'tags', 'stocks')
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
}
