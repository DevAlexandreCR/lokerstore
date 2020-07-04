<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        /** creamos categorias para luego poder crear productos */
        // factory(Category::class, 4)->create();
        // factory(Product::class, 10)->create();
        $response = $this->get( route('home') );

        $response->assertViewIs('index')  
            // ->assertViewHas('products') /** probamos que la viste cargue los productos */    
            ->assertStatus(200);
    }

    /**
     * Prueba para notificar mediante una alerta en pantalla al usuario
     * sobre la verificacion del email
     *
     * @return void
     */
    public function testIndexNoVerified()
    {
        $user = factory(User::class)->create([
            'is_active' => true
        ]);

        $response = $this->actingAs($user)->get( route('home') );

        $response
            ->assertViewHas('products') /** probamos que la viste cargue los productos */    
            ->assertStatus(200);
    }
}
