<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    public function Student()
    {
        return $this->belongsTo( Student::class );
    }
}
