<?php

namespace Tests\Feature\Policies;

use App\Constants\Admins;
use App\Constants\Permissions;
use App\Models\Admin\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Database\Seeders\TestDatabaseSeeder;
use Tests\TestCase;

class ProductsPolicyTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->seed([
            TestDatabaseSeeder::class,
        ]);

        $this->admin = factory(Admin::class)->create();
    }

    public function testIndexNotAuthorized(): void
    {
        $response = $this->actingAs($this->admin, Admins::GUARDED)->get(route('products.index'));

        $response->assertStatus(403);
    }

    public function testAdminWithoutPermissionCannotCreateProducts(): void
    {
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->post(route('products.store'), [
                'name'          =>  'new product',
                'description'   =>  'new description at product incoming',
                'stock'         =>  0,
                'price'         =>  2000,
                'id_category'   => Category::all()->random()->id,
                'tags'          => [Tag::all()->random()->id],
                'Photos'        => [$this->faker->file(storage_path('app/public/photos'))],
            ]);

        $response->assertStatus(403);
    }

    public function testAdminWithoutPermissionCannotUpdateProducts(): void
    {
        $id = factory(Product::class)->create()->id;
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->put(route('products.update', $id));

        $response->assertStatus(403);
    }

    public function testAdminWithoutPermissionCannotEnableProducts(): void
    {
        $id = factory(Product::class)->create()->id;

        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->put(route('products.set_active', $id));

        $response->assertStatus(403);
    }

    public function testAdminWithoutPermissionCannotDeleteAProduct(): void
    {
        $id = factory(Product::class)->create()->id;
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->delete(route('products.destroy', $id));

        $response->assertStatus(403);
    }

    public function testAllProductsRoutesWithPermissions(): void
    {
        $id = factory(Product::class)->create()->id;
        $role = factory(Role::class)->create();

        $role->syncPermissions([
            Permissions::VIEW_PRODUCTS,
            Permissions::CREATE_PRODUCTS,
            Permissions::EDIT_PRODUCTS,
            Permissions::DELETE_PRODUCTS,
        ]);

        $this->admin->assignRole($role->name);

        $this->actingAs($this->admin, Admins::GUARDED)
            ->get(route('products.index'))->assertStatus(200);

        $this->actingAs($this->admin, Admins::GUARDED)
            ->put(
                route('products.update', $id),
                [
                'name'          =>  'new product',
                'description'   =>  'new description at product incoming',
                'stock'         =>  0,
                'price'         =>  2000,
                'id_category'   => Category::all()->random()->id,
                'tags'          => [Tag::all()->random()->id],
                'Photos'        => [$this->faker->file(storage_path('app/public/photos'))],
                ]
            )->assertStatus(302);

        $this->actingAs($this->admin, Admins::GUARDED)
            ->put(route('products.set_active', $id))->assertStatus(302);

        $this->actingAs($this->admin, Admins::GUARDED)
            ->get(route('products.active', $id))->assertStatus(200);

        $this->actingAs($this->admin, Admins::GUARDED)
            ->delete(route('products.destroy', $id))->assertStatus(302);

        $this->actingAs($this->admin, Admins::GUARDED)->post(route('products.store', $id), [
            'name'          =>  'new product',
            'description'   =>  'new description at product incoming',
            'stock'         =>  0,
            'price'         =>  2000,
            'id_category'   => Category::all()->random()->id,
            'tags'          => [Tag::all()->random()->id],
            'Photos'        => [$this->faker->file(storage_path('app/public/photos'))],
        ])->assertStatus(302);
    }
}
