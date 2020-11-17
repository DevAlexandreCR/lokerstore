<?php

namespace App\Repositories\Api;

use App\Http\Requests\Admin\Products\IndexRequest;
use App\Interfaces\Api\ApiProductsInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ApiProducts implements ApiProductsInterface
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
        $colors = $request->validationData()['colors'];
        $sizes = $request->validationData()['sizes'];
        $price = $request->validationData()['price'];
        $search = $request->validationData()['search'];

        return $this->product
            ->active()
            ->byCategory($category)
            ->price($price)
            ->colors($colors)
            ->sizes($sizes)
            ->withTags($tags)
            ->search($search)
            ->with('category', 'photos', 'stocks')
            ->get();
    }

    public function index()
    {
        // TODO: Implement index() method.
    }

    public function store(Request $request)
    {
        return $this->product->create($request->all());
    }

    public function update(Request $request, Model $product)
    {
        $product->update($request->all());
    }

    public function destroy(Model $model)
    {
        $this->product::destroy($model->id);
    }

    /**
     * @param Product $product
     * @return Collection
     */
    public function show(Product $product): Collection
    {
        return $this->product::with('stocks', 'category', 'photos')->where('id', $product->id)->get();
    }
}
