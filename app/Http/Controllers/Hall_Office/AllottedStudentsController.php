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
        $room_no = $request->input( 'room_no' );

        $hall = Hall::where( 'name', Auth::user()->name )->first();
        $student = Student::findOrFail( $id );

        if ( $student->room_no === null ) {
            $student->room_no = $room_no;
            $student->save();

            $hall_room = HallRoom::where( "hall_id", $hall->id )->where( "room_no", $room_no )->first();
            $hall_room->available_seat -= 1;
            $hall_room->save();

        } else {
            $old_hall_room = HallRoom::where( "hall_id", $hall->id )->where( "room_no", $student->room_no )->first();
            $old_hall_room->available_seat += 1;
            $old_hall_room->save();

            $student->room_no = $room_no;
            $student->save();
        }

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
        $student_user = User::where( "name", $student->name )->first();

        if ( $student_user !== null ) {
            $balance = Balance::where( "hall_id", $hall->id )->where( 'user_id', $student_user->id )->first();

            if ( $balance == null ) {

                $balance = new Balance();
                $balance->user_id = $student_user->id;
                $balance->hall_id = $hall->id;
                $balance->amount = $request->input( 'amount' );
                $balance->save();

            } else {
                $balance->amount += $request->input( 'amount' );
                $balance->save();
            }

            $hall_office_balance = Balance::where( 'hall_id', $hall->id )->where( 'user_id', Auth::user()->id )->first();

            if ( $hall_office_balance == null ) {

                $hall_office_balance = new Balance();
                $hall_office_balance->user_id = Auth::user()->id;
                $hall_office_balance->hall_id = $hall->id;
                $hall_office_balance->amount = $request->input( 'amount' );
                $hall_office_balance->save();

            } else {
                $hall_office_balance->amount += $request->input( 'amount' );
                $hall_office_balance->save();
            }

            $transaction = new Transaction();
            $transaction->user_id = $student_user->id;
            $transaction->name = "Add Money";
            $transaction->type = "Credit";
            $transaction->amount = $request->input( 'amount' );
            $transaction->save();

            $hall_office_transaction = new Transaction();
            $hall_office_transaction->user_id = Auth::user()->id;
            $hall_office_transaction->name = "TopUp Money for (" . $student_user->name . ")";
            $hall_office_transaction->type = "Credit";
            $hall_office_transaction->amount = $request->input( 'amount' );
            $hall_office_transaction->save();

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
        $student_user = User::where( 'email', $student->email )->first();

        if ( $student_user === null ) {

            Toastr::error( 'Student has not created his/her profile yet. Create profile first to transaction!!!', 'Error!!!' );

            return redirect()->back();
        }

        $hall = Hall::where( 'name', Auth::user()->name )->first();

        if ( $student->hall_id === $hall->id ) {

            $hall_bill_old = HallBill::where( 'student_id', $student->id )->latest()->first();

            if ( $hall_bill_old == null ) {
                $old_end_month = $student->created_at;
            } else {
                $old_end_month = $hall_bill_old->end_month;
            }

            $input_month_as_integer = (int) date( 'Ym', strtotime( $end_month ) );
            $last_paid_month_as_integer = (int) date( 'Ym', strtotime( $old_end_month ) );

            if ( $last_paid_month_as_integer >= $input_month_as_integer ) {

                Toastr::info( "You have already paid these months bill!", 'Info!!!' );

                return redirect()->back();
            }

            $hall_bill = new HallBill();
            $hall_bill->student_id = $student->id;

            $student_inital_created_month = date( 'Y-m', strtotime( $student->created_at ) );
            $student_inital_created_at = $student_inital_created_month . "-01 12:00:00";

            if ( $hall_bill_old !== null ) {
                $hall_bill->start_month = Carbon::createFromFormat( 'Y-m-d H:s:i', $hall_bill_old->end_month )->addMonth();
            } else {
                $hall_bill->start_month = $student_inital_created_at;
            }

            $hall_bill->end_month = $end_month;

            $from = Carbon::createFromFormat( 'Y-m-d H:s:i', $hall_bill->start_month );
            $to = Carbon::createFromFormat( 'Y-m-d H:s:i', date( $end_month ) );
            $diff_in_months = $from->diffInMonths( $to );

            $pay_amount = (int) (  ( $diff_in_months + 1 ) * 20 );

            $hall->pending_bill += $pay_amount;
            $hall->save();

            $student_balance = Balance::where( "hall_id", $student->hall_id )->where( 'user_id', $student_user->id )->first();

            if ( $student_balance->amount >= $pay_amount ) {

                $hall_bill->amount = $pay_amount;
                $hall_bill->save();

                $student_balance->amount -= $pay_amount;
                $student_balance->save();

                $student_transaction = new Transaction();
                $student_transaction->user_id = $student_user->id;
                $student_transaction->name = "Pay Hall Bill ( " . date( 'F-Y', strtotime( $hall_bill->start_month ) ) . " to " . date( 'F-Y', strtotime( $end_month ) ) . " )";
                $student_transaction->type = "Debit";
                $student_transaction->amount = $pay_amount;
                $student_transaction->save();

                $register_balance = Balance::where( 'user_id', 1 )->first();

                if ( $register_balance === null ) {
                    $register_balance = new Balance();
                    $register_balance->user_id = 1;
                    $register_balance->hall_id = 0;
                    $register_balance->amount = "-" . $pay_amount;
                    $register_balance->save();

                } else {
                    $register_balance->amount -= $pay_amount;
                    $register_balance->save();
                }

                $register_transaction = new Transaction();
                $register_transaction->user_id = 1;
                $register_transaction->name = "Hall Bill Pending (" . $hall->short_name . ")";
                $register_transaction->type = "Debit";
                $register_transaction->amount = $pay_amount;
                $register_transaction->save();

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
