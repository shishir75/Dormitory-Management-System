<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Student;
use App\Models\Transaction;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $student = Student::where( 'email', Auth::user()->email )->first();

        $balance = Balance::where( 'user_id', Auth::user()->id )->where( 'hall_id', $student->hall->id )->first();

        $transactions = Transaction::with( 'user' )->where( 'user_id', Auth::user()->id )->latest()->get();

        if ( $transactions->count() > 0 ) {
            return view( 'student.transaction', compact( 'transactions', 'balance' ) );

        } else {

            Toastr::info( "No Transaction yet!!!", 'Info!' );

            return redirect()->back();
        }

    }
}
