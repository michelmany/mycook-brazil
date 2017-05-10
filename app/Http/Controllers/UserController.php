<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function registerGet()
    {
        return view('user.register');
    }

    public function registerPost()
    {

    }
}
