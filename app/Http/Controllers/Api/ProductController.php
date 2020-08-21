<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\IndexRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Response at Json whit products resource
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexRequest $request) : JsonResponse
    {
        $category = $request->validationData()['category'];
        $tags = $request->validationData()['tags'];
        $colors = $request->validationData()['colors'];
        $sizes = $request->validationData()['sizes'];
        $price = $request->validationData()['price'];
        $search = $request->validationData()['search'];
        return response()->json(ProductResource::collection(
            $this->product
                ->active()
                ->byCategory($category)
                ->price($price)
                ->colors($colors)
                ->sizes($sizes)
                ->withTags($tags)
                ->search($search)
                ->get()
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
