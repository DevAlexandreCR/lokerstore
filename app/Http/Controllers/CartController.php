<?php

namespace App\Http\Controllers;

use App\Http\Requests\Web\Cart\AddCartRequest;
use App\Http\Requests\Web\Cart\UpdateRequest;
use App\Models\Stock;
use App\Models\User;
use App\Repositories\Carts;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * @param User $user
     * @param Carts $carts
     * @return View
     */
    public function show(User $user, Carts $carts): View
    {
        return view(
            'web.users.cart.show',
            [
            'cart' => $carts->getCart($user->id),
            ]
        );
    }

    /**
     * @param AddCartRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function add(AddCartRequest $request, User $user): RedirectResponse
    {
        $product_id = $request->get('product_id', null);
        $color_id = $request->get('color_id', null);
        $size_id = $request->get('size_id', null);
        $quantity = $request->get('quantity', null);

        $stock = Stock::findStock($product_id, $color_id, $size_id)->first();

        $user->cart->stocks()->attach($stock->id, ['quantity' => $quantity]);

        return redirect()->back()->with('success', trans('products.added'));
    }

    /**
     * @param UpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        $stock_id = $request->get('stock_id', null);
        $quantity = $request->get('quantity', 1);

        $user->cart->stocks()->detach($stock_id);
        $user->cart->stocks()->attach($stock_id, ['quantity' => $quantity]);

        return redirect()->back()->with('success', trans('products.added'));
    }

    /**
     * @param User $user
     * @param Stock $stock
     * @return RedirectResponse
     */
    public function remove(User $user, Stock $stock): RedirectResponse
    {
        $user->cart->stocks()->detach($stock->id);

        return redirect()->back()->with('success', trans('products.added'));
    }
}
