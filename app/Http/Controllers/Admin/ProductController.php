<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\ActiveRequest;
use App\Http\Requests\Admin\Products\IndexRequest;
use App\Http\Requests\Admin\Products\StoreRequest;
use App\Http\Requests\Admin\Products\UpdateRequest;
use App\Interfaces\CategoryInterface;
use App\Interfaces\ColorsInterface;
use App\Interfaces\ProductsInterface;
use App\Interfaces\SizesInterface;
use App\Interfaces\TagsInterface;
use App\Models\Product;
use App\Models\Tag;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected $products;

    public function __construct(ProductsInterface $products)
    {
        $this->authorizeResource(Product::class, 'product');
        $this->products = $products;
    }

    /*
     * Display a listing of Products
     *
     * @param IndexRequest $request
     * @param CategoryInterface $categories
     * @return View
     */
    public function index(IndexRequest $request, CategoryInterface $categories): View
    {
        $category = $request->validationData()['category'];
        $tags = $request->validationData()['tags'];
        $search = $request->validationData()['search'];
        $orderBy = $request->validationData()['orderBy'];

        $categories = $categories->all();

        $products = $this->products->query($request);

        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
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
     * @param TagsInterface $tags
     * @param CategoryInterface $categories
     * @param ColorsInterface $colors
     * @param SizesInterface $sizes
     * @return View
     */
    public function create(TagsInterface $tags, CategoryInterface $categories, ColorsInterface $colors,
                            SizesInterface $sizes): View
    {
        $categories = $categories->all();
        $tags = $tags->index();
        $colors = $colors->index();
        $sizes = $sizes->index();

        return view('admin.products.create',
                    compact('categories', 'tags', 'sizes', 'colors')
                );
    }

    /**
     * Store a newly created product in storage.
     *
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $product = $this->products->store($request);

        return redirect(route('stocks.create', $product))
            ->with('success', __('Your product has been save successfully'));
    }

    /**
     * Show the form for enable disable or delete the specified product.
     *
     * @param Request $request
     * @param Product $product
     * @return View
     * @throws AuthorizationException
     */
    public function active(Request $request, Product $product): View
    {
        $this->authorize('view', $product);

        return view('admin.products.active', [
            'product'   => $product,
            'input_name'=> $request->get('input_name')
        ]);
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param Product $product
     * @param CategoryInterface $categories
     * @return View
     */
    public function edit(Product $product, CategoryInterface $categories): View
    {
        $categories = $categories->index();
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
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Product $product): RedirectResponse
    {
        $product = $this->products->update($request, $product);

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
    public function setActive(ActiveRequest $request, Product $product): RedirectResponse
    {
        $this->products->setActive($request, $product);

        return redirect( route('products.index'))
                ->with('product-updated', __('Your product has been update successfully'));
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->products->destroy($product);

        return redirect( route('products.index'))
                ->with('product-deleted', "Product has been deleted success");
    }
}
