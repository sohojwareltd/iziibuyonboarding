<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    public function index(): View
    {
        return view('admin.onboarding.index');
    }

    public function start(): View
    {
        return view('admin.onboarding.start');
    }

    public function track(): View
    {
        return view('admin.onboarding.track');
    }
}

