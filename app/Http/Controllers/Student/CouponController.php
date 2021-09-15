<?php

namespace App\Http\Controllers\Student;

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
use Illuminate\Support\Str;

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

        $user = User::where( "name", $student->name )->first();

        $balance = Balance::where( 'user_id', $user->id )->where( 'hall_id', $student->hall->id )->first();

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
        $student = Student::where( 'email', Auth::user()->email )->first();
        $coupon_detail_old = CouponDetail::where( 'coupon_id', $coupon_id )->where( 'student_id', $student->id )->first();

        if ( $coupon_detail_old == null ) {
            $check = 0;
        } else {
            $check = CouponDetail::where( "coupon_no", $coupon_detail_old->coupon_no )->count();
        }

        $dining = Dining::where( 'hall_id', $student->hall_id )->first();
        $dining_user = User::where( 'email', $dining->email )->first();
        $dining_user_balance = Balance::where( 'user_id', $dining_user->id )->where( 'hall_id', $student->hall_id )->first();

        $coupon = Coupon::findOrFail( $coupon_id );

        //$tomorrow = Carbon::tomorrow()->format( "Ymd" );

        $coupon_date = date( 'Ymd', strtotime( $coupon->coupon_date ) );

        //dd( $coupon_date );

        $coupon_no_new = $coupon_date . "-" . $dining->id . "-" . $student->id . "-" . $coupon->type;

        $balance = Balance::where( "user_id", Auth::user()->id )->first();

        if ( $balance === null || $balance->amount < $coupon->unit_price ) {

            Toastr::error( 'You have insufficient balance to buy a food coupon. Plz Add Money from Hall Office!!!', 'Error!!!' );

            return redirect()->back();

        } else {

            if ( $check < 1 ) {
                $coupon_detail = new CouponDetail();
                $coupon_detail->coupon_id = $coupon_id;
                $coupon_detail->student_id = $student->id;
                $coupon_detail->coupon_no = $coupon_no_new;
                $coupon_detail->is_valid = "unused";
                $coupon_detail->save();

                $coupon->sold_coupon += 1;
                $coupon->save();

                $balance->amount -= $coupon->unit_price;
                $balance->save();

                $transaction = new Transaction();
                $transaction->user_id = Auth::user()->id;
                $transaction->name = "Buy Food Coupon (" . $coupon->coupon_date->format( 'Y-m-d' ) . "-" . $coupon->type . ")";
                $transaction->type = "Debit";
                $transaction->amount = $coupon->unit_price;
                $transaction->save();

                $dining_transaction = new Transaction();
                $dining_transaction->user_id = $dining_user->id;
                $dining_transaction->name = "Sold Food Coupon (" . $coupon->coupon_date->format( 'Y-m-d' ) . "-" . $student->id . "-" . $coupon->type . ")";
                $dining_transaction->type = "Debit";
                $dining_transaction->amount = $coupon->unit_price;
                $dining_transaction->save();

                if ( $dining_user_balance === null ) {

                    $dining_user_balance = new Balance();
                    $dining_user_balance->user_id = $dining_user->id;
                    $dining_user_balance->hall_id = $student->hall_id;
                    $dining_user_balance->amount = "-" . $coupon->unit_price;
                    $dining_user_balance->save();

                } else {
                    $dining_user_balance->amount -= $coupon->unit_price;
                    $dining_user_balance->save();
                }

                Toastr::success( 'Coupon Purchaged Successfully', 'Success!!!' );

                return redirect()->back();

            } else {
                Toastr::error( 'You already Purchaged Coupon for this Day', 'Error!!!' );

                return redirect()->back();
            }
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
        $coupon_detail = CouponDetail::findOrFail( $id );

        $current_date = (int) Carbon::now()->format( "Ymd" );

        $coupon_date_from_coupon_no = (int) Str::substr( $coupon_detail->coupon_no, 0, 8 );

        $student = Student::where( 'email', Auth::user()->email )->first();
        $dining = Dining::where( 'hall_id', $student->hall_id )->first();
        $dining_user = User::where( 'email', $dining->email )->first();
        $dining_user_balance = Balance::where( 'user_id', $dining_user->id )->where( 'hall_id', $student->hall_id )->first();

        if ( $current_date < $coupon_date_from_coupon_no ) {
            $coupon = Coupon::findOrFail( $coupon_detail->coupon->id );
            $coupon->sold_coupon -= 1;
            $coupon->save();

            $balance = Balance::where( "user_id", Auth::user()->id )->first();
            $balance->amount += $coupon->unit_price;
            $balance->save();

            $transaction = new Transaction();
            $transaction->user_id = Auth::user()->id;
            $transaction->name = "Food Coupon Reversal (" . $coupon->coupon_date->format( 'Y-m-d' ) . "-" . $coupon->type . ")";
            $transaction->type = "Credit";
            $transaction->amount = $coupon->unit_price;
            $transaction->save();

            $dining_transaction = new Transaction();
            $dining_transaction->user_id = $dining_user->id;
            $dining_transaction->name = "Sold Food Coupon Reversal (" . $coupon->coupon_date->format( 'Y-m-d' ) . "-" . $student->id . "-" . $coupon->type . ")";
            $dining_transaction->type = "Credit";
            $dining_transaction->amount = $coupon->unit_price;
            $dining_transaction->save();

            $dining_user_balance->amount += $coupon->unit_price;
            $dining_user_balance->save();

            $coupon_detail->delete();

            Toastr::success( 'Coupon Cancelled Successfully', 'Success!' );

            return redirect()->back();

        } else {
            Toastr::error( "You can't Cancel this Coupon!!!", 'Error!' );

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
