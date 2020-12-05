<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        return view('web.show', [
            'product' => $product->load('stocks', 'stocks.color', 'stocks.size'),
            'sizes' => $product->sizes()->get()->unique(),
        ]);
    }
}
