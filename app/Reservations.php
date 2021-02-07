<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    protected $table = 'reservations';
    protected $appends = ['servicesArray'];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function hospitalInfo()
    {
        return $this->belongsTo(hospitalInfo::class, 'hospitalInfoID');
    }

    public function getServicesArrayAttribute()
    {
        $data = Services::find(\App\Helper\ValidateArray::parse($this->attributes['servicesArray']));
        return $data;
    }
}
