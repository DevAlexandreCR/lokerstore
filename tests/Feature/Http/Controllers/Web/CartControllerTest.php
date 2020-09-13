<?php

namespace Tests\Feature\Http\Controllers\Web;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Color;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Size;
use App\Models\Stock;
use App\Models\Tag;
use App\Models\TypeSize;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PermissionSeeder;
use RoleSeeder;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        $this->seed([
            PermissionSeeder::class,
            RoleSeeder::class
        ]);
    }

    private $categories = [
        'RopaTest','ZapatosTest','DeportesTest','AccesoriosTest'
    ];

    public function testShow()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => now()
        ]);
        factory(Cart::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get(route('cart.show', $user));

        $response
            ->assertViewIs('web.users.cart.show')
            ->assertViewHas('cart');
    }

    public function testAnUserUnVerifiedCannotViewCart()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => null
        ]);

        $response = $this->actingAs($user)->get(route('cart.show', $user));

        $response
            ->assertRedirect(route('verification.notice'));
    }

    public function testAnuserCanAddItemToCart()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => now()
        ]);

        $cart = factory(Cart::class)->create([
            'user_id' => $user->id
        ]);

        $stock = $this->createProductRelations();

        $response = $this->actingAs($user)->post(route('cart.add', $user),
            [
                'product_id' => $stock->product_id,
                'size_id' => $stock->size->id,
                'color_id' => $stock->color->id,
                'quantity' => 2
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('cart_stock',
        [
            'cart_id' => $user->cart->id,
            'stock_id' => $stock->id,
            'quantity' => 2
        ]);
    }
    public function testAnuserCanRemoveitemToCart()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => now()
        ]);

        factory(Cart::class)->create([
            'user_id' => $user->id
        ]);

        $stock = $this->createProductRelations();

        $user->cart->stocks()->attach($stock->id, ['quantity' => 2]);

        $response = $this->actingAs($user)->delete(route('cart.remove',
            [ $user, $stock ]));

        $response->assertStatus(302);

        $this->assertDatabaseMissing('cart_stock',
            [
                'cart_id' => $user->cart->id,
                'stock_id' => $stock->id,
                'quantity' => 2
            ]);
    }


    public function createProductRelations(): Stock
    {
        foreach ($this->categories as $name) {
            factory(Category::class)->create([
                'name' => $name,
                'id_parent' => null
            ]);
        }
        factory(Category::class, 2)->create();
        $tag = factory(Tag::class)->create();
        $product = factory(Product::class)->create();
        $product->tags()->attach($tag->id);
        factory(Photo::class, rand(1, 5))->create([
            'product_id' => $product->id
        ]);
        factory(TypeSize::class)->create();
        factory(Size::class)->create();
        factory(Color::class)->create();

        return factory(Stock::class)->create([
            'quantity' => 5
        ]);
    }
}
