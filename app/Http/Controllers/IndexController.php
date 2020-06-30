<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
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
            session(['verify_email' => 'Por favor verifica tu correo para completar el registro']);
        }

        return view('index', [
            'products' => $this->product->all()
        ]);
    }
}
