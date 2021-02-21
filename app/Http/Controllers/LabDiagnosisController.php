<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
