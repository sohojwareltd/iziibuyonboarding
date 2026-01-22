<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Show the admin login page.
     */
    public function showLogin()
    {
        return view('admin.login');
    }
}

