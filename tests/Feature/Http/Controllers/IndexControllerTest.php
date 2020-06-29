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
    
    // /**
    //  * Funcion para testear la ruta principal de la aplicacion
    //  * Verifica que la vista tenga los productos cargados
    //  * @return void
    //  */
    // public function testIndex()
    // {
    //     // $this->withoutExceptionHandling();

    //     /** creamos categorias para luego poder crear productos */
    //     factory(Category::class)->create([
    //         'name' => 'Camisetas'
    //     ]);
    //     factory(Category::class)->create([
    //         'name' => 'Pantalones'
    //     ]);
    //     factory(Category::class)->create([
    //         'name' => 'Busos'
    //     ]);
    //     factory(Category::class)->create([
    //         'name' => 'Accesorios'
    //     ]);
    //     factory(Product::class, 10)->create();
    //     $response = $this->get('/');

    //     $response->assertViewIs('index')  
    //         ->assertViewHas('products') /** probamos que la viste cargue los productos */    
    //         ->assertStatus(200);
    // }

    /**
     * Prueba para notificar mediante una alerta en pantalla al usuario
     * sobre la verificacion del email
     *
     * @return void
     */
    public function testIndexNoVerified()
    {
        // $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertViewIs('index')  
            ->assertSessionHas('verify_email') /** probamos que la vista cargue el mensaje de solicitud de verificacion delcorreo electronico */    
            ->assertStatus(200);
    }
}
