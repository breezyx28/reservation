<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\LabServicesRequest;
use App\Http\Requests\UpdateLabDiagnosisRequest;
use App\LabServices;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LabServicesController extends Controller
{
    public function create(LabServicesRequest $request)
    {
        $user = auth()->user();
        $validate = (object) $request->validated();

        $labServices = new \App\LabServices();

        foreach ($validate as $key => $value) {
            $labServices->$key = $value;
        }

        $labServices->token = Str::uuid();
        $labServices->labID = $user->userID;

        try {
            $labServices->save();
            return ResponseMessage::Success('تم إضافة خدمة جديدة بنجاح', $labServices);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e);
        }
    }

    public function update(UpdateLabDiagnosisRequest $request, LabServices $labServicesID)
    {

        $validate = (object) $request->validated();

        $labServices = \App\LabServices::find($labServicesID);

        foreach ($validate as $key => $value) {
            $labServices->$key = $value;
        }

        try {
            $labServices->save();
            return ResponseMessage::Success('تم تحديث الخدمة بنجاح', $labServices);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e);
        }
    }

    public function delete(LabServices $labServicesID)
    {

        try {
            \App\LabServices::find($labServicesID)->delete();
            return ResponseMessage::Success('تم حذف الخدمة بنجاح');
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e);
        }
    }
}
