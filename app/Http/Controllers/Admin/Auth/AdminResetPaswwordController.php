<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class AdminResetPaswwordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = RouteServiceProvider::ADMIN_HOME;
}
