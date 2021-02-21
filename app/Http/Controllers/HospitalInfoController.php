<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage;
use App\HospitalInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HospitalInfoController extends Controller
{
    public function index()
    {
        $hospital = new HospitalInfo();
        try {

            $data = $hospital->with('doctor', 'docInfo', 'docSchedule', 'hospital')->all()->chunk(50)->toArray();

            return ResponseMessage::Success('تم بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }
}
