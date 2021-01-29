<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $table = 'lab';

    public function labDiagnosis()
    {

        return $this->hasMany(LabDiagnosis::class);
    }

    public function labServices()
    {

        return $this->hasMany(LabServices::class);
    }
}
