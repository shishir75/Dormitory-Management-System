<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function dept()
    {
        return $this->belongsTo( Dept::class );
    }

    public function session()
    {
        return $this->belongsTo( Session::class );
    }

    public function hall()
    {
        return $this->belongsTo( Hall::class );
    }

    public function balance()
    {
        return $this->belongsTo( Balance::class );
    }

    public function transactions()
    {
        return $this->hasMany( Transaction::class );
    }

}
