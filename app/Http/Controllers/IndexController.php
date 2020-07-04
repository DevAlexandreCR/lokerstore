<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        if (Auth::check() && Auth::user()->email_verified_at == null) {
            /**
             * si el usuario no ha verificado su email se carga la variable de sesion
             */
            session(['verify_email' => __('Please check your email to complete registration')]);
        }

        return view('index', [
            'products' => $this->product->all()
        ]);
    }
}
