<?php

namespace App\Http\Controllers\Hall_Office;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Dining;
use App\Models\Hall;
use App\Models\Transaction;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hall = Hall::where( 'name', Auth::user()->name )->first();

        $dining = Dining::where( 'hall_id', $hall->id )->first();

        $user = User::where( "email", $dining->email )->first();

        $balance = Balance::where( 'user_id', $user->id )->where( 'hall_id', $hall->id )->first();

        $transactions = Transaction::with( 'user' )->where( 'user_id', $user->id )->latest()->get();

        if ( $transactions->count() > 0 ) {
            return view( 'hall_office.payment.index', compact( 'transactions', 'balance', 'dining' ) );

        } else {

            Toastr::info( "No Transaction yet!!!", 'Info!' );

            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request )
    {
        $inputs = $request->except( '_token' );
        $rules = [
            'amount' => 'required | integer',
        ];

        $validator = Validator::make( $inputs, $rules );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        $hall = Hall::where( 'name', Auth::user()->name )->first();

        $dining = Dining::where( 'hall_id', $hall->id )->first();

        $user = User::where( "email", $dining->email )->first();

        $balance = Balance::where( 'user_id', $user->id )->where( 'hall_id', $hall->id )->first();

        if ( $balance === null ) {
            $balance = new Balance();
            $balance->user_id = $user->id;
            $balance->hall_id = $hall->id;
            $balance->amount = $request->input( 'amount' );
            $balance->save();

        } else {
            $balance->amount += $request->input( 'amount' );
            $balance->save();
        }

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->name = "Add Balance";
        $transaction->type = "Credit";
        $transaction->amount = $request->input( 'amount' );
        $transaction->save();

        Toastr::success( "Make Payment Successfull!!!", 'Success!' );

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        //
    }
}
