<?php

namespace App\Http\Controllers\Dining;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponDetail;
use App\Models\Dining;
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
            'unit_price'  => 'required | integer',
            'max_count'   => 'required | integer',
        ];

        $validator = Validator::make( $inputs, $rules );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        $date = $request->input( 'coupon_date' );

        $dining = Dining::where( "email", Auth::user()->email )->first();

        $check = Coupon::where( 'dining_id', $dining->id )->where( 'coupon_date', $date )->count();

        $tomorrow = Carbon::tomorrow();

        if ( $check === 0 ) {

            if ( $date >= $tomorrow ) {

                $coupon = new Coupon();
                $coupon->dining_id = $dining->id;
                $coupon->coupon_date = $date;
                $coupon->unit_price = $request->input( 'unit_price' );
                $coupon->max_count = $request->input( 'max_count' );
                $coupon->save();

                Toastr::success( 'Date for Coupon Added Successfully', 'Success!!!' );

                return redirect()->back();

            } else {

                Toastr::error( "You can't assign previous days coupon!!!", 'Error!!!' );

                return redirect()->back();
            }

        } else {

            Toastr::error( 'Coupon for this date is already Asssigned', 'Error!!!' );

            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $coupon_date )
    {
        $dining = Dining::where( "email", Auth::user()->email )->first();

        $coupon = Coupon::where( 'coupon_date', $coupon_date )->where( 'dining_id', $dining->id )->first();

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

        $current_date = Carbon::now()->format( "Y-m-d" );

        if ( $current_date === $coupon_detail->coupon->coupon_date ) {
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
        //
    }
}
