<?php

namespace App\Http\Controllers;

use App\Events\InvoicesEvent;
use App\Helper\ResponseMessage;
use App\Helper\DocAvilable;
use App\Reservations;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest as ReservForm;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReservationsController extends Controller
{
    public function index()
    {
        try {
            $data = \App\Reservations::with('user', 'hospitalInfo')->all()->chunk(100)->toArray();
            return ResponseMessage::Success('تم بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }

    public function viewtHospitalReservations()
    {
        $user = auth()->user();
        $hospInfo = \App\HospitalInfo::where('hospitalID', $user->userID)->pluck('id');
        try {
            $data = \App\Reservations::whereIn('hospitalInfoID', $hospInfo)->with('user')->get();
            return ResponseMessage::Success('تم بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }

    public function reservDoc(Request $request, ReservForm $ReservForm)
    {

        $validated = (object) $ReservForm->validated();

        $reserv  = new Reservations();

        $reserv->userID = auth()->user()->userID;
        $reserv->hospitalInfoID = $validated->hospitalInfoID;
        $reserv->servicesArray = isset($validated->servicesArray) ? json_encode($validated->servicesArray) : null;
        $reserv->atDay = $validated->atDay;
        $reserv->token = Str::random(20) . rand(1000, 9999999);
        $reserv->statue = 'live';
        $reserv->note = $request['note'];

        if (DocAvilable::checkDate($validated->hospitalInfoID, $validated->atDay)) {
            return ResponseMessage::Error('الطبيب غير متوفر في هذا التاريخ ... تأكد من جدول عمله جيدا');
        }

        try {

            $reserv->save();

            return ResponseMessage::Msg(true, 'نجاح', null, $reserv);
        } catch (\Exception $e) {

            // return ResponseMessage::Msg(false, null, null, $e->getMessage());

            return ResponseMessage::Msg(false, null, 'حدث خطأ ما', null);
        }
    }

    public function acceptReservation(Request $request) // for hospital
    {
        $hospital = auth()->user();

        if (!$hospital->accountType == 'hospital') {
            return ResponseMessage::Error('غير مصرح');
        }

        $validated = (object) $request->validate([
            'reservationsToken' => 'required',
            'response' => 'required|boolean',
            'note' => 'string'
        ]);

        $query = \App\Reservations::where('token', $validated->reservationsToken);
        $note = isset($validated->note) ? $validated->note : null;

        try {

            [
                '0' => $query->update(['statue' => 'rejected', 'note' => $note]),
                '1' => $query->update(['statue' => 'accepted']),
            ][$validated->response];

            $data = event(new InvoicesEvent($validated->reservationsToken))[0]->original;

            return ResponseMessage::Success('تم القبول بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }
}
