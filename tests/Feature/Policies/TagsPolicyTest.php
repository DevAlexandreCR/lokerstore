<?php

namespace Tests\Feature\Policies;

use App\Constants\Admins;
use App\Constants\Permissions;
use App\Models\Admin\Admin;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PermissionSeeder;
use RoleSeeder;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TagsPolicyTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->seed([
            PermissionSeeder::class,
            RoleSeeder::class
        ]);
        $this->admin = factory(Admin::class)->create();
    }

    public function testIndexNotAuthorized(): void
    {
        $response = $this->actingAs($this->admin, Admins::GUARDED)->get(route('tags.index'));

        $response->assertStatus(403);
    }

    public function testAdminWithoutPermissionCannotUpdateTags(): void
    {
        $id = factory(Tag::class)->create()->id;
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->put(route('tags.update', $id));

        $response->assertStatus(403);
    }

    public function testAdminWithoutPermissionCannotDeleteATag(): void
    {
        $id = factory(Tag::class)->create()->id;
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->delete(route('tags.destroy', $id));

        $response->assertStatus(403);
    }

    public function testAdminWithoutPermissionCannotCreateTags(): void
    {
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->post(route('tags.store'), [
                'name' => 'new tag'
            ]);

        $response->assertStatus(403);
    }

    public function testAllTagsRoutesWithPermissions(): void
    {
        $id = factory(Tag::class)->create()->id;
        $role = factory(Role::class)->create();

        $role->syncPermissions([
            Permissions::VIEW_TAGS,
            Permissions::CREATE_TAGS,
            Permissions::EDIT_TAGS,
            Permissions::DELETE_TAGS,
        ]);

        $this->admin->assignRole($role->name);

        $this->actingAs($this->admin, Admins::GUARDED)
            ->get(route('tags.index'))->assertStatus(200);

        $this->actingAs($this->admin, Admins::GUARDED)
            ->put(route('tags.update', $id))->assertStatus(302);

        $this->actingAs($this->admin, Admins::GUARDED)
            ->delete(route('tags.destroy', $id))->assertStatus(302);

        $this->actingAs($this->admin, Admins::GUARDED)->post(route('tags.store', $id), [
            'name' => 'NEW CATEGORY',
            'id_parent' => null,
        ])->assertStatus(302);
    }
}
