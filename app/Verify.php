<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verify extends Model
{
    protected $connection = 'doa';

    protected $table = 'verify';

    protected $fillable = ['usersHolderID'];
}
