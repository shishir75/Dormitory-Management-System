<?php

namespace App\Http\Controllers\Dept_Office;

use App\Http\Controllers\Controller;
use App\Models\Dept;
use App\Models\Hall;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $dept = Dept::where( 'name', Auth::user()->name )->first();
        $current_students = Student::where( 'dept_id', $dept->id )->where( 'status', 1 )->count();
        $waiting_for_hall_approval_students = Student::where( 'dept_id', $dept->id )->where( 'status', 2 )->count();
        $ex_students = Student::where( 'dept_id', $dept->id )->where( 'status', 3 )->count();
        $available_seats = Hall::sum( 'available_seat' );
        $halls = Hall::count();

        return view( 'dept_office.dashboard', compact( 'current_students', 'waiting_for_hall_approval_students', 'ex_students', 'available_seats', 'halls' ) );
    }
}
