<?php

namespace App\Http\Controllers\Dining;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Coupon;
use App\Models\CouponDetail;
use App\Models\Dining;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
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
        $dining = Dining::where( "email", Auth::user()->email )->first();

        $coupon_dates = Coupon::where( "dining_id", $dining->id )->orderBy( 'id', 'desc' )->get();

        return view( 'dining.coupon.index', compact( 'dining', 'coupon_dates' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dining = Dining::where( "email", Auth::user()->email )->first();

        return view( "dining.coupon.create", compact( 'dining' ) );
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
            'coupon_date' => 'required | date',
            'type'        => 'required',
            'unit_price'  => 'required | integer',
            'max_count'   => 'required | integer',
        ];

        $validator = Validator::make( $inputs, $rules );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        $date = $request->input( 'coupon_date' );
        $type = $request->input( 'type' );

        $coupon_date_as_integer = (int) date( 'Ymd', strtotime( $date ) );

        $tomorrow_as_integer = (int) date( 'Ymd', strtotime( Carbon::tomorrow() ) );

        $dining = Dining::where( "email", Auth::user()->email )->first();

        $check = Coupon::where( 'dining_id', $dining->id )->where( 'coupon_date', $date )->where( 'type', $type )->count();

        if ( $check === 0 ) {

            if ( $coupon_date_as_integer >= $tomorrow_as_integer ) {

                $coupon = new Coupon();
                $coupon->dining_id = $dining->id;
                $coupon->coupon_date = $date;
                $coupon->type = $type;
                $coupon->unit_price = $request->input( 'unit_price' );
                $coupon->max_count = $request->input( 'max_count' );
                $coupon->sold_coupon = 0;
                $coupon->save();

                Toastr::success( 'Coupon Added Successfully', 'Success!!!' );

                return redirect()->back();

            } else {

                Toastr::error( "You can't assign previous days coupon!!!", 'Error!!!' );

                return redirect()->back();
            }

        } else {

            Toastr::error( 'Coupon for this event is already Asssigned', 'Error!!!' );

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
        $dining = Dining::where( "email", Auth::user()->email )->first();

        $coupon = Coupon::where( 'id', $id )->where( 'dining_id', $dining->id )->first();

        if ( $dining->id === $coupon->dining_id ) {

            $coupon_details = CouponDetail::with( 'coupon' )->with( 'student' )->where( 'coupon_id', $coupon->id )->get();

            if ( $coupon_details->count() > 0 ) {
                return view( 'dining.coupon.show', compact( 'coupon_details', 'dining' ) );
            } else {
                Toastr::info( 'No Coupon sold yet', 'info!!!' );

                return redirect()->back();
            }

        } else {
            Toastr::error( 'Anauthorized Access Denied', 'Error!!!' );

            return redirect()->back();
        }

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
        $coupon_detail = CouponDetail::with( 'coupon' )->findOrFail( $id );

        $coupon_date = (int) $coupon_detail->coupon->coupon_date->format( 'Ymd' );
        $current_date = (int) date( 'Ymd' );

        if ( $current_date === $coupon_date ) {
            if ( $coupon_detail->is_valid === 'unused' ) {
                $coupon_detail->is_valid = 'used';
            } else {
                $coupon_detail->is_valid = 'unused';
            }

            $coupon_detail->save();

            Toastr::success( 'Coupon Status Updated Successfully', 'Success!!!' );

            return redirect()->back();

        } else {

            Toastr::error( "You can't change status due to time issue!!!", 'Error!!!' );

            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        $dining = Dining::where( "email", Auth::user()->email )->first();

        $coupon = Coupon::where( 'id', $id )->where( 'dining_id', $dining->id )->first();

        $coupon_date = (int) date( 'Ymd', strtotime( $coupon->coupon_date ) );
        $current_date = (int) date( 'Ymd', strtotime( Carbon::now()->format( "Y-m-d" ) ) );

        //dd( $coupon_date );

        if ( $dining->id === $coupon->dining_id ) {

            if ( $current_date < $coupon_date ) {

                $coupon_details = CouponDetail::with( 'coupon' )->with( 'student' )->where( 'coupon_id', $coupon->id )->get();

                if ( $coupon_details->count() > 0 ) {

                    $count = 0;

                    foreach ( $coupon_details as $coupon_detail ) {

                        $coupon = Coupon::findOrFail( $coupon_detail->coupon_id );
                        $student = Student::findOrFail( $coupon_detail->student_id );

                        $student_user = User::where( 'email', $student->email )->first();
                        $student_balance = Balance::where( 'user_id', $student_user->id )->first();

                        $student_balance->amount += $coupon->unit_price;
                        $student_balance->save();

                        $student_transaction = new Transaction();
                        $student_transaction->user_id = $student_user->id;
                        $student_transaction->name = "Coupon Reversal by Auth (" . $coupon->coupon_date . " - " . $coupon->type . ")";
                        $student_transaction->type = "Credit";
                        $student_transaction->amount = $coupon->unit_price;
                        $student_transaction->save();

                        $count += 1;

                        $coupon_detail->delete();
                    }

                    $dining_user = User::where( 'email', $dining->email )->first();
                    $dining_balance = Balance::where( "user_id", $dining_user->id )->first();

                    $dining_balance->amount += ( $coupon->unit_price * $count );
                    $dining_balance->save();

                    $dining_transaction = new Transaction();
                    $dining_transaction->user_id = $dining_user->id;
                    $dining_transaction->name = "Coupon Reversal by Own (" . $coupon->coupon_date . " - " . $coupon->type . " - " . $count . " Units )";
                    $dining_transaction->type = "Credit";
                    $dining_transaction->amount = ( $coupon->unit_price * $count );
                    $dining_transaction->save();

                    $coupon->delete();

                    Toastr::success( 'Coupon Deleted Successully', 'Success!!!' );

                    return redirect()->back();

                } else {

                    $coupon->delete();

                    Toastr::success( 'No Sold Coupon Deleted Successully', 'Success!!!' );

                    return redirect()->back();
                }

            } else {

                Toastr::info( 'You are too late to cancel this coupon!', 'Info!!!' );

                return redirect()->back();
            }

        } else {
            Toastr::error( 'Anauthorized Access Denied', 'Error!!!' );

            return redirect()->back();
        }
    }
}
