<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ActiveRequest;
use App\Http\Requests\Products\IndexRequest;
use App\Http\Requests\Products\StoreRequest;
use App\Http\Requests\Products\UpdateRequest;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
                'category'  => $category,
                'tags'      => $tags,
                'search'    => $search,
                'orderBy'   => $orderBy
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
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.products.create', 
                    compact('categories', 'tags')
                );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, Product $product)
    {
        $new_product = $product->create($request->all());

        foreach ($request->get('tags') as $tag) {
            $new_product->tags()->attach($tag);
        }

        foreach ($request->file('photos') as $photo) {
            $name = time() . '_' . $photo->getClientOriginalName();
            $img = Image::make($photo)->fit(540, 480)->encode('jpg', 75);
            Storage::disk('public_photos')->put($name, $img);

            $photoModel = new Photo;
            $photoModel->product_id = $new_product->id; 
            $photoModel->name = $name;
            
            $photoModel->save();
        }

        return back()->with('success', __('Your product has been save successfully'));
    }

    /**
     * Show the form for enable disable or delete the specified product.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function active(Request $request, Product $product)
    {
        return view('admin.products.active', [
            'product'   => $product,
            'input_name'=> $request->get('input_name')
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
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.products.edit', [
            'product'   => $product
            ],
            compact('categories', 'tags')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $product->tags()->sync($request->get('tags'));

        if ($request->get('delete_photo')){
            foreach ($request->get('delete_photo') as $photo_id) {
                $photo = Photo::findOrFail($photo_id);
                $name = $photo->name;
                $photo->delete();
                Storage::disk('public')->delete('photos/' . $name);
            }
        }

        if ($request->file('photos')){
            foreach ($request->file('photos') as $photo) {
                $name = time() . '_' . $photo->getClientOriginalName();
                $img = Image::make($photo)->fit(540, 480)->encode('jpg', 75);
                Storage::disk('public_photos')->put($name, $img);
    
                $photoModel = new Photo;
                $photoModel->product_id = $product->id; 
                $photoModel->name = $name;
                
                $photoModel->save();
            }
        }

        $product->update($request->all());

        return redirect( route('products.edit', ['product' => $product]))
            ->with('product-updated', 'Product has been updated success');
    }

    public function setActive(ActiveRequest $request, Product $product)
    {
        $product->update($request->all());

        return redirect( route('products.index'))
                ->with('product-updated', __('Your product has been update successfully'));
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
