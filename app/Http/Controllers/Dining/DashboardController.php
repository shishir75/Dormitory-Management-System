<?php

namespace App\Http\Controllers\Dining;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view( "dining.dashboard" );
    }
}
