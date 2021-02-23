<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\LabDiagnosisRequest;
use App\Http\Requests\UpdateLabDiagnosisRequest;
use App\LabDiagnosis;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LabDiagnosisController extends Controller
{
    public function index()
    {
        try {
            $data = \App\LabDiagnosis::with('lab', 'labServices')->all()->chunk(100)->toArray();
            return ResponseMessage::Success('تم بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }

    public function createLabDiagnosis(LabDiagnosisRequest $request)
    {

        $validate = (object) $request->validated();

        $labDiagnosis = new \App\LabDiagnosis();

        foreach ($validate as $key => $value) {
            $labDiagnosis->$key = $value;
        }

        $labDiagnosis->token = Str::uuid();

        try {
            $labDiagnosis->save();
            return ResponseMessage::Success('تم إضافة الفحص بنجاح', $labDiagnosis);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }

    public function update(UpdateLabDiagnosisRequest $request, LabDiagnosis $LabDiagnosisID)
    {

        $validate = (object) $request->validated();

        $labDiagnosis = \App\LabDiagnosis::find($LabDiagnosisID);

        foreach ($validate as $key => $value) {
            $labDiagnosis->$key = $value;
        }

        try {
            $labDiagnosis->save();
            return ResponseMessage::Success('تم تحديث الفحص بنجاح', $labDiagnosis);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }

    public function delete(LabDiagnosis $LabDiagnosisID)
    {

        try {
            \App\LabDiagnosis::find($LabDiagnosisID)->delete();
            return ResponseMessage::Success('تم حذف الفحص بنجاح');
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }
}
