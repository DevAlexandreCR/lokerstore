<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->json('GET', 'api/products');

        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'created_at', 'updated_at']
            ]
        ]);
    }

    public function testShow()
    {
        $user = factory(User::class)->create();

        /** creamos categorias para luego poder crear productos */
        $categories = ['Ropa', 'Zapatos', 'Deportes', 'Accesorios'];

        foreach ($categories as $cat) {
            factory(Category::class)->create([
                'name' => $cat,
                'id_parent' => null
            ]); 
        }

        factory(Category::class, 10)->create();
        factory(Product::class, 10)->create();
        
        $response = $this->actingAs($user)->json('GET', 'api/products/1');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['id', 'name', 'created_at', 'updated_at']
        ]);
    }
}
