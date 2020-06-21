<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Funcion para testear la ruta principal de la aplicacion
     * Verifica que la vista tenga los productos cargados
     * @return void
     */
    public function testIndex()
    {
        // $this->withoutExceptionHandling();

        /** creamos categorias para luego poder crear productos */
        factory(Category::class, 4)->create();
        factory(Product::class, 10)->create();
        $response = $this->get('/');
        $response->assertViewIs('index')  
            ->assertViewHas('products') /** probamos que la viste cargue los productos */    
            ->assertStatus(200);
    }
}
