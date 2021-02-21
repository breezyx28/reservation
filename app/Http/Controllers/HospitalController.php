<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage;
use App\Hospital;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    // public function view(Hospital $hospital)
    // {
    //     try {

    //         $data = $hospital::all()->chunk(100)->toArray();
    //         return ResponseMessage::Success('تم بنجاح', $data);
    //     } catch (\Exception $e) {
    //         return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
    //     }
    // }
}
