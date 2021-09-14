<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

    protected $dates = ['coupon_date'];

    public function coupon_details()
    {
        return $this->hasMany( CouponDetail::class );
    }
}
