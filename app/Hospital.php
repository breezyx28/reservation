<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $table = 'hospital';

    protected $hidden = [
        'password',
    ];


    public function docInfo()
    {
        return $this->hasMany('App\DocInfo');
    }

    public function hospitalInfo()
    {
        return $this->hasMany('App\HospitalInfo');
    }
}
