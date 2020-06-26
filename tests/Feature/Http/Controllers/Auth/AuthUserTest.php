<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthUserTest extends TestCase
{
    /**
     * Prueba para verificar que el Login NO permita
     * acceso a usuarios inhabilitados
     *
     * @return void
     */
    public function testLoginNoActiveUser()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'secret'),
            'is_active' => false
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test para verificar que al registrar redireccione al usuario
     * para que verifique su correo
     *
     * @return void
     */
    public function testResgister()
    {
        $user = [
            'name' => 'root',
            'email' => 'mail@lokerstore.com',
            'phone' => '0000000000',
            'address' => 'fake address',
            'password' => '12345678',
            'password_confirmation' => '12345678'
          ];
      
        $response = $this->post('register', $user);

        $response->assertRedirect('email/verify');
   
        //quitamos password y password_confirmation del array
        array_splice($user,4, 2);

        $this->assertDatabaseHas('users', $user);
    }

    /**
     * test para probar que usuarios inhabilitados no puedan ingresar al index
     *
     * @return void
     */
    public function testUserDisabledindex()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'secret'),
            'is_active' => false
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertRedirect('/disabled-user');
    }
}
