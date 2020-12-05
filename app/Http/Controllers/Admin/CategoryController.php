<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Interfaces\CategoryInterface;
use App\Models\Category;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected CategoryInterface $categories;

    public function __construct(CategoryInterface $categories)
    {
        $this->authorizeResource(Category::class, 'category');
        $this->categories = $categories;
    }
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.category.index', [
            'categories' => $this->categories->index(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->categories->store($request);

        return redirect()
                    ->back()->with('success', trans('messages.crud', [
                        'resource' => trans('products.category'),
                        'status' => trans('fields.created')
                    ]));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $this->categories->update($request, $category);

        return redirect()->back()->with('success', trans('messages.crud', [
                        'resource' => trans('products.category'),
                        'status' => trans('fields.updated')
                    ]));
    }

    /**
     * Remove the specified resource from storage.
     * @param Category $category
     * @throws Exception
     * @return RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        $this->categories->destroy($category);

        return redirect()
                    ->back()->with('success', trans('messages.crud', [
                        'resource' => trans('products.category'),
                        'status' => trans('fields.deleted')
                    ]));
    }
}
