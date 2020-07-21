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
        $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create();

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
        $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($admin, 'admin')->put("admin/users/$user->id", [
            'email' => 'elnuevoemail@nada.com'
        ]);

        $response
            ->assertRedirect("admin/users/$user->id")
            ->assertSessionHas('user-updated')
            ->assertStatus(302);
        $this->assertDatabaseHas('users', ['email' => 'elnuevoemail@nada.com']);
    }

    /**
     * test delete user
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $admin = factory(Admin::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($admin, 'admin')->delete("admin/users/$user->id");

        $response->assertRedirect('admin/users')
            ->assertSessionHas('user-deleted')
            ->assertStatus(302); 
    }

    /**
     * prueba de busqueda correcta en users por nombre-email-telefono
     *
     * @return void
     */
    public function testSearchUser()
    {
        $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create();
        factory(User::class)->create([
            'name' => 'jose',
            'email' => 'jose@gmail.com'
        ]);
        factory(User::class)->create([
            'name' => 'jose manuel',
            'email' => 'josefina@gmail.com'
        ]);

        $query = 'jos';
        $response = $this->actingAs($admin, 'admin')->get( route('users.index', ['search' => $query]));

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.users.index')
            ->assertViewHas('user_found')
            ->assertViewHas('users');
    }

    /**
     * prueba para busqueda fallida de users
     *
     * @return void
     */
    public function testSearchUserNotFound()
    {
        $admin = factory(Admin::class)->create();
        factory(User::class)->create([
            'name' => 'jose',
            'email' => 'jose@gmail.com'
        ]);
        factory(User::class)->create([
            'name' => 'jose manuel',
            'email' => 'josefina@gmail.com'
        ]);

        $query = 'martha';
        $response = $this->actingAs($admin, 'admin')->get( route('users.index', ['search' => $query]));

        $response
            ->assertViewHas('user_not_found');
    }
}
