<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Products\StoreRequest;
use App\Http\Requests\Api\Products\UpdateRequest;
use App\Http\Requests\Admin\Products\IndexRequest;
use App\Http\Resources\ProductResource;
use App\Interfaces\Api\ApiProductsInterface;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected ApiProductsInterface $apiProducts;

    public function __construct(ApiProductsInterface $apiProducts)
    {
        $this->apiProducts = $apiProducts;
    }

    /**
     * Response at Json whit products resource
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        return response()->json(ProductResource::collection(
            $this->apiProducts->query($request)
        ));
    }

    /**
     * Display the specified resource.
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'status' => [
                'status' => 'OK',
                'message' => 'Product was found',
                'code'    => 200
            ],
            'product' => ProductResource::collection(
           $this->apiProducts->show($product)
        )]);
    }

    /**
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $product = $this->apiProducts->store($request);

        return response()->json([
            'status' => [
                'status' => 'OK',
                'message' => 'Product was created successfully',
                'code'    => 200
            ],
            'product' => $product
        ]);
    }

    public function update(UpdateRequest $request, Product $product): JsonResponse
    {
        $product = $this->apiProducts->update($request, $product);

        return response()->json([
            'status' => [
                'status'  => 'OK',
                'message' => 'Product was updated successfully',
                'code'    => 200
            ],
            'product' => $product
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->apiProducts->destroy($product);

        return response()->json([
            'status' => [
                'status' => 'OK',
                'message' => 'Product was deleted successfully',
                'code'    => 200
            ]
        ]);
    }
}
