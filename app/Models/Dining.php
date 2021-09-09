<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dining extends Model
{
    public function hall()
    {
        return $this->belongsTo( Hall::class );
    }
}
