<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Admin\Admin;
use App\Models\Category;
use App\Models\Color;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Size;
use App\Models\Stock;
use App\Models\Tag;
use App\Models\TypeSize;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockControllerTest extends TestCase
{
    use RefreshDatabase;

    private $categories = [
        'RopaTest','ZapatosTest','DeportesTest','AccesoriosTest'
    ];
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStore()
    {
        $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create();
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
        $size = factory(Size::class)->create();
        $color = factory(Color::class)->create();

        $response = $this->actingAs($admin, 'admin')->post( route('stocks.store') , [
            'product_id' => $product->id,
            'color_id' => $color->id,
            'size_id' => $size->id,
            'quantity' => 3
        ]);

        $response
                ->assertStatus(302);
        $this->assertDatabaseHas('stocks',
        [
            'product_id' => $product->id,
            'color_id' => $color->id,
            'size_id' => $size->id
        ]);

        $this->assertDatabaseHas('products',
        [
            'stock' => 3
        ]);
    }

    public function testUpdate()
    {
        $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create();
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
        $stock = factory(Stock::class)->create([
            'quantity' => 5
        ]);

        $response = $this->actingAs($admin, 'admin')->put( route('stocks.update', $stock) , [
            'quantity' => 0
        ]);

        $response
                ->assertStatus(302);
        $this->assertDatabaseHas('stocks',
        [
            'product_id' => $product->id,
            'quantity' => 0
        ]);

        $this->assertDatabaseHas('products',
        [
            'id' => $product->id,
            'stock' => 0,
            'is_active' => 0
        ]);
    }

    public function testDestroy()
    {
        $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create();
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
        $stock = factory(Stock::class)->create([
            'quantity' => 5
        ]);

        $response = $this->actingAs($admin, 'admin')->delete( route('stocks.destroy', $stock));

        $response
                ->assertStatus(302);
        $this->assertDatabaseMissing('stocks',
        [
            'id' => $stock->id,
            'product_id' => $product->id,
            'quantity' => 5
        ]);

        $this->assertDatabaseHas('products',
        [
            'id' => $product->id,
            'stock' => 0,
            'is_active' => 0
        ]);
    }

    public function testAddStocksRepeated()
    {
        $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create();
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
        $size = factory(Size::class)->create();
        $color = factory(Color::class)->create();
        factory(Stock::class)->create(
            [
                'product_id' => $product->id,
                'color_id' => $color->id,
                'size_id' => $size->id,
                'quantity' => 3
            ]
        );

        $response = $this->actingAs($admin, 'admin')->post( route('stocks.store') , [
            'product_id' => $product->id,
            'color_id' => $color->id,
            'size_id' => $size->id,
            'quantity' => 3
        ]);

        $response
            ->assertStatus(302);
        $this->assertDatabaseHas('stocks',
            [
                'product_id' => $product->id,
                'color_id' => $color->id,
                'size_id' => $size->id,
                'quantity' => 6
            ]);

        $this->assertDatabaseHas('products',
            [
                'stock' => 6
            ]);
    }
}
