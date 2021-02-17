<?php

namespace App\Listeners;

use App\Helper\ResponseMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\support\Str;

class LabInvoiceListener
{
    // for lab
    public function handle($event)
    {
        // data of lab reservations
        $data = \App\UserDiagnosis::where(['attendToken' => $event->token, 'statue' => 'accepted'])->with('labDiagnosis', 'lab')->get();

        $price = 0;
        $services = [];
        $servicesTotal = 0;
        $labEarn = $data[0]->lab->companyEarns;

        // lab diagnosis prices on array ($services)
        foreach ($data as $key => $value) {
            $price += $data[$key]->labDiagnosis->price;
            $services[] = $data[$key]->service;
        }

        // lab services prices ($servicesTotal)
        foreach ($services as $key => $values) {
            foreach ($values as $value) {
                $servicesTotal += $value->price;
            }
        }


        // filter and calculate data before insert
        $userID = $data[0]['userID'];
        $total = ($servicesTotal + $price) * $labEarn;

        // prepare to insert into invoice
        $invoice = new \App\Invoice();

        $invoice->invoiceToken = Str::random(20) . rand(1000, 9999999);
        $invoice->userAttendToken = $event->token;
        $invoice->userID = $userID;

        // calculate total
        $invoice->total = $total;

        try {
            $invoice->save();
            return $invoice;
        } catch (\Exception $e) {

            ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
            return false;
        }
    }
}
