<?php

namespace Tests\Feature\Policies;

use App\Constants\Admins;
use App\Constants\Permissions;
use App\Constants\Roles;
use App\Models\Admin\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use PermissionSeeder;
use RoleSeeder;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminPolicyTest extends TestCase
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

    public function testIndexNotAuthorized(): void
    {
        $response = $this->actingAs($this->admin, Admins::GUARDED)->get(route('admins.index'));

        $response->assertStatus(403);
    }

    public function testAdminWithoutPermissionCannotUpdateAdmins(): void
    {
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->put(route('admins.update', $this->admin->id));

        $response->assertStatus(403);
    }

    public function testAdminWithoutPermissionCannotViewAdmin(): void
    {
        $admin2 = factory(Admin::class)->create();
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->get(route('admins.show', $admin2->id));

        $response->assertStatus(403);
    }

    public function testAdminWithoutPermissionCanViewYourProfile(): void
    {
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->get(route('admins.show', $this->admin->id));

        $response->assertStatus(200);
    }

    public function testAdminWithoutPermissionCannotDeleteAdmin(): void
    {
        $admin2 = factory(Admin::class)->create();
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->delete(route('admins.destroy', $admin2->id));

        $response->assertStatus(403);
    }

    public function testAdminWithoutPermissionCannotCreateAdmins(): void
    {
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->post(route('admins.store'), [
                'name' => 'admin 2',
                'email' => 'text@email.com',
                'password' => Hash::make('12345678'),
                'is_active' => true
            ]);

        $response->assertStatus(403);
    }

    public function testAllRoleRoutesWithPermissions(): void
    {
        $id = Admin::all()->random()->id;
        $role = factory(Role::class)->create();

        $role->syncPermissions([
            Permissions::VIEW_ADMINS,
            Permissions::CREATE_ADMINS,
            Permissions::EDIT_ADMINS,
            Permissions::DELETE_ADMINS,
        ]);

        $this->admin->assignRole($role->name);

        $this->actingAs($this->admin, Admins::GUARDED)
            ->get(route('admins.index'))->assertStatus(200);

        $this->actingAs($this->admin, Admins::GUARDED)
            ->put(route('admins.update', $id))->assertStatus(302);

        $this->actingAs($this->admin, Admins::GUARDED)
            ->delete(route('admins.destroy', $id))->assertStatus(302);

        $this->actingAs($this->admin, Admins::GUARDED)->post(route('admins.store', $id), [
            'name' => 'admin 2',
            'email' => 'text@email.com',
            'password' => Hash::make('12345678'),
            'is_active' => true
        ])->assertStatus(302);
    }
}
