<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Hall;
use App\Models\Transaction;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $inputs = $request->except( '_token' );
        $rules = [
            'hall_id' => 'required | integer',
            'amount'  => 'required | integer',
        ];

        $validator = Validator::make( $inputs, $rules );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        $hall_id = $request->input( 'hall_id' );
        $amount = $request->input( 'amount' );

        $hall = Hall::findOrFail( $hall_id );
        $hall->pending_bill -= $amount;
        $hall->save();

        $register_balance = Balance::where( 'user_id', 1 )->where( 'hall_id', 0 )->first();

        if ( $register_balance === null ) {
            $register_balance = new Balance();
            $register_balance->user_id = 1;
            $register_balance->hall_id = 0;
            $register_balance->amount = $amount;
            $register_balance->save();

        } else {
            $register_balance->amount += $amount;
            $register_balance->save();
        }

        $register_transaction = new Transaction();
        $register_transaction->user_id = 1;
        $register_transaction->name = "Received Hall Bill (" . $hall->short_name . ")";
        $register_transaction->type = "Credit";
        $register_transaction->amount = $amount;
        $register_transaction->save();

        $hall_user = User::where( 'name', $hall->name )->first();
        $hall_balance = Balance::where( 'user_id', $hall_user->id )->where( 'hall_id', $hall->id )->first();

        if ( $hall_balance === null ) {
            $hall_balance = new Balance();
            $hall_balance->user_id = $hall_user->id;
            $hall_balance->hall_id = $hall->id;
            $hall_balance->amount = "-" . $amount;
            $hall_balance->save();

        } else {
            $hall_balance->amount -= $amount;
            $hall_balance->save();
        }

        $hall_office_transaction = new Transaction();
        $hall_office_transaction->user_id = $hall_user->id;
        $hall_office_transaction->name = "Paid Hall Bill To Register";
        $hall_office_transaction->type = "Debit";
        $hall_office_transaction->amount = $amount;
        $hall_office_transaction->save();

        Toastr::success( "Hall Bill Received Successfull!!!", 'Success!' );

        return redirect()->back();

    }
}
