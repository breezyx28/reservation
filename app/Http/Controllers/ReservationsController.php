<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage, App\Helper\ValidateArray;
use App\Reservations;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest as ReservForm;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReservationsController extends Controller
{
    public function reservDoc(Request $request, ReservForm $ReservForm)
    {

        $validated = (object) $ReservForm->validated();

        $reserv  = new Reservations();

        $reserv->userID = auth()->user()->userID;
        $reserv->hospitalInfoID = $validated->hospitalInfoID;
        $reserv->servicesArray = isset($validated->servicesArray) ? json_encode($validated->servicesArray) : null;
        $reserv->token = Str::random(20) . rand(1000, 9999999);
        $reserv->statue = 'live';
        $reserv->note = $request['note'];

        try {

            $reserv->save();

            return ResponseMessage::Msg(true, 'نجاح', null, $reserv);
        } catch (\Exception $e) {

            // return ResponseMessage::Msg(false, null, null, $e->getMessage());

            return ResponseMessage::Msg(false, null, 'حدث خطأ ما', null);
        }
    }
}
