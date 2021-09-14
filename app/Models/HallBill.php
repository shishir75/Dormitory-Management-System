<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HallBill extends Model
{

    protected $dates = ['start_month', 'end_month'];

    public function student()
    {
        return $this->belongsTo( Student::class );
    }

}
