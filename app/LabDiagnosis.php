<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabDiagnosis extends Model
{
    protected $table = 'lab_diagnosis';


    public function lab()
    {
        return $this->belongsTo(Lab::class, 'labID');
    }

    public function labServices()
    {
        return $this->hasMany(LabServices::class, 'labID', 'labID');
    }
}
