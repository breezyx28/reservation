<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HospitalServicesController extends Controller
{
    public function index()
    {
        try {
            $data = \App\HospitalServices::with('hospital', 'services')->get();
            return ResponseMessage::Success('تم بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }
}
