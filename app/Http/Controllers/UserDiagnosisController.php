<?php

namespace App\Http\Controllers;

use App\Events\LabInvoiceEvent;
use App\Helper\ResponseMessage;
use App\Http\Controllers\Controller;
use App\UserDiagnosis;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\UserReservForm as UserReservForm;
use App\User;

class UserDiagnosisController extends Controller
{
    public function index()
    {
        try {
            $data = \App\UserDiagnosis::with('user', 'lab', 'labDiagnosis')->all()->chunk(100)->toArray();
            return ResponseMessage::Success('تم بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }

    public function getLabReservations()
    {
        $user = auth()->user();

        try {
            $data = \App\UserDiagnosis::where('labID', $user->userID)->with('user')->get();
            return ResponseMessage::Success('تم بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }

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

    public function acceptDiagnosis(Request $request) // for lab
    {
        $lab = auth()->user();

        if (!$lab->accountType == 'lab') {
            return ResponseMessage::Error('غير مصرح');
        }

        $validated = (object) $request->validate([
            'diagnosisToken' => 'required',
            'response' => 'required|boolean',
            'note' => 'string'
        ]);

        $query = \App\UserDiagnosis::where('attendToken', $validated->diagnosisToken);
        $note = isset($validated->note) ? $validated->note : null;

        try {

            [
                '0' => $query->update(['statue' => 'rejected', 'note' => $note]),
                '1' => $query->update(['statue' => 'accepted']),
            ][$validated->response];

            $data = event(new LabInvoiceEvent($validated->diagnosisToken))[0]->original;

            return ResponseMessage::Success('تم القبول بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }
}
