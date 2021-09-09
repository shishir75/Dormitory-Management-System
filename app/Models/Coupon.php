<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public function coupon_details()
    {
        return $this->hasMany( CouponDetail::class );
    }
}
