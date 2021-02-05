<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    protected $table = 'reservations';

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function hospitalInfo()
    {
        return $this->belongsTo(hospitalInfo::class, 'hospitalInfoID');
    }

    public function getSevrvicesArrayAttribute($value)
    {
        return Services::find($value);
    }
}
