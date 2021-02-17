<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDiagnosis extends Model
{
    protected $table = 'user_diagnosis';
    // protected $appends = ['service'];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function lab()
    {
        return $this->belongsTo(Lab::class, 'labID');
    }

    public function labDiagnosis()
    {
        return $this->belongsTo(LabDiagnosis::class, 'labDiagnosisID');
    }

    public function getServiceAttribute()
    {
        $data = LabServices::find(\App\Helper\ValidateArray::parse($this->attributes['service']));
        return $data;
    }
}
