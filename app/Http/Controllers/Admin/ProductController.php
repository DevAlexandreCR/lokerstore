<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Photos\DeletePhotoAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ActiveRequest;
use App\Http\Requests\Products\IndexRequest;
use App\Http\Requests\Products\StoreRequest;
use App\Http\Requests\Products\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Actions\Photos\SavePhotoAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of Products
     *
     * @param IndexRequest $request
     * @return View
     */
    public function index(IndexRequest $request) : View
    {
        $category = $request->validationData()['category'];
        $tags = $request->validationData()['tags'];
        $search = $request->validationData()['search'];
        $orderBy = $request->validationData()['orderBy'];
   
        return view('admin.products.index', [
            'products' => $this->product
                ->orderBy('created_at', $orderBy)
                ->byCategory($category)
                ->withTags($tags)
                ->search($search)
                ->paginate(10),
            'filters' => [
                'category'  => $category,
                'tags'      => $tags,
                'search'    => $search,
                'orderBy'   => $orderBy
            ]
        ]);
    }

    /**
     * Show the form for creating a new product.
     *
     * @return View
     */
    public function create() : View
    {
        $categories = Category::primaries();
        $tags = Tag::all();
        return view('admin.products.create', 
                    compact('categories', 'tags')
                );
    }

    /**
     * Store a newly created product in storage.
     *
     * @param StoreRequest $request
     * @param Product $product
     * @param SavePhotoAction $savePhotoAction
     * @return RedirectResponse
     */
    public function store(StoreRequest $request, Product $product, SavePhotoAction $savePhotoAction) : RedirectResponse
    {
        $new_product = $product->create($request->all());

        foreach ($request->get('tags') as $tag) {
            $new_product->tags()->attach($tag);
        }

        $savePhotoAction->execute($new_product->id, $request->file('photos'));

        return back()->with('success', __('Your product has been save successfully'));
    }

    /**
     * Show the form for enable disable or delete the specified product.
     *
     * @param Request $request
     * @param Product $product
     * @return View
     */
    public function active(Request $request, Product $product) : View
    {
        return view('admin.products.active', [
            'product'   => $product,
            'input_name'=> $request->get('input_name')
        ]);
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param Product $product
     * @return View
     */
    public function edit(Product $product) : View
    {
        $categories = Category::primaries();
        $tags = Tag::all();
        return view('admin.products.edit', [
            'product'   => $product
            ],
            compact('categories', 'tags')
        );
    }

    /**
     * Update product
     *
     * @param UpdateRequest $request
     * @param Product $product
     * @param DeletePhotoAction $deletePhotoAction
     * @param SavePhotoAction $savePhotoAction
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Product $product, DeletePhotoAction $deletePhotoAction, SavePhotoAction $savePhotoAction) : RedirectResponse
    {
        $product->tags()->sync($request->get('tags'));

        $savePhotoAction->execute($product->id, $request->file('photos'));

        $deletePhotoAction->execute($request->get('delete_photos'));

        $product->update($request->all());

        return redirect( route('products.edit', ['product' => $product]))
            ->with('product-updated', 'Product has been updated success');
    }

    /**
     * Enable or disable product
     *
     * @param ActiveRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function setActive(ActiveRequest $request, Product $product) : RedirectResponse
    {
        $product->update($request->all());

        return redirect( route('products.index'))
                ->with('product-updated', __('Your product has been update successfully'));
    }

    /**
     * Delete product
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product) : RedirectResponse
    {
        $product->delete();

        return redirect( route('products.index'))
                ->with('product-deleted', "Product has been deleted success");
    }
}
