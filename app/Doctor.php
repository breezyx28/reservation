<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctor';

    protected $hidden = [
        'password',
    ];


    public function docInfo()
    {
        return $this->hasMany('App\DocInfo', 'docID');
    }

    public function docSchedule()
    {
        return $this->hasMany('App\DocSchedule', 'docID');
    }

    public function hospitalInfo()
    {
        return $this->hasMany('App\HospitalInfo', 'docID');
    }
}
