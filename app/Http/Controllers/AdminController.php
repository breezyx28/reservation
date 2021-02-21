<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage;
use App\Hospital;
use App\Http\Requests\HospitalRequest;
use App\Http\Requests\LabRequest;
use App\Lab;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function createHospital(HospitalRequest $request)
    {

        $validated = (object) $request->validated();

        $hospital = new \App\Hospital();

        foreach ($validated as $key => $value) {
            $hospital->$key = $value;
        }

        try {
            $hospital->save();
            return ResponseMessage::Success('تم بنجاح');
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }

    public function createLab(LabRequest $request)
    {

        $validated = (object) $request->validated();

        $lab = new \App\Lab();

        foreach ($validated as $key => $value) {
            $lab->$key = $value;
        }

        try {
            $lab->save();
            return ResponseMessage::Success('تم بنجاح');
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }
}
