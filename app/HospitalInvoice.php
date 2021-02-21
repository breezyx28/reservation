<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HospitalInvoice extends Model
{
    protected $table = 'hospital_invoice';

    public function users()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}
