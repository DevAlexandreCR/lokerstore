<?php

namespace Tests\Feature\Http\Controllers\Admin\Auth;

use App\Models\Admin\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    use RefreshDatabase;
    
    public function testSendLinkResetPassword()
    {
        // $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create();
        $response = $this->post('admin/password/email', [
            'email' => $admin->email,
        ]);
        $response->assertSessionHas('status');
    }
}
