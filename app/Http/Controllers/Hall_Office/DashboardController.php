<?php

namespace App\Http\Controllers\Hall_Office;

use App\Http\Controllers\Controller;
use App\Models\Hall;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $hall = Hall::where( 'name', Auth::user()->name )->first();
        $current_students = Student::where( 'hall_id', $hall->id )->where( 'status', 1 )->count();
        $pending_approval_students = Student::where( 'hall_id', $hall->id )->where( 'status', 2 )->count();
        $ex_students = Student::where( 'hall_id', $hall->id )->where( 'status', 3 )->count();

        return view( "hall_office.dashboard", compact( 'hall', 'current_students', 'pending_approval_students', 'ex_students' ) );
    }

}
