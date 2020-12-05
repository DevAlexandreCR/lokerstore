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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected ProductsInterface $products;

    public function __construct(ProductsInterface $products)
    {
        $this->authorizeResource(Product::class, 'product');
        $this->products = $products;
    }

    /**
     * @param IndexRequest $request
     * @param CategoryInterface $categories
     * @param TagsInterface $tags
     * @return View
     */
    public function index(IndexRequest $request, CategoryInterface $categories, TagsInterface $tags): View
    {
        $category = $request->validationData()['category'];
        $tagsFilter = $request->validationData()['tags'];
        $search = $request->validationData()['search'];
        $orderBy = $request->validationData()['orderBy'];

        $categories = $categories->all();

        $products = $this->products->query($request);

        return view('admin.products.index', [
            'products'  => $products,
            'categories' => $categories,
            'tags'      => $tags->index(),
            'filters' => [
                'category'  => $category,
                'tags'      => $tagsFilter,
                'search'    => $search,
                'orderBy'   => $orderBy,
            ],
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
    public function create(
        TagsInterface $tags,
        CategoryInterface $categories,
        ColorsInterface $colors,
        SizesInterface $sizes
    ): View {
        $categories = $categories->index();
        $tags = $tags->index();
        $colors = $colors->index();
        $sizes = $sizes->index();

        return view(
            'admin.products.create',
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
            ->with('success', trans('messages.crud', [
                'resource' => trans_choice('products.product', 1, ['product_count' => '']),
                'status' => trans('fields.created')
            ]));
    }

    /**
     * Show the form for enable disable or delete the specified product.
     *
     * @param Request $request
     * @param Product $product
     * @throws AuthorizationException
     * @return View
     */
    public function active(Request $request, Product $product): View
    {
        $this->authorize('view', $product);

        return view('admin.products.active', [
            'product'   => $product,
            'input_name' => $request->get('input_name'),
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

        return view(
            'admin.products.edit',
            [
            'product'   => $product,
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

        return redirect(route('products.edit', ['product' => $product]))
            ->with('success', trans('messages.crud', [
                'resource' => trans_choice('products.product', 1, ['product_count' => '']),
                'status' => trans('fields.updated')
            ]));
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

        return redirect(route('products.index'))
                ->with('seccess', trans('messages.crud', [
                    'resource' => trans_choice('products.product', 1, ['product_count' => '']),
                    'status' => trans('fields.updated')
                ]));
    }

    /**
     * @param Product $product
     * @throws Exception
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->products->destroy($product);

        return redirect(route('products.index'))
                ->with('success', trans('messages.crud', [
                    'resource' => trans_choice('products.product', 1, ['product_count' => '']),
                    'status' => trans('fields.deleted')
                ]));
    }
}
