<?php

namespace App\Policies\Admin;

use App\Constants\Permissions;
use App\Models\Admin\Admin;
use App\Models\Tag;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tags.
     *
     * @param Admin $admin
     * @return bool
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasPermissionTo(Permissions::VIEW_TAGS);
    }

    /**
     * Determine whether the user can view the tag.
     *
     * @param Admin $admin
     * @param Tag $tag
     * @return bool
     */
    public function view(Admin $admin, Tag $tag): bool
    {
        return $admin->hasPermissionTo(Permissions::VIEW_TAGS);
    }

    /**
     * Determine whether the user can create tags.
     *
     * @param Admin $admin
     * @return bool
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasPermissionTo(Permissions::CREATE_TAGS);
    }

    /**
     * Determine whether the user can update the tag.
     *
     * @param Admin $admin
     * @param Tag $tag
     * @return bool
     */
    public function update(Admin $admin, Tag $tag): bool
    {
        return $admin->hasPermissionTo(Permissions::EDIT_TAGS);
    }

    /**
     * Determine whether the user can delete the tag.
     *
     * @param Admin $admin
     * @param Tag $tag
     * @return bool
     */
    public function delete(Admin $admin, Tag $tag): bool
    {
        return $admin->hasPermissionTo(Permissions::DELETE_TAGS);
    }
}
