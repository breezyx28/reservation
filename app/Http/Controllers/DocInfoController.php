<?php

namespace App\Http\Controllers;

use App\DocInfo;
use App\Helper\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateDocInfoRequest;
use Illuminate\Http\Request;

class DocInfoController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        try {
            $data = \App\DocInfo::where('docID', $user->userID)->get();
            return ResponseMessage::Success('تم بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ في جلب البيانات', $e->getMessage());
        }
    }
    public function update(UpdateDocInfoRequest $request, DocInfo $docInfoID)
    {

        $validated = (object) $request->validated();

        $docInfo = $docInfoID;

        foreach ($validated as $key => $value) {
            $docInfo->$key = $value;
        }

        try {
            $docInfo->save();
            return ResponseMessage::Success('تم تحديث بيانات الدكتور');
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما أثناء تحديث بيانات الدكتور', $e->getMessage());
        }
    }

    public function delete(DocInfo $docInfoID)
    {
        try {
            \App\DocInfo::find($docInfoID)->delete();
            return ResponseMessage::Success('تم حذف بيانات الدكتور');
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما أثناء حذف بيانات الدكتور', $e->getMessage());
        }
    }
}
