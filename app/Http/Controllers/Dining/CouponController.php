<?php

namespace App\Http\Controllers\Dining;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Dining;
use Brian2694\Toastr\Facades\Toastr;
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
        $dining = Dining::where( "username", Auth::user()->username )->first();

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
        $dining = Dining::where( "username", Auth::user()->username )->first();

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

        $dining = Dining::where( "username", Auth::user()->username )->first();

        $check = Coupon::where( 'dining_id', $dining->id )->where( 'coupon_date', $date )->count();

        if ( $check === 0 ) {

            $coupon = new Coupon();
            $coupon->dining_id = $dining->id;
            $coupon->coupon_date = $date;
            $coupon->unit_price = $request->input( 'unit_price' );
            $coupon->max_count = $request->input( 'max_count' );
            $coupon->save();

            Toastr::success( 'Date for Coupon Added Successfully', 'Success!!!' );

            return redirect()->back();

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
