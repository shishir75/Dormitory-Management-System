<?php

namespace App\Http\Controllers\Dept_Office;

use App\Http\Controllers\Controller;
use App\Models\Hall;

class HallsController extends Controller
{
    public function index()
    {
        $halls = Hall::all();

        return view( "dept_office.halls.index", compact( 'halls' ) );
    }
}
