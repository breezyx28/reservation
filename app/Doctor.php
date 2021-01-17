<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctor';

    public function docInfo()
    {
        return $this->hasMany('App\DocInfo', 'docInfoID');
    }

    public function docSchedula()
    {
        return $this->hasMany('App\DocSchedule', 'docScheduleID');
    }

    public function hospitalInfo()
    {
        return $this->hasMany('App\HospitalInfo', 'hospitalInfoID');
    }
}
