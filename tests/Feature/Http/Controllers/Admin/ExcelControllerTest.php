<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Constants\Admins;
use App\Constants\Roles;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Models\Admin\Admin;
use Database\Seeders\TestDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Maatwebsite\Excel\Facades\Excel;
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
            TestDatabaseSeeder::class,
        ]);
        Queue::fake();
        Excel::fake();
        $this->admin = factory(Admin::class)->create();
        $this->admin->assignRole(Roles::ADMIN);
    }

    public function testAnAdminAuthenticatedWithPermissionsCanExportProducts(): void
    {
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->get(route('products.export'));

        $response
            ->assertStatus(302);

        Excel::matchByRegex();

        Excel::assertStored('/products_\d{4}-\d{2}-\d{2}.xlsx/', 'exports');

        Excel::assertQueued('/products_\d{4}-\d{2}-\d{2}.xlsx/', 'exports', function (ProductsExport $export) {
            return true;
        });
    }

    public function testAnAdminAuthenticatedWithPermissionsCanImportProducts(): void
    {
        $this->withoutExceptionHandling();
        $file = new UploadedFile(
            base_path('tests/stubs/imports/products.xlsx'),
            'products.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->post(route('products.import'), [
                'file' => $file,
            ]);

        $response
            ->assertStatus(302);

        Excel::assertQueued($file->getFilename(), 'imports', function (ProductsImport $import) {
            return true;
        });
    }

    public function testAnAdminAuthenticatedWithPermissionsCanImportImages(): void
    {
        $this->withoutExceptionHandling();

        $file = UploadedFile::fake()->image('test.jpeg');
        $file2 = UploadedFile::fake()->image('test2.jpeg');

        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->post(route('products.import_images'), [
                'images' => [$file, $file2],
            ]);

        $response
            ->assertStatus(302);
    }
}
