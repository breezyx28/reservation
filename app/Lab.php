<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $table = 'lab';

    protected $fillable = ['password'];

    protected $hidden = [
        'password',
    ];

    public function labDiagnosis()
    {

        return $this->hasMany(LabDiagnosis::class);
    }

    public function labServices()
    {

        return $this->hasMany(LabServices::class);
    }
}
