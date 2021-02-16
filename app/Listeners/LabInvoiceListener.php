<?php

namespace App\Listeners;

use App\Helper\ResponseMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\support\Str;

class LabInvoiceListener
{

    public function handle($event)
    {
        // data of lab reservations
        $data = \App\UserDiagnosis::where(['attendToken' => $event->token, 'statue' => 'accepted'])->with('labDiagnosis', 'lab')->get();

        // filter and calculate data before insert
        $userID = $data['userID'];
        $total = $data->userID;

        // prepare to insert into invoice
        $invoice = new \App\Invoice();

        $invoice->invoiceToken = Str::random(20) . rand(1000, 9999999);
        $invoice->userAttendToken = $event->token;
        $invoice->userID = $userID;

        // calculate total
        $invoice->total = $data->sum('price');

        try {
            $invoice->save();
            return true;
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }
}
