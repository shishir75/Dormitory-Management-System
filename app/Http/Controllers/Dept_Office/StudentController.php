<?php

namespace App\Http\Controllers\Dept_Office;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\Dept;
use App\Models\Hall;
use App\Models\Session;
use App\Models\Student;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{

    public function index()
    {
        $dept = Dept::where( 'name', Auth::user()->name )->first();
        $sessions = Session::orderBy( 'id', 'desc' )->get();

        return view( "dept_office.student.batch", compact( "dept", "sessions" ) );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {

        // $dept = Dept::select( 'id', 'name' )->where( 'name', Auth::user()->name )->first();
        // $students = Student::with( 'dept' )->latest()->where( 'dept_id', $dept->id )->orderBy( 'session_id', 'desc' )->orderBy( 'reg_no', 'asc' )->get();

        // return view( 'dept_office.student.index', compact( 'students', 'dept' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sessions = Session::orderBy( 'id', 'desc' )->get();

        return view( 'dept_office.student.create', compact( "sessions" ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request )
    {
        if ( $request->hasFile( 'file' ) ) {
            $file = $request->file( 'file' );

            $data = Excel::toArray( new StudentsImport(), $file );

            $dept = Dept::select( 'id' )->where( 'name', Auth::user()->name )->first();

            $session_id = $request->session_id;

            if ( !empty( $data ) && count( $data ) > 0 ) {

                foreach ( $data as $rows ) {
                    foreach ( $rows as $key => $value ) {
                        if ( $key > 3 ) {
                            $student = new Student();

                            $check = Student::where( 'session_id', $session_id )->where( 'reg_no', $value[2] )->count();

                            if ( $check > 0 ) {
                                continue;

                            } else {

                                $student->name = $value[1];
                                $student->reg_no = $value[2];
                                $student->sex = $value[3];
                                $student->email = $value[5];
                                $student->dept_id = $dept->id;
                                $student->session_id = $session_id;

                                $hall_short_name = $value[4];
                                $find_hall = Hall::where( "short_name", $hall_short_name )->first();
                                $student->hall_id = $find_hall->id;

                                $student->save();
                            }

                        }
                    }
                }

                Toastr::success( 'Students added successfully', 'Success' );

                return redirect()->route( 'dept_office.student.index' );
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        $session = Session::where( 'name', $id )->first();
        $dept = Dept::where( 'name', Auth::user()->name )->first();
        $students = Student::where( 'session_id', $session->id )->where( 'dept_id', $dept->id )->get();

        return view( "dept_office.student.show", compact( 'dept', 'students' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit( Student $student )
    {
        $sessions = Session::latest()->get();
        $halls = Hall::all();

        return view( 'dept_office.student.edit', compact( 'student', 'sessions', 'halls' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Student $student )
    {
        $inputs = $request->except( '_token' );
        $rules = [
            'name'        => 'required',
            'session'     => 'required',
            'class_roll'  => 'required | integer',
            'reg_no'      => 'required | integer',
            'exam_roll'   => 'required | integer',
            'hall'        => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
        ];

        $validator = Validator::make( $inputs, $rules );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        $session = $request->input( 'session' );
        $class_roll = $request->input( 'class_roll' );
        $reg_no = $request->input( 'reg_no' );
        $exam_roll = $request->input( 'exam_roll' );

        $check = Student::where( 'session', $session )->where( 'class_roll', $class_roll )->where( 'id', '!=', $student->id )->count();

        if ( $check == 0 ) {
            $student->name = $request->input( 'name' );
            $student->session = $session;
            $student->class_roll = $class_roll;
            $student->reg_no = $reg_no;
            $student->exam_roll = $exam_roll;
            $student->hall = $request->input( 'hall' );
            $student->father_name = $request->input( 'father_name' );
            $student->mother_name = $request->input( 'mother_name' );
            $student->save();

            Toastr::success( 'Students updated successfully', 'Success' );

            return redirect()->route( 'dept_office.student.index' );

        } else {
            Toastr::error( 'Student already exits!!!', 'Error' );

            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy( Student $student )
    {
        $student->delete();

        Toastr::success( 'Students deleted successfully', 'Success' );

        return redirect()->route( 'dept_office.student.index' );
    }

    public function change_all_status( $session_id )
    {
        $dept = Dept::where( 'name', Auth::user()->name )->first();
        $session = Session::findOrFail( $session_id );

        $check = Student::where( "dept_id", $dept->id )->where( "session_id", $session->id )->first();

        if ( $check->status == true ) {
            DB::table( 'students' )
                ->where( "dept_id", $dept->id )
                ->where( "session_id", $session->id )
                ->update( ['room_no' => false, 'status' => false] );
        } else {
            DB::table( 'students' )
                ->where( "dept_id", $dept->id )
                ->where( "session_id", $session->id )
                ->update( ['room_no' => false, 'status' => true] );
        }

        Toastr::success( 'Status updated successfully', 'Success' );

        return redirect()->back();
    }

    public function changeStatusForSelectedStudents( Request $request )
    {
        $ids = $request->ids;

        $dept = Dept::where( 'name', Auth::user()->name )->first();

        foreach ( $ids as $student_id ) {
            $check = Student::find( $student_id );

            if ( $check->status == true ) {
                DB::table( 'students' )
                    ->where( "dept_id", $dept->id )
                    ->where( "id", $student_id )
                    ->update( ['room_no' => false, 'status' => false] );
            } else {
                DB::table( 'students' )
                    ->where( "dept_id", $dept->id )
                    ->where( "id", $student_id )
                    ->update( ['room_no' => false, 'status' => true] );
            }
        }
        Toastr::success( 'Status updated successfully', 'Success' );
    }
}
