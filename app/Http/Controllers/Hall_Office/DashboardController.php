<?php

namespace App\Http\Controllers\Hall_Office;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Dining;
use App\Models\Hall;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $hall = Hall::where( 'name', Auth::user()->name )->first();
        $current_students = Student::where( 'hall_id', $hall->id )->where( 'status', 1 )->count();
        $pending_approval_students = Student::where( 'hall_id', $hall->id )->where( 'status', 2 )->count();
        $ex_students = Student::where( 'hall_id', $hall->id )->where( 'status', 3 )->count();

        $dining = Dining::where( 'hall_id', $hall->id )->first();
        $user = User::where( "email", $dining->email )->first();
        $dining_balance = Balance::where( 'user_id', $user->id )->where( 'hall_id', $hall->id )->first();
        $hall_office_balance = Balance::where( 'user_id', Auth::user()->id )->where( 'hall_id', $hall->id )->first();
        $transactions = Transaction::with( 'user' )->where( 'user_id', Auth::user()->id )->latest()->take( 10 )->get();

        return view( "hall_office.dashboard", compact( 'hall', 'current_students', 'pending_approval_students', 'ex_students', 'dining_balance', 'hall_office_balance', 'transactions' ) );
    }

}
