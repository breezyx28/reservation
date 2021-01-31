<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage;
use App\Http\Controllers\Controller;
use App\UserDiagnosis;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\UserReservForm as UserReservForm;

class UserDiagnosisController extends Controller
{
    public function userDiagnosis(Request $request, UserReservForm $UserReservForm)
    {
        $validated = (object) $UserReservForm->validated();

        $reservLab  = new UserDiagnosis();

        $reservLab->userID = auth()->user()->userID;
        $reservLab->labDiagnosisID = $validated->labDiagnosisID;
        $reservLab->labID = $validated->labID;
        $reservLab->service = isset($validated->services) ? json_encode($validated->services) : null;
        $reservLab->attendToken = Str::random(20) . rand(1000, 9999999);
        $reservLab->statue = 'live';
        $reservLab->note = $request['note'];

        try {

            $reservLab->save();

            return ResponseMessage::Success('نجاح', $reservLab);
        } catch (\Exception $e) {

            return ResponseMessage::Error('error', $e->getMessage());

            return ResponseMessage::Error('حدث خطأ ما', null);
        }
    }
}
