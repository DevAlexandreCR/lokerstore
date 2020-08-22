<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Admin\Admin;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $categories = [
        'RopaTest','ZapatosTest','DeportesTest','AccesoriosTest'
    ];

    /**
     * test view products
     *
     * @return void
     */
    public function testIndex()
    {
        $admin = factory(Admin::class)->create();

        $response = $this->actingAs($admin, 'admin')->get(route('products.index'));

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products');
    }

    public function testIndexWithQuery()
    {
        $admin = factory(Admin::class)->create();
        $tag = factory(Tag::class)->create();

        foreach ($this->categories as $name) {
            factory(Category::class)->create([
                'name' => $name,
                'id_parent' => null
            ]);
        }
        factory(Category::class, 2)->create();
        $product = factory(Product::class)->create([
            'name' => 'new product'
        ]);
        $product->tags()->attach($tag->id);

        $response = $this
                        ->actingAs($admin, 'admin')
                        ->get(route('products.index'), [
                                'category' => 1,
                                'orderBy' => __('Less recent'),
                                'search' => 'new',
                                'tags' => null
                        ]);

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products');
    }

    public function testEditProduct()
    {
        $admin = factory(Admin::class)->create();

        foreach ($this->categories as $name) {
            factory(Category::class)->create([
                'name' => $name,
                'id_parent' => null
            ]);
        }
        factory(Category::class, 2)->create();
        $product = factory(Product::class)->create();

        $response = $this->actingAs($admin, 'admin')->get(route('products.edit', [
            'product' => $product->id
        ]));

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.products.edit')
            ->assertViewHas('product');
    }

    /**
     * test route admin/products/$product->id/edit
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
        $category = factory(Category::class)->create();
        $tag = factory(Tag::class)->create();

        $response = $this->actingAs($admin, 'admin')->post(route('products.store'),
        [
            'name'          =>  'new product',
            'description'   =>  'new description at product incoming',
            'stock'         =>  0,
            'price'         =>  2000,
            'id_category'   => $category->id,
            'tags'          => [$tag->id],
            'photos'        => [$this->faker->file(storage_path('app/public/photos'))]
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('stocks.create', Product::first()));

        $this->assertDatabaseHas('products', [
            'name'          =>  'new product',
            'description'   =>  'new description at product incoming',
            'stock'         =>  '0',
            'price'         =>  2000,
            'id_category'   => $category->id,
        ]);
    }

    /**
     * test update product
     *
     * @return void
     */
    public function testUpdateProduct()
    {
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

        $response = $this->actingAs($admin, 'admin')->put(route('products.update', [
            'product' =>  $product
        ]), [
            'name'          => 'mi nuevo super producto',
            'description'   => $product->description,
            'stock'         => $product->stock,
            'price'         => $product->price,
            'id_category'   => $product->id_category,
            'tags'          => [$tag->id],
        ]);

        $response
            ->assertRedirect(route('products.edit', ['product' => $product]))
            ->assertSessionHas('product-updated')
            ->assertStatus(302);
        $this->assertDatabaseHas('products', ['name' => 'mi nuevo super producto']);
    }

    /**
     * test delete product
     *
     * @return void
     */
    public function testDeleteProduct()
    {
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

        $response = $this->actingAs($admin, 'admin')->delete(route('products.destroy', [
            'product' => $product
        ]));

        $response->assertRedirect(route('products.index'))
            ->assertSessionHas('product-deleted')
            ->assertStatus(302);
    }
}
