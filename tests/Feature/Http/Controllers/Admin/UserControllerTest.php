<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Constants\Roles;
use App\Models\Admin\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->withoutExceptionHandling();
        $this->seed([
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);
        $this->admin = factory(Admin::class)->create();

        $this->admin->assignRole(Roles::ADMIN);
    }

    /**
     * test view users
     *
     * @return void
     */
    public function testIndex(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->get('admin/users');

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
    public function testShowUser(): void
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($this->admin, 'admin')->get(route('users.show', $user->id));

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
    public function testEditUser(): void
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($this->admin, 'admin')->get(route('users.edit', $user->id));

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
    public function testUpdateUser(): void
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($this->admin, 'admin')->put(
            route('users.update', $user),
            [
                'email' => 'elnuevoemail@nada.com',
            ]
        );

        $response
            ->assertRedirect(route('users.show', $user))
            ->assertSessionHas('user-updated')
            ->assertStatus(302);
        $this->assertDatabaseHas('users', ['email' => 'elnuevoemail@nada.com']);
    }

    /**
     * test delete user
     *
     * @return void
     */
    public function testDeleteUser(): void
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($this->admin, 'admin')->delete(route('users.destroy', $user));

        $response->assertRedirect('admin/users')
            ->assertSessionHas('user-deleted')
            ->assertStatus(302);
    }

    /**
     * prueba de busqueda correcta en users por nombre-email-telefono
     *
     * @return void
     */
    public function testSearchUser(): void
    {
        factory(User::class, 30)->create();
        factory(User::class)->create([
            'name' => 'jose',
            'email' => 'jose@gmail.com',
        ]);
        factory(User::class)->create([
            'name' => 'jose manuel',
            'email' => 'josefina@gmail.com',
        ]);

        $query = 'jos';
        $response = $this->actingAs($this->admin, 'admin')->get(route('users.index', ['search' => $query]));

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.users.index')
            ->assertViewHas('user_found')
            ->assertViewHas('users')
            ->assertSee('jose@gmail.com')
            ->assertSee('josefina@gmail.com');
    }

    /**
     * prueba para busqueda fallida de users
     *
     * @return void
     */
    public function testSearchUserNotFound(): void
    {
        factory(User::class)->create([
            'name' => 'jose',
            'email' => 'jose@gmail.com',
        ]);
        factory(User::class)->create([
            'name' => 'jose manuel',
            'email' => 'josefina@gmail.com',
        ]);

        $query = 'martha';
        $response = $this->actingAs($this->admin, 'admin')->get(route('users.index', ['search' => $query]));

        $response
            ->assertViewHas('user_not_found');
    }

    public function testAnAdminCanSendEmailVerification(): void
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.user.verify', $user->id));

        $response
            ->assertStatus(302)
            ->assertSessionHas('status');
    }
}
