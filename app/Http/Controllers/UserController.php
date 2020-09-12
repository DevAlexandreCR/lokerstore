<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function profile(User $user): View
    {
        $this->authorize($user);
        return view('web.users.profile', [
            'user' => $user
        ]);
    }
}
