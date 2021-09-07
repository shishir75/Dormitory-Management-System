<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HallRoom extends Model
{
    public function hall()
    {
        return $this->belongsTo( Hall::class );
    }
}
