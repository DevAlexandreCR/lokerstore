<?php

namespace Tests\Feature\Http\Controllers\Web;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'email_verified_at' => now()
        ]);

        $response = $this->actingAs($user)->get(route('user.cart.index', $user));

        $response
            ->assertViewIs('web.cart.index')
            ->assertViewHas('cart');
    }

    public function testAnUserUnVerifiedCannotViewCart()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'email_verified_at' => null
        ]);

        $response = $this->actingAs($user)->get(route('user.cart.index', $user));

        $response
            ->assertRedirect(route('verification.notice'));
    }

    public function testAnuserCanAddItemToCart()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email_verified_at' => now()
        ]);

        factory(Cart::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get(route('user.cart.store', $user), [
            'stock_id' => 10,
            'quantity' => 2
        ]);

        $this->assertDatabaseHas('carts',
        [
            'id' => $user->cart->id
        ]);
    }
}
