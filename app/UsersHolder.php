<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersHolder extends Model
{

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'doa';

    protected $table = 'users';
}
