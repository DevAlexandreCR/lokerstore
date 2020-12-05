<?php

namespace App\Observers;

use App\Constants\Logs;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    public function created(User $user): void
    {
        Cache::tags('users')->flush();
        logger()->channel(Logs::CHANNEL_USERS)->alert(
            'user created',
            [
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
            ]
        );
    }
}
