<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Interfaces\CategoryInterface;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected CategoryInterface $categories;

    public function __construct(CategoryInterface $categories)
    {
        $this->categories = $categories;
    }

    /**
     * retun list of categories primaries
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(CategoryResource::collection($this->categories->index()));
    }

    /**
     * Display the specified resource.
     * @param Category $category
     * @return CategoryResource
     */
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }
}
