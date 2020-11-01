<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Admin\Admin;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PermissionSeeder;
use RoleSeeder;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->seed([
            PermissionSeeder::class,
            RoleSeeder::class
        ]);
    }

    /**
     * Funcion para testear la ruta principal de la aplicacion
     * @return void
     */
    public function testIndex(): void
    {
        $response = $this->get( route('index') );

        $response->assertRedirect( route('home'));
    }

    /**
     * Prueba para notificar mediante una alerta en pantalla al usuario
     * sobre la verificacion del email
     *
     * @return void
     */
    public function testIndexNoVerified(): void
    {
        $user = factory(User::class)->create([
            'is_active' => true
        ]);
        $cart = new Cart();

        $cart->user_id = $user->id;
        $cart->save();

        $response = $this->actingAs($user)->get( route('home') );

        $response
            ->assertStatus(200);
    }

    public function testRedirectIfAuthenticatedUser(): void
    {
        $user = factory(User::class)->create([
            'is_active' => true
        ]);
        $cart = new Cart();
        $cart->user_id = $user->id;
        $cart->save();
        $response = $this->actingAs($user)->get( route('index') );

        $response->assertRedirect( route('home'));
    }

    public function testRedirectIfAuthenticatedAdmin(): void
    {
        $admin = factory(Admin::class)->create();
        $response = $this->actingAs($admin, 'admin')->get( route('index') );

        $response->assertRedirect( route('admin.home'));
    }
}
