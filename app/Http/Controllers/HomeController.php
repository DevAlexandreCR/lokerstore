<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;

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
