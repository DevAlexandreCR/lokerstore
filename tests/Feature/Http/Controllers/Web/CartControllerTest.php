<?php

namespace Tests\Feature\Http\Controllers\Web;

use App\Models\Cart;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\TestDatabaseSeeder;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        $this->seed([
            TestDatabaseSeeder::class,
        ]);
    }

    private $categories = [
        'RopaTest','ZapatosTest','DeportesTest','AccesoriosTest',
    ];

    public function testShow(): void
    {
        $user = factory(User::class)->create([
            'email_verified_at' => now(),
        ]);
        factory(Cart::class)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get(route('cart.show', $user));

        $response
            ->assertViewIs('web.users.cart.show')
            ->assertViewHas('cart');
    }

    public function testAnUserUnVerifiedCannotViewCart(): void
    {
        $user = factory(User::class)->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->get(route('cart.show', $user));

        $response
            ->assertRedirect(route('verification.notice'));
    }

    public function testAnuserCanAddItemToCart(): void
    {
        $user = factory(User::class)->create([
            'email_verified_at' => now(),
        ]);

        factory(Cart::class)->create([
            'user_id' => $user->id,
        ]);

        $stock = factory(Stock::class)->create([
            'quantity' => 5,
        ]);

        $response = $this->actingAs($user)->post(
            route('cart.add', $user),
            [
                'product_id' => $stock->product_id,
                'size_id' => $stock->size->id,
                'color_id' => $stock->color->id,
                'quantity' => 2,
            ]
        );

        $response->assertStatus(302);

        $this->assertDatabaseHas(
            'cart_stock',
            [
            'cart_id' => $user->cart->id,
            'stock_id' => $stock->id,
            'quantity' => 2,
            ]
        );
    }
    public function testAnuserCanRemoveitemToCart(): void
    {
        $user = factory(User::class)->create([
            'email_verified_at' => now(),
        ]);

        factory(Cart::class)->create([
            'user_id' => $user->id,
        ]);

        $stock = factory(Stock::class)->create([
            'quantity' => 5,
        ]);

        $user->cart->stocks()->attach($stock->id, ['quantity' => 2]);

        $response = $this->actingAs($user)->delete(route(
            'cart.remove',
            [$user, $stock]
        ));

        $response->assertStatus(302);

        $this->assertDatabaseMissing(
            'cart_stock',
            [
                'cart_id' => $user->cart->id,
                'stock_id' => $stock->id,
                'quantity' => 2,
            ]
        );
    }
}
