<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DisabledUserController extends Controller
{
    public function index() 
    {
        return view('disabled');
    }
}
