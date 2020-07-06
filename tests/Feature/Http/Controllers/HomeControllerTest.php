<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Admin\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
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
        $response = $this->get( route('index') );

        $response->assertRedirect( route('home'));
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
            ->assertStatus(200);
    }

    public function testRedirectIfAuthenticatedUser()
    {        
        $user = factory(User::class)->create([
            'is_active' => true
        ]);
        $response = $this->actingAs($user)->get( route('index') );

        $response->assertRedirect( route('home'));
    }

    public function testRedirectIfAuthenticatedAdmin()
    {        
        $admin = factory(Admin::class)->create();
        $response = $this->actingAs($admin, 'admin')->get( route('index') );

        $response->assertRedirect( route('admin.home'));
    }
}
