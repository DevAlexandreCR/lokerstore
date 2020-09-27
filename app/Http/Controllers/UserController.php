<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function profile(User $user): View
    {
        return view('web.users.profile', [
            'user' => $user
        ]);
    }
}
