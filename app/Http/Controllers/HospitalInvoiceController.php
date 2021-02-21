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
}
