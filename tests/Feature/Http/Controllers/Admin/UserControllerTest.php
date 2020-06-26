<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Admin\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * test view users
     *
     * @return void
     */
    public function testIndex()
    {
        $admin = factory(Admin::class)->create();
        // dd($admin->toArray());
        $response = $this->actingAs($admin, 'admin')->get('admin/users');

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.users.index')
            ->assertViewHas('users');
    }

    /**
     * prueba ruta admin/users/$user->id
     *
     * @return void
     */
    public function testShowUser()
    {
        $admin = factory(Admin::class)->create();
        $user = factory(User::class)->create();
        // dd($admin->toArray());
        $response = $this->actingAs($admin, 'admin')->get("admin/users/$user->id");

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.users.show')
            ->assertViewHas('user');
    }

    /**
     * test route admin/users/$user->id/edit
     *
     * @return void
     */
    public function testEditUser()
    {
        $admin = factory(Admin::class)->create();
        $user = factory(User::class)->create();
        // dd($admin->toArray());
        $response = $this->actingAs($admin, 'admin')->get("admin/users/$user->id/edit");

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.users.edit')
            ->assertViewHas('user');
    }

    /**
     * test update user 
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $admin = factory(Admin::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($admin, 'admin')->put("admin/users/$user->id", [
            'email' => 'elnuevoemail@nada.com'
        ]);

        $response
            ->assertRedirect("admin/users/$user->id")
            ->assertSessionHas('updated')
            ->assertStatus(302);
        $this->assertDatabaseHas('users', ['email' => 'elnuevoemail@nada.com']);
    }

    /**
     * test delete user
     *
     * @return void
     */
    public function testdeleteUser()
    {
        // $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($admin, 'admin')->delete("admin/users/$user->id");

        $response->assertRedirect('admin/users')
            ->assertSessionHas('deleted')
            ->assertStatus(302); 
    }
}
