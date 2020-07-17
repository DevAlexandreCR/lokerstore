<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\IndexRequest;
use App\Http\Requests\Products\StoreRequest;
use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;
use Image;

class ProductController extends Controller
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
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
                'category' => $category,
                'tags' => $tags,
                'search' => $search,
                'orderBy' => $orderBy
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, Product $product)
    {
        $new_product_id = $product->create($request->all())->id;

        foreach ($request->file('photos') as $photo) {
            $name = time() . '_' . $photo->getClientOriginalName();
            $file_path = public_path('images/');
            $img = Image::make($photo);
            $img->fit(500, 500)->save($file_path . $name);

            $photoModel = new Photo;
            $photoModel->product_id = $new_product_id; 
            $photoModel->name = $name;
            $photoModel->file_path = $file_path;  
            
            $photoModel->save();
        }

        return back()->with('success', __('Your product has been save successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.products.show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        return redirect( route('products.show', ['product' => $product->id]))
            ->with('product-updated', 'Product has been updated success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect( route('products.index'))
            ->with('product-deleted', "Product has been deleted success");
    }
}
