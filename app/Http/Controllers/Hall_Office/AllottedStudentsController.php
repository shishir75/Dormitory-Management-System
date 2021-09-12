<?php

namespace App\Http\Controllers\Hall_Office;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Hall;
use App\Models\HallBill;
use App\Models\HallRoom;
use App\Models\Session;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AllottedStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessions = Session::orderBy( 'id', 'desc' )->get();
        $hall = Hall::where( 'name', Auth::user()->name )->first();

        return view( 'hall_office.allotted_student.batch', compact( 'sessions', 'hall' ) );
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $session_name )
    {
        $session = Session::where( 'name', $session_name )->first();
        $hall = Hall::where( 'name', Auth::user()->name )->first();
        $students = Student::where( "session_id", $session->id )->where( "hall_id", $hall->id )->get();

        $available_hall_rooms = HallRoom::where( 'hall_id', $hall->id )->where( 'available_seat', '>', 0 )->get();

        return view( 'hall_office.allotted_student.index', compact( 'students', 'hall', 'session', 'available_hall_rooms' ) );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        return Student::findOrFail( $id );
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
        $student = Student::findOrFail( $id );
        $hall = Hall::where( 'name', Auth::user()->name )->first();

        $room_no = $request->input( 'room_no' );
        $student->room_no = $room_no;
        $student->save();

        $hall_room = HallRoom::where( "hall_id", $hall->id )->where( "room_no", $room_no )->first();

        $hall_room->available_seat = $hall_room->available_seat - 1;
        $hall_room->save();

        Toastr::success( 'Student Allocation successful', 'Success' );

        return redirect()->back();
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

    public function addMoney( Request $request, $student_id )
    {
        $inputs = $request->except( '_token' );
        $rules = [
            'amount' => 'required',
        ];

        $validator = Validator::make( $inputs, $rules );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        $hall = Hall::where( 'name', Auth::user()->name )->first();

        $student = Student::findOrFail( $student_id );
        $user = User::where( "name", $student->name )->first();

        if ( $user !== null ) {
            $balance = Balance::where( "hall_id", $hall->id )->where( 'user_id', $user->id )->first();

            if ( $balance == null ) {

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
            $transaction->name = "Add Money";
            $transaction->type = "Credit";
            $transaction->amount = $request->input( 'amount' );
            $transaction->save();

            Toastr::success( 'Money added Successfully', 'Success!!!' );

            return redirect()->back();
        } else {
            Toastr::error( 'User profile is not created yet', 'Error!!!' );

            return redirect()->back();
        }

    }

    public function details( $student_id )
    {
        $hall = Hall::where( 'name', Auth::user()->name )->first();
        $student = Student::findOrFail( $student_id );
        $user = User::where( "name", $student->name )->first();

        if ( $user != null ) {
            if ( $student->hall_id === $hall->id ) {

                $transactions = Transaction::where( 'user_id', $user->id )->orderBy( 'id', 'desc' )->get();
                $balance = Balance::where( "hall_id", $hall->id )->where( 'user_id', $user->id )->first();

                //dd( $balance->amount );

                if ( $transactions->count() > 0 ) {
                    return view( 'hall_office.allotted_student.show', compact( 'transactions', 'student', 'balance' ) );
                } else {
                    Toastr::info( 'No Transactions yet', 'Info!!!' );

                    return redirect()->back();
                }

            } else {

                Toastr::error( 'Unauthorized Access Denied', 'Error!!!' );

                return redirect()->back();
            }
        } else {
            Toastr::error( 'Student did not create his/her profile yet!!!', 'Error!!!' );

            return redirect()->back();
        }

    }

    public function pay_hall_bill( Request $request, $student_id )
    {
        $inputs = $request->except( '_token' );
        $rules = [
            'end_month' => 'required',
        ];

        $validator = Validator::make( $inputs, $rules );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        $end_month = $request->input( 'end_month' ) . "-01 12:00:00";

        $student = Student::findOrFail( $student_id );
        $student_user_id = User::where( 'email', $student->email )->first();

        if ( $student_user_id === null ) {

            Toastr::error( 'Student has not created his/her profile yet. Create profile first to transaction!!!', 'Error!!!' );

            return redirect()->back();
        }

        $hall = Hall::where( 'name', Auth::user()->name )->first();

        if ( $student->hall_id === $hall->id ) {

            $balance = Balance::where( "hall_id", $student->hall_id )->where( 'user_id', $student_user_id->id )->first();

            $hall_bill_old = HallBill::where( 'student_id', $student->id )->latest()->first();

            $hall_bill = new HallBill();
            $hall_bill->student_id = $student->id;

            if ( $hall_bill_old !== null ) {
                $hall_bill->start_month = $hall_bill_old->end_month;
            } else {
                $hall_bill->start_month = $student->created_at;
            }

            $hall_bill->end_month = $end_month;

            $from = Carbon::createFromFormat( 'Y-m-d H:s:i', $hall_bill->start_month );
            $to = Carbon::createFromFormat( 'Y-m-d H:s:i', date( $end_month ) );
            $diff_in_months = $from->diffInMonths( $to );

            $pay_amount = (int) (  ( $diff_in_months - 1 ) * 20 );

            //dd( $pay_amount );

            if ( $balance->amount >= $pay_amount ) {

                $hall_bill->amount = $pay_amount;
                $hall_bill->save();

                $balance->amount -= $pay_amount;
                $balance->save();

                $transaction = new Transaction();
                $transaction->user_id = $student_user_id->id;
                $transaction->name = "Pay Hall Bill";
                $transaction->type = "Debit";
                $transaction->amount = $pay_amount;
                $transaction->save();

                Toastr::success( 'Bill Payment Successful', 'Success!!!' );

                return redirect()->back();

            } else {
                Toastr::error( 'Insufficient Balance.Plz Add Money First!!!', 'Error!!!' );

                return redirect()->back();
            }

        } else {
            Toastr::error( 'Unauthorized Access Denied!!!', 'Error!!!' );

            return redirect()->back();
        }
    }
}
