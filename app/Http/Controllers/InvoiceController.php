<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        try {
            $data = \App\Invoice::with('users')->all()->chunk(100)->toArray();
            return ResponseMessage::Success('تم بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }

    public function viewLabInvoice()
    {
        $user = auth()->user();
        // first get hospital reservations data
        $userDiagData = \App\UserDiagnosis::where('labID', $user->userID)->where('statue', 'accepted')->pluck('attendToken');

        try {
            // get the data from invoices table
            $data = \App\Invoice::whereIn('userAttendToken', $userDiagData)->with('users')->get();
            return ResponseMessage::Success('تم بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }
}
