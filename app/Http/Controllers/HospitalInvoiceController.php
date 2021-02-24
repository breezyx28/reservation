<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HospitalInvoiceController extends Controller
{
    public function index()
    {
        try {
            $data = \App\HospitalInvoice::with('users')->all()->chunk(100)->toArray();
            return ResponseMessage::Success('تم بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }

    public function getHospitalInvoice()
    {
        $user = auth()->user();
        // first get hospital info
        $hospInfo = \App\HospitalInfo::where('hospitalID', $user->userID)->pluck('id');
        // second get hospital reservations data
        $reservData = \App\Reservations::whereIn('hospitalInfoID', $hospInfo)->where('statue', 'accepted')->pluck('token');

        try {
            // get the data from invoices table
            $data = \App\HospitalInvoice::whereIn('reservationToken', $reservData)->get();
            return ResponseMessage::Success('تم بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }
}
