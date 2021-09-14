<?php

namespace App\Http\Controllers\Dining;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Coupon;
use App\Models\Dining;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $dining = Dining::where( "email", Auth::user()->email )->first();

        $coupon_count = Coupon::where( 'dining_id', $dining->id )->sum( 'sold_coupon' );
        $events_count = Coupon::where( 'dining_id', $dining->id )->count();

        $latest_coupons = Coupon::where( 'dining_id', $dining->id )->latest()->take( 15 )->get();

        $latest_transactions = Transaction::where( 'user_id', Auth::user()->id )->latest()->take( 15 )->get();

        $balance = Balance::where( 'user_id', Auth::user()->id )->where( 'hall_id', $dining->hall_id )->first();

        return view( "dining.dashboard", compact( 'coupon_count', 'events_count', 'latest_coupons', 'latest_transactions', 'balance' ) );
    }
}
