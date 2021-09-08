<?php

namespace App\Http\Controllers\Hall_Office;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Hall;
use App\Models\HallRoom;
use App\Models\Session;
use App\Models\Student;
use App\Models\Transaction;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
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
        $students = Student::with( 'balance' )->where( "session_id", $session->id )->where( "hall_id", $hall->id )->get();

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
        $hall = Hall::where( 'name', Auth::user()->name )->first();
        $balance = Balance::where( "hall_id", $hall->id )->where( 'student_id', $student_id )->first();

        $inputs = $request->except( '_token' );
        $rules = [
            'amount' => 'required',
        ];

        $validator = Validator::make( $inputs, $rules );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        if ( $balance == null ) {

            $balance = new Balance();
            $balance->student_id = $student_id;
            $balance->hall_id = $hall->id;
            $balance->amount = $request->input( 'amount' );
            $balance->save();

        } else {
            $balance->amount += $request->input( 'amount' );
            $balance->save();
        }

        $transaction = new Transaction();
        $transaction->student_id = $student_id;
        $transaction->name = "Add Money";
        $transaction->type = "Credit";
        $transaction->amount = $request->input( 'amount' );
        $transaction->save();

        Toastr::success( 'Money added Successfully', 'Success!!!' );

        return redirect()->back();
    }
}
