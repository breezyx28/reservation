<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HospitalInfo extends Model
{
    protected $table = 'hospital_info';


    public function doctor()
    {
        return $this->belongsTo('App\Doctor', 'docID');
    }

    public function docInfo()
    {
        return $this->belongsTo('App\DocInfo', 'docInfoID');
    }

    public function docSchedule()
    {
        return $this->belongsTo('App\DocSchedule', 'docID', 'docID');
    }

    public function hospital()
    {
        return $this->belongsTo('App\Hospital', 'hospitalID');
    }
}
