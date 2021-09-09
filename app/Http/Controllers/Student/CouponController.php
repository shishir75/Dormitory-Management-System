<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Coupon;
use App\Models\CouponDetail;
use App\Models\Dining;
use App\Models\Student;
use App\Models\Transaction;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = Student::where( 'name', Auth::user()->name )->first();

        $balance = Balance::where( 'student_id', $student->id )->where( 'hall_id', $student->hall->id )->first();

        $dining = Dining::with( 'hall' )->where( 'hall_id', $student->hall->id )->first();

        $coupon_details = CouponDetail::where( 'student_id', $student->id )->orderBy( 'id', 'desc' )->get();

        $tomorrow = Carbon::tomorrow();

        $coupons = Coupon::where( "dining_id", $dining->id )->where( 'coupon_date', '>=', $tomorrow )->where( 'max_count', '>', 0 )->orderBy( 'id', 'desc' )->get();

        return view( 'student.coupon.index', compact( 'coupon_details', 'dining', 'student', 'balance', 'coupons' ) );
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
            'coupon_id' => 'required | integer',
        ];

        $validator = Validator::make( $inputs, $rules );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        $coupon_id = $request->input( 'coupon_id' );
        $student = Student::where( 'name', Auth::user()->name )->first();
        $tomorrow = Carbon::tomorrow()->format( "Ymd" );

        $coupon_no = $tomorrow . "-" . $student->id . "-" . $coupon_id;

        $check = CouponDetail::where( "coupon_no", $coupon_no )->count();

        if ( $check === 0 ) {
            $coupon_detail = new CouponDetail();
            $coupon_detail->coupon_id = $coupon_id;
            $coupon_detail->student_id = $student->id;
            $coupon_detail->coupon_no = $coupon_no;
            $coupon_detail->is_valid = "unused";
            $coupon_detail->save();

            $coupon = Coupon::findOrFail( $coupon_id );
            $coupon->max_count -= 1;
            $coupon->save();

            $balance = Balance::where( "student_id", $student->id )->first();
            $balance->amount -= $coupon->unit_price;
            $balance->save();

            $transaction = Transaction::where( "student_id", $student->id )->first();
            $transaction->student_id = $student->id;
            $transaction->name = "Food Coupon";
            $transaction->type = "Debit";
            $transaction->amount = $coupon->unit_price;
            $transaction->save();

            Toastr::success( 'Coupon Purchaged Successfully', 'Success!!!' );

            return redirect()->back();

        } else {
            Toastr::error( 'You already Purchaged Coupon for this Day', 'Error!!!' );

            return redirect()->back();
        }

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
