<?php

namespace App\Repositories\Api;

use App\Http\Requests\Admin\Products\IndexRequest;
use App\Interfaces\Api\ApiProductsInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ApiProducts implements ApiProductsInterface
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
            ->with('category', 'photos')
            ->get();
    }

    public function index()
    {
        // TODO: Implement index() method.
    }

    public function store(Request $request)
    {
        // TODO: Implement store() method.
    }

    public function update(Request $request, Model $model)
    {
        // TODO: Implement update() method.
    }

    public function destroy(Model $model)
    {
        // TODO: Implement destroy() method.
    }
}
