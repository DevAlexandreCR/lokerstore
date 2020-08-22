<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index() : View
    {
        return view('admin.category.index', [
            'categories' => $this->category->primaries()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function store(StoreRequest $request, Category $category) : RedirectResponse
    {
        $category->create($request->all());
        return redirect()
                    ->back()
                    ->with('success', __('Category has been created success'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(Request $request, Category $category) : RedirectResponse
    {
        $category->update($request->all());

        return redirect()
                    ->back()
                    ->with('success', __('Category has been updated success'));
    }

    /**
     * Remove the specified resource from storage.
     * @param Category $category
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Category $category) : RedirectResponse
    {
        $category->delete();

        return redirect()
                    ->back()
                    ->with('success', __('Category has been deleted success'));
    }
}
