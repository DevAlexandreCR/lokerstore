<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Admin\Admin;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $admin = factory(Admin::class)->create();
        $response = $this->actingAs($admin, 'admin')->get(route('category.index'));

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.category.index')
            ->assertViewHas('categories');
    }

    public function testStore()
    {
        $admin = factory(Admin::class)->create();
        $response = $this->actingAs($admin, 'admin')
                            ->post(route('category.store', [
                                'name' => 'new category',
                                'id_parent' => null
                            ]));
        $response
            ->assertStatus(302)
            ->assertSessionHas('success');
        $this->assertDatabaseHas('categories', ['name' => 'new category']);
    }

    public function testUpdate()
    {
        $admin = factory(Admin::class)->create();
        $category = factory(Category::class)->create();
        $response = $this->actingAs($admin, 'admin')
                            ->put(route('category.update', ['category' => $category]),
                            [
                                'name' => 'category updated',
                                'id_parent' => null
                            ]);
        $response
            ->assertStatus(302)
            ->assertSessionHas('success');
        $this->assertDatabaseHas('categories', ['name' => 'category updated']);
    }

    public function testDestroy()
    {
        $admin = factory(Admin::class)->create();
        $category = factory(Category::class)->create();
        $response = $this->actingAs($admin, 'admin')
                            ->delete(route('category.destroy', ['category' => $category]));

        $response
            ->assertStatus(302)
            ->assertSessionHas('success');
    }
}
