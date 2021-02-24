<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\LabServicesRequest;
use App\Http\Requests\UpdateLabServicesRequest;
use App\LabServices;
use Illuminate\Support\Str;

class LabServicesController extends Controller
{
    public function viewLabServices()
    {
        $user = auth()->user();

        try {
            $data = \App\LabServices::where('labID', $user->userID)->get();

            return ResponseMessage::Success('تم بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ في جلب البيانات', $e->getMessage());
        }
    }

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

    public function update(UpdateLabServicesRequest $request, LabServices $labServicesID)
    {
        $validate = (object) $request->validated();

        $labServices = $labServicesID;

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
            $labServicesID->delete();
            return ResponseMessage::Success('تم حذف الخدمة بنجاح');
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e);
        }
    }
}
