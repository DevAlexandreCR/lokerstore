<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    /**
     * @param User $user
     * @return View
     */
    public function profile(User $user): View
    {
        return view('web.users.profile', [
            'user' => $user,
        ]);
    }
}
