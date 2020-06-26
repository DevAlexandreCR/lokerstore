<?php

namespace Tests\Feature\Http\Controllers\Admin\Auth;

use App\Models\Admin\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthAdminTest extends TestCase
{
    public function testLoginAdmin() 
    {
        // $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create([
            'password' => bcrypt($password = 'secret'),
            'is_active' => true
        ]);

        $response = $this->post('admin/login', [
            'email' => $admin->email,
            'password' => $password
        ]);

        $response->assertRedirect('admin/');
        $response->assertSessionHasNoErrors();
    }

    public function testHomeAdminNotAuthenticated() 
    {
        $response = $this->get('admin/');

        $response->assertRedirect('admin/login');
        $this->assertGuest();
    }
}
