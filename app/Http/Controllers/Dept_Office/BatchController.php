<?php

namespace App\Http\Controllers\Dept_Office;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Dept;
use App\Models\Session;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dept = Dept::where( 'name', Auth::user()->name )->first();
        $sessions = Session::orderBy( 'id', 'desc' )->get();

        return view( "dept_office.batch.index", compact( "dept", "sessions" ) );
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
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        $session = Session::where( 'name', $id )->first();
        $dept = Dept::where( 'name', Auth::user()->name )->first();
        $students = Student::where( 'session_id', $session->id )->get();

        return view( "dept_office.batch.show", compact( 'dept', 'students' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function edit( Batch $batch )
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Batch $batch )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function destroy( Batch $batch )
    {
        //
    }
}
