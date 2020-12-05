<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Constants\Roles;
use App\Models\Admin\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->seed([
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);
        $this->admin = factory(Admin::class)->create();
        $this->admin->syncRoles(Roles::ADMIN);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->get(route('admins.index'));

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.admins.index')
            ->assertViewHas('admins');
    }

    public function testStore(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->post(route('admins.store'), [
            'name' => 'employee 1',
            'email' => 'employee1@example.com',
            'password' => '12345678',
            'is_active' => true,
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('admins.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('admins', [
            'name' => 'employee 1',
            'email' => 'employee1@example.com',
            'password' => Hash::check('12345678', '12345678'),
            'is_active' => 1,
        ]);
    }

    public function testShow(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->get(route('admins.show', $this->admin->id));

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.admins.show')
            ->assertViewHas('admin')
            ->assertViewHas('roles');
    }

    public function testUpdate(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->put(route('admins.update', $this->admin->id), [
            'name' => 'admin updated',
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('admins.show', $this->admin->id))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('admins', [
            'name' => 'admin updated',
            'email' => $this->admin->email,
            'is_active' => 1,
        ]);
    }

    public function testDestroy(): void
    {
        $admin2 = factory(Admin::class)->create();
        $response = $this->actingAs($this->admin, 'admin')->delete(route('admins.destroy', $admin2->id));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('admins.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('admins', [
            'id' => $admin2->id,
            'name' => $admin2->name,
            'email' => $admin2->email,
        ]);
    }

    public function testAnAdminCanUpdateApiTokenToEmployees(): void
    {
        $admin2 = factory(Admin::class)->create();
        $api_token = $admin2->api_token;
        $response = $this->actingAs($this->admin, 'admin')->put(route('admins.update_token', $admin2->id));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('admins.show', $admin2->id))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('admins', [
            'api_token' => $api_token
        ]);
    }
}
