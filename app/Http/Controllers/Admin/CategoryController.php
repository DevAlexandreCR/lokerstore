<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
     * @return Illuminate\View\View
     */
    public function index() : View
    {
        return view('admin.category.index', [
            'categories' => $this->category->primaries()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Category $category) : RedirectResponse
    {
        $category->create($request->all());

        return redirect()
                    ->back()
                    ->with('success', __('Category has been created success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
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
     *
     * @param  \Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category) : RedirectResponse
    {
        $category->delete();

        return redirect()
                    ->back()
                    ->with('success', __('Category has been deleted success'));
    }
}
