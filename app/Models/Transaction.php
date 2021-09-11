<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function student()
    {
        return $this->belongsTo( Student::class );
    }
}
