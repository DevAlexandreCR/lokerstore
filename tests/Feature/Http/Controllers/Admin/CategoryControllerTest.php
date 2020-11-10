<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Constants\Roles;
use App\Models\Admin\Admin;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PermissionSeeder;
use RoleSeeder;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->seed([
            PermissionSeeder::class,
            RoleSeeder::class
        ]);
        $this->admin = factory(Admin::class)->create();
        $this->admin->assignRole(Roles::ADMIN);
    }

    public function testStore(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
                            ->post(route('category.store'), [
                                'name' => 'new category',
                                'id_parent' => null
                            ]);
        $response
            ->assertStatus(302)
            ->assertSessionHas('success');
        $this->assertDatabaseHas('categories', ['name' => 'new category']);
    }

    public function testStoreCanNotUniqueName(): void
    {
        factory(Category::class)->create([
            'name' => 'category'
        ]);
        $response = $this->actingAs($this->admin, 'admin')
                            ->post(route('category.store'), [
                                'name' => 'category',
                                'id_parent' => null
                            ]);
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('name');
    }

    public function testUpdate(): void
    {
        $category = factory(Category::class)->create();
        $response = $this->actingAs($this->admin, 'admin')
                            ->put(
                                route('category.update', ['category' => $category]),
                                [
                                'name' => 'category updated',
                                'id_parent' => null
                            ]
                            );
        $response
            ->assertStatus(302)
            ->assertSessionHas('success');
        $this->assertDatabaseHas('categories', ['name' => 'category updated']);
    }

    public function testDestroy(): void
    {
        $category = factory(Category::class)->create();
        $response = $this->actingAs($this->admin, 'admin')
                            ->delete(route('category.destroy', ['category' => $category]));

        $response
            ->assertStatus(302)
            ->assertSessionHas('success');
    }
}
