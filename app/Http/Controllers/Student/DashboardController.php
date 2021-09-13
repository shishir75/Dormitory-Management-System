<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\CouponDetail;
use App\Models\HallBill;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Student::with( 'hall', 'session' )->where( 'email', Auth::user()->email )->first();

        $balance = Balance::where( 'hall_id', $student->hall_id )->where( 'user_id', Auth::user()->id )->first();

        $coupons = CouponDetail::where( 'student_id', $student->id )->latest()->take( 10 )->get();
        $coupon_count = CouponDetail::where( 'student_id', $student->id )->count();

        //dd( $coupons );

        $hall_bill = HallBill::where( 'student_id', $student->id )->latest()->first();
        $from = Carbon::createFromFormat( 'Y-m-d H:s:i', $hall_bill->start_month );
        $to = Carbon::createFromFormat( 'Y-m-d H:s:i', $hall_bill->end_month );
        $diff_in_months = $from->diffInMonths( $to );

        $due_bill = (int) (  ( $diff_in_months + 1 ) * 20 );

        $end_date_as_integer = (int) date( 'Ym', strtotime( $from ) );
        $current_date_as_integer = (int) date( 'Ym', strtotime( $to ) );

        if ( $end_date_as_integer <= $current_date_as_integer ) {
            $due_bill = "+" . $due_bill;
        } else {
            $due_bill = "-" . $due_bill;
        }

        $latest_transactions = Transaction::where( 'user_id', Auth::user()->id )->latest()->take( 10 )->get();

        //dd( $latest_transactions->count() );

        return view( 'student.dashboard', compact( 'student', 'balance', 'coupons', 'due_bill', 'latest_transactions', 'coupon_count' ) );
    }
}
