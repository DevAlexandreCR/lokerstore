<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\IndexRequest;
use App\Http\Resources\ProductResource;
use App\Interfaces\Api\ApiProductsInterface;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected $apiProducts;

    public function __construct(ApiProductsInterface $apiProducts)
    {
        $this->apiProducts = $apiProducts;
    }

    /**
     * Response at Json whit products resource
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexRequest $request) : JsonResponse
    {
        return response()->json(ProductResource::collection(
            $this->apiProducts->query($request)
        ));
    }

    /**
     * Display the specified resource.
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }
}
