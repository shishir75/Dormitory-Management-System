<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Dept;
use App\Models\Hall;
use App\Models\Session;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $halls_count = Hall::count();
        $sessions_count = Session::count();
        $dept_count = Dept::count();
        $reg_balance = Balance::where( 'user_id', 1 )->where( 'hall_id', 0 )->first();

        $active_students = Student::where( 'status', 1 )->count();
        $available_seats = Hall::sum( 'available_seat' );
        $total_seats = Hall::sum( 'total_seat' );

        return view( 'register.dashboard', compact( 'halls_count', 'sessions_count', 'dept_count', 'reg_balance', 'active_students', 'available_seats', 'total_seats' ) );
    }
}
