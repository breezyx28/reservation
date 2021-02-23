<?php

namespace App\Http\Controllers;

use App\DocSchedule;
use App\Helper\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateDocScheduleRequest;
use Illuminate\Http\Request;

class DocScheduleController extends Controller
{
    public function update(UpdateDocScheduleRequest $request, DocSchedule $docScheduleID)
    {
        $validated = (object) $request->validated();
        $docSchedule = \App\DocSchedule::find($docScheduleID);

        // save doctor schedule
        foreach ($validated as $key => $value) {
            $docSchedule->$key = $value;
        }

        try {
            $docSchedule->save();
            return ResponseMessage::Success('تم اضافة الجدول بنجاح', $docSchedule);
        } catch (\Exception $e) {

            return ResponseMessage::Error('حدث خطأ في اضافة البيانات', $e->getMessage());
        }
    }

    public function delete(DocSchedule $docScheduleID)
    {

        try {
            \App\DocSchedule::find($docScheduleID)->delete();
            return ResponseMessage::Success('تم حذف الجدول بنجاح');
        } catch (\Exception $e) {

            return ResponseMessage::Error('حدث خطأ في حذف البيانات', $e->getMessage());
        }
    }
}
