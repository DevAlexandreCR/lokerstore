<?php

namespace Tests\Feature\Http\Controllers\Admin;

use TestDatabaseSeeder;
use App\Constants\Roles;
use App\Constants\Admins;
use App\Models\Admin\Admin;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExcelControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private Admin $admin;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->withoutExceptionHandling();
        $this->seed([
            TestDatabaseSeeder::class
        ]);
        Queue::fake();
        Excel::fake();
        $this->admin = factory(Admin::class)->create();
        $this->admin->assignRole(Roles::ADMIN);
    }

//    public function testAnAdminAuthenticatedWithPermissionsCanExportProducts(): void
//    {
//        $response = $this->actingAs($this->admin, Admins::GUARDED)
//            ->get(route('products.export'));
//
//        $response
//            ->assertStatus(302);
//
//        Excel::matchByRegex();
//
//        Excel::assertStored('/products_\d{4}-\d{2}-\d{2}.xlsx/', 'exports');
//
//        Excel::assertQueued('/products_\d{4}-\d{2}-\d{2}.xlsx/', 'exports',function(ProductsExport $export) {
//            return true;
//        });
//    }
}
