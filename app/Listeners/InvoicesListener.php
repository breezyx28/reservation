<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\support\Str;
use App\Helper\ResponseMessage;

class InvoicesListener
{
    // for hospital
    public function handle($event)
    {
        // data of hospital reservation
        $data = \App\Reservations::where(['token' => $event->token, 'statue' => 'accepted'])->with('hospitalInfo.docInfo', 'hospitalInfo.doctor', 'hospitalInfo.hospital')->get();

        $price = 0;
        $services = [];
        $servicesTotal = 0;
        $hospitalEarn = $data[0]->hospitalInfo->hospital->companyEarns / 100;

        // lab diagnosis prices on array ($services)
        foreach ($data as $key => $value) {
            $price += $data[$key]->hospitalInfo->docInfo->interviewPrice;
            $services[] = $data[$key]->servicesArray;
        }

        // lab services prices ($servicesTotal)
        foreach ($services as $key => $values) {
            foreach ($values as $value) {
                $servicesTotal += $value->price;
            }
        }

        // filter and calculate data before insert
        $userID = $data[0]['userID'];
        $total = (($servicesTotal + $price) * $hospitalEarn) + ($servicesTotal + $price);

        // prepare to insert into invoice
        $invoice = new \App\HospitalInvoice();

        $invoice->invoiceToken = Str::random(20) . rand(1000, 9999999);
        $invoice->reservationToken = $event->token;
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
