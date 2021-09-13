<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view( 'register.dashboard' );
    }
}
