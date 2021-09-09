<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponDetail extends Model
{
    public function coupon()
    {
        return $this->belongsTo( Coupon::class );
    }

    public function student()
    {
        return $this->belongsTo( Student::class );
    }
}
