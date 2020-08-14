<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(User $user)
    {
        return view('web.cart.index',
        [
            'cart' => $user->cart
        ]);
    }
}
