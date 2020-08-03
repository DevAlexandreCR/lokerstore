<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Admin\Admin;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testStore()
    {
        $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create();
        $response = $this->actingAs($admin, 'admin')
                            ->post(route('category.store'), [
                                'name' => 'new category',
                                'id_parent' => null
                            ]);
        $response
            ->assertStatus(302)
            ->assertSessionHas('success');
        $this->assertDatabaseHas('categories', ['name' => 'new category']);
    }

    public function testStoreCanNotUniqueName()
    {
        $admin = factory(Admin::class)->create();

        factory(Category::class)->create([
            'name' => 'category'
        ]);
        $response = $this->actingAs($admin, 'admin')
                            ->post(route('category.store'), [
                                'name' => 'category',
                                'id_parent' => null
                            ]);
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('name');
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
