<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    private $categories = [
        'RopaTest','ZapatosTest','DeportesTest','AccesoriosTest',
    ];
    /**
     * test get all categories api
     *
     * @return void
     */
    public function testIndex(): void
    {
        foreach ($this->categories as $cat) {
            factory(Category::class)->create([
                'name' => $cat,
                'id_parent' => null,
            ]);
        }

        factory(Category::class, 10)->create();
        factory(Product::class, 10)->create();

        $response = $this->json('GET', route('categories.index'));

        $response->assertStatus(200);
    }

    /**
     * test get a categoy especific
     *
     * @return void
     */
    public function testShow(): void
    {
        $category = factory(Category::class)->create([
            'name' => 'category',
            'id_parent' => null,
        ]);

        $response = $this->json('GET', route('categories.show', ['category' => $category->id]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['id', 'name', 'id_parent'],
        ]);
    }
}
