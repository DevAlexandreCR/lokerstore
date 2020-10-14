<?php

namespace Tests\Feature\Policies;

use App\Constants\Admins;
use App\Constants\Permissions;
use App\Models\Admin\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PermissionSeeder;
use RoleSeeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PermissionsPolicyTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->seed([
            PermissionSeeder::class,
            RoleSeeder::class
        ]);
        $this->admin = factory(Admin::class)->create();
    }


    public function testAdminWithoutPermissionCannotCreatePermissions(): void
    {
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->post(route('permissions.store'), [
                'name' => 'test permission'
            ]);

        $response->assertStatus(403);
    }

    public function testAdminWithoutPermissionCannotUpdatePermissions(): void
    {
        $id = Permission::all()->random()->id;
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->put(route('permissions.update', $id), [
                'name' => 'update permission'
            ]);

        $response->assertStatus(403);
    }

    public function testAdminWithoutPermissionCannotDeletePermissions(): void
    {
        $id = Permission::all()->random()->id;
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->delete(route('permissions.destroy', $id));

        $response->assertStatus(403);
    }

    public function testAllPermissionsRoutesWithPermissions(): void
    {
        $id = Permission::all()->random()->id;
        $role = factory(Role::class)->create();

        $role->syncPermissions([
            Permissions::VIEW_PERMISSIONS,
            Permissions::DELETE_PERMISSIONS,
            Permissions::EDIT_PERMISSIONS,
            Permissions::CREATE_PERMISSIONS,
        ]);

        $this->admin->assignRole($role->name);

        $this->actingAs($this->admin, Admins::GUARDED)
            ->put(route('permissions.update', $id), [
                'name' => 'updated permission'
            ])->assertStatus(302);

        $this->actingAs($this->admin, Admins::GUARDED)
            ->delete(route('permissions.destroy', $id))->assertStatus(302);

        $this->actingAs($this->admin, Admins::GUARDED)->post(route('permissions.store', $id), [
            'name' => 'test role'
        ])->assertStatus(302);
    }
}
