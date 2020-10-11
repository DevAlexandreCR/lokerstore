<?php

namespace App\Observers;

use App\Models\Admin\Admin;
use Illuminate\Support\Str;

class AdminObserver
{
    /**
     * Handle the admin "created" event.
     *
     * @param Admin $admin
     * @return void
     */
    public function created(Admin $admin): void
    {
        $admin->api_token = Str::random(60);
        $admin->save();
    }
}
