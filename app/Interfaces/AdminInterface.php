<?php

namespace App\Interfaces;

use App\Models\Admin\Admin;

interface AdminInterface extends RepositoryInterface
{
    /**
     * @param Admin $admin
     * @return void
     */
    public function updateToken(Admin $admin): void;
}
