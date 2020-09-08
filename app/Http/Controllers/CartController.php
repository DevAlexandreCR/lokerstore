<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddCartRequest;
use App\Http\Requests\Cart\UpdateRequest;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function show(User $user): View
    {
        return view('web.users.cart.show',
        [
            'cart' => $user->cart->with('stocks')->first()
        ]);
    }

    public function add(AddCartRequest $request, User $user): RedirectResponse
    {

        $product_id = $request->get('product_id', null);
        $color_id = $request->get('color_id', null);
        $size_id = $request->get('size_id', null);
        $quantity = $request->get('quantity', null);

        $stock = Stock::findStock($product_id, $color_id, $size_id)->first();

        $user->cart->stocks()->attach($stock->id, ['quantity' => $quantity]);

        return redirect()->back()->with('success', __('Product Added to cart'));
    }

    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        $stock_id = $request->get('stock_id', null);
        $quantity = $request->get('quantity', 1);

        $user->cart->stocks()->detach($stock_id);
        $user->cart->stocks()->attach($stock_id, ['quantity'=> $quantity]);

        return redirect()->back()->with('success', __('Product Added to cart'));
    }

    public function remove(User $user, Stock $stock): RedirectResponse
    {
        $user->cart->stocks()->detach($stock->id);

        return redirect()->back()->with('success', __('Product removed to cart'));
    }
}
