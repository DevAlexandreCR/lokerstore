<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{
    protected Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        return redirect(route('home'));
    }

    /**
     * @return View
     */
    public function home(): View
    {
        return view('home');
    }
}
