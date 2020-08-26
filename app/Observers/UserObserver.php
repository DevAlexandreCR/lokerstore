<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        logger()->alert('user created',
        [
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at
        ]);
    }
}
