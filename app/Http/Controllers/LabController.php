<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Lab;
use Illuminate\Http\Request;

class LabController extends Controller
{
    // public function view(Lab $lab)
    // {
    //     try {
    //         $data = $lab::all()->chunk(100)->toArray();
    //         return ResponseMessage::Success('تم بنجاح', $data);
    //     } catch (\Exception $e) {
    //         return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
    //     }
    // }
}
