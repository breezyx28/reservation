<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabServices extends Model
{
    protected $table = 'lab_services';

    public function lab()
    {
        return $this->belongsTo(Lab::class, 'labID');
    }
}
