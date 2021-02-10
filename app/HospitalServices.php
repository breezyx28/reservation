<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HospitalServices extends Model
{
    protected $table = 'hospital_services';

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospitalID');
    }

    public function hospitalInfo()
    {
        return $this->hasMany(HospitalInfo::class, 'hospitalID');
    }

    public function services()
    {
        return $this->belongsTo(Services::class, 'servicesID');
    }
}
