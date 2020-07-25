<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Admin\Admin;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $admin = factory(Admin::class)->create();

        $response = $this->actingAs($admin, 'admin')->get(route('tags.index'));

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.tags.index')
            ->assertViewHas('tags');
    }

    public function testUpdate()
    {
        $admin = factory(Admin::class)->create();

        $tag = factory(Tag::class)->create();

        $response = $this->actingAs($admin, 'admin')->put(route('tags.update', $tag), 
                            [
                                'name' => 'new name'
                            ]);

        $response
            ->assertStatus(302)
            ->assertSessionHas('success');
        
        $this->assertDatabaseHas('tags', 
        [
            'name' => 'new name'
        ]);
    }

    public function testStore()
    {
        $admin = factory(Admin::class)->create();

        $response = $this->actingAs($admin, 'admin')->post(route('tags.store'), 
                            [
                                'name' => 'new tag'
                            ]);

        $response
            ->assertStatus(302)
            ->assertSessionHas('success');
        
        $this->assertDatabaseHas('tags', 
        [
            'name' => 'new tag'
        ]);
    }

    public function testDestroy()
    {
        $admin = factory(Admin::class)->create();

        $tag = factory(Tag::class)->create();

        $response = $this->actingAs($admin, 'admin')->delete(route('tags.destroy', $tag));

        $response
            ->assertStatus(302)
            ->assertSessionHas('success');
        
        $this->assertDatabaseMissing('tags', 
        [
            'id' => $tag->id
        ]);
    }
}
