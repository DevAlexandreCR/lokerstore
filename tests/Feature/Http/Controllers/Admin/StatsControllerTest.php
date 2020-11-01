<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Constants\Roles;
use App\Constants\Admins;
use App\Models\Admin\Admin;
use Tests\TestCase;
use TestDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatsControllerTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->seed([
            TestDatabaseSeeder::class,
        ]);

        $this->admin = factory(Admin::class)->create();
        $this->admin->assignRole(Roles::ADMIN);
    }

    public function testAnAdminAuthenticatedCanViewHome(): void
    {
        $response = $this->actingAs($this->admin, Admins::GUARDED)->get(route('admin.home'));

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.stats');
    }

    public function testAnAdminAuthenticatedWithPermissionsCanGenerateReports(): void
    {
        $response = $this->actingAs($this->admin, Admins::GUARDED)->post(route('admin.reports'), [
            'from' => now()->subYear()->format('Y-m-d'),
            'to'   => now()->format('Y-m-d')
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('admin.home'));
    }
}
