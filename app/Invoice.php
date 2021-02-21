<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';

    public function users()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}
