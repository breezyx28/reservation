<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InvoicesListener
{

    public function handle($event)
    {
        $data = \App\Reservations::where(['token' => $event->token, 'statue' => 'accepted'])->with('hospitalInfo.docInfo', 'hospitalInfo.doctor', 'hospitalInfo.hospital')->get();
    }
}
