<?php

namespace App\Http\Controllers\Dept_Office;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // $dept = Dept::where( 'name', Auth::user()->name )->first();
        // $sessions = Session::count();
        //$teachers = Teacher::where('dept_id', $dept->id)->count();
        //$students = Student::where('dept_id', $dept->id)->count();
        //$courses = Course::where('dept_id', $dept->id)->count();
        //$externals = CourseTeacher::where('dept_id', $dept->id)->count();
        //$year_heads = YearHead::where('dept_id', $dept->id)->count();

        //return view('dept_office.dashboard', compact('sessions',  'students', 'courses', 'externals', 'year_heads'));

        return view( 'dept_office.dashboard' );
    }
}
