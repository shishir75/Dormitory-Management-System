<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $student = Student::where( 'name', Auth::user()->name )->first();

        $balance = Balance::where( 'student_id', $student->id )->where( 'hall_id', $student->hall->id )->first();

        $transactions = Transaction::with( 'student' )->where( 'student_id', $student->id )->latest()->get();

        return view( 'student.transaction', compact( 'transactions', 'balance' ) );
    }
}
