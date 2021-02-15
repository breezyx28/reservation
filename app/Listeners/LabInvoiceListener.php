<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LabInvoiceListener
{

    public function handle($event)
    {
        $data = \App\UserDiagnosis::where(['attendToken' => $event->token, 'statue' => 'accepted'])->with('labDiagnosis', 'lab')->get();
    }
}
