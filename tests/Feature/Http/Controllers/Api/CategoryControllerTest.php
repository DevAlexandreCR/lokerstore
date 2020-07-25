<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test get all categories api
     *
     * @return void
     */
    public function testIndex()
    {
        $this->withoutExceptionHandling();
        /** creamos categorias para luego poder crear productos */
        $categories = ['Ropa', 'Zapatos', 'Deportes', 'Accesorios'];

        foreach ($categories as $cat) {
            factory(Category::class)->create([
                'name' => $cat,
                'id_parent' => null
            ]); 
        }

        factory(Category::class, 10)->create();
        factory(Product::class, 100)->create();
        
        $response = $this->json('GET', route('categories.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'created_at', 'updated_at', 'id_parent']
            ]
        ]);
    }

    // public function testStore()
    // {
    //     //
    // }

    /**
     * test get a categoy especific
     *
     * @return void
     */
    public function testShow()
    {
        $category = factory(Category::class)->create([
            'name' => 'Zapatos',
            'id_parent' => null
        ]); 
        
        $response = $this->json('GET', route('categories.show',['category' => $category->id]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['id', 'name', 'id_parent']
        ]);
    }

    // public function testUpdate()
    // {
    //     //
    // }

    // public function testDestroy()
    // {
    //     //
    // }
}
