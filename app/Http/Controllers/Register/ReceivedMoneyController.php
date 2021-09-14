<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Hall;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReceivedMoneyController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where( 'user_id', 1 )->latest()->get();
        $halls = Hall::all();
        $register_balance = Balance::where( 'user_id', 1 )->where( 'hall_id', 0 )->first();

        return view( 'register.receivedMoney', compact( 'transactions', 'halls', 'register_balance' ) );
    }

    public function store( Request $request )
    {

    }
}
