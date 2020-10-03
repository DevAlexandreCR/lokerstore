<?php

namespace App\Decorators\Api;

use App\Http\Requests\Admin\Products\IndexRequest;
use App\Interfaces\Api\ApiProductsInterface;
use App\Repositories\Api\ApiProducts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheApiProducts implements ApiProductsInterface
{

    protected $apiProducts;

    public function __construct(ApiProducts $apiProducts)
    {
        $this->apiProducts = $apiProducts;
    }

    public function query(IndexRequest $request)
    {
        $query = $this->convertQueryToString($request);
        return Cache::tags('api.products')->rememberForever($query, function () use ($request) {
            return $this->apiProducts->query($request);
        });
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

    private function convertQueryToString(IndexRequest $request): string
    {
        $category = $request->validationData()['category'];
        $tags = implode(',', $request->validationData()['tags'] ?: []);
        $colors = implode(',', $request->validationData()['colors'] ?: []);
        $sizes = implode(',', $request->validationData()['sizes'] ?: []);
        $price = $request->validationData()['price'];
        $search = $request->validationData()['search'];

        return '$search=' . $search .'$category=' . $category . '$tags=' . $tags .
            '$sizes=' . $sizes . '$colors=' . $colors . 'price=' . $price;
    }
}
