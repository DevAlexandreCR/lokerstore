<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Constants\Roles;
use App\Models\Admin\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PermissionSeeder;
use RoleSeeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->withoutExceptionHandling();

        $this->seed([
            PermissionSeeder::class,
            RoleSeeder::class
        ]);

        $this->admin = factory(Admin::class)->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->get(route('roles.index'));

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.roles.index')
            ->assertViewHas(['roles', 'permissions']);
    }

    public function testStore(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->post(route('roles.store'), [
            'name' => 'new Role',
            'guard_name'   => 'admin'
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('roles.index'))
            ->assertSessionHas('success')
            ->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('roles', [
            'name' => 'new Role'
        ]);
    }

    public function testUpdate(): void
    {
        $role = Role::create([
            'name' => 'new Role',
            'guard_name' => 'admin'
        ]);
        $response = $this->actingAs($this->admin, 'admin')->put(route('roles.update', $role->id), [
            'name' => 'new Role updated'
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('roles.index'))
            ->assertSessionHas('success')
            ->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'new Role updated'
        ]);
    }

    public function testDestroy(): void
    {
        $role = Role::create([
            'name' => 'new Role',
            'guard_name' => 'admin'
        ]);
        $response = $this->actingAs($this->admin, 'admin')->delete(route('roles.destroy', $role->id));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('roles.index'))
            ->assertSessionHas('success')
            ->assertSessionDoesntHaveErrors();

        $this->assertDatabaseMissing('roles', [
            'id' => $role->id,
            'name' => 'new Role'
        ]);
    }

    public function testUpdatePermissionsToRole(): void
    {
        $role = Role::create([
            'name' => 'new Role',
            'guard_name' => 'admin'
        ]);

        $permission = Permission::create([
            'name' => 'permission',
            'guard_name' => 'admin'
        ]);

        $response = $this->actingAs($this->admin, 'admin')->put(route('roles.update', $role->id), [
            'permissions' => [
                'name' => $permission->name
            ]
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('roles.index'))
            ->assertSessionHas('success')
            ->assertSessionDoesntHaveErrors();

        $this->assertTrue($role->hasDirectPermission($permission->name));
    }
}
