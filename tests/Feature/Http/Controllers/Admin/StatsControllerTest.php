<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Constants\Admins;
use App\Constants\Roles;
use App\Exports\MonthlyReportsExport;
use App\Exports\ReportsExport;
use App\Models\Admin\Admin;
use App\Models\Order;
use App\Models\OrderDetail;
use Database\Seeders\AdminSeeder;
use Database\Seeders\TestDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Maatwebsite\Excel\Facades\Excel;
use Database\Seeders\StockSeeder;
use Tests\TestCase;
use Database\Seeders\UserSeeder;

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
        Queue::fake();
        Excel::fake();
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

    public function testAnAdminAuthenticatedWithPermissionsCanGenerateMonthlyReports(): void
    {
        $this->withoutExceptionHandling();
        $this->seed([
            UserSeeder::class,
            StockSeeder::class,
            AdminSeeder::class,
        ]);
        factory(Order::class, 20)->create();
        factory(OrderDetail::class, 50)->create();
        $response = $this->actingAs($this->admin, Admins::GUARDED)->post(route('admin.monthly_report'), [
            'date' => now()->subYear()->format('Y-m'),
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('admin.home'));

        Excel::matchByRegex();
        Excel::assertStored('/report_monthly_\d{10}.xlsx/', 'exports');
        Excel::assertQueued('/report_monthly_\d{10}.xlsx/', 'exports', function (MonthlyReportsExport $export) {
            return true;
        });
    }

    public function testAnAdminAuthenticatedWithPermissionsCanGenerateReports(): void
    {
        $this->seed([
            UserSeeder::class,
            StockSeeder::class,
            AdminSeeder::class,
        ]);
        factory(Order::class, 20)->create();
        factory(OrderDetail::class, 50)->create();
        $response = $this->actingAs($this->admin, Admins::GUARDED)->post(route('admin.reports'), [
            'from' => now()->subYear()->format('Y-m-d'),
            'to'   => now()->format('Y-m-d'),
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('admin.home'));

        Excel::matchByRegex();
        Excel::assertStored('/report_\d{10}.xlsx/', 'exports');
        Excel::assertQueued('/report_\d{10}.xlsx/', 'exports', function (ReportsExport $export) {
            return true;
        });
    }
}
