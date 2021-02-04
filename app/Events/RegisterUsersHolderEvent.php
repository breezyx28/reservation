<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RegisterUsersHolderEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $table;

    public function __construct($user, $table)
    {
        $this->table = $table;
        $this->user = $user;
    }
}
