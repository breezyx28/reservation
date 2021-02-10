<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocSchedule extends Model
{
    protected $table = 'doc_schedule';

    public function hospitalInfo()
    {
        return $this->hasOne('App\HospitalInfo', 'docSchduleID');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }
}
