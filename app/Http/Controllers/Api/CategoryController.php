<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * retun list of categories primaries
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        return response()->json(CategoryResource::collection($this->category->primaries()));
    }


    /**
     * Display the specified resource.
     * @param Category $category
     * @return CategoryResource
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }
}
