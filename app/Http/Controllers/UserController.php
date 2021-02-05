<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage as Resp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hospital;
use App\Lab;
use App\Http\Requests\updateUser as UpdateForm;
use App\LabDiagnosis;
use App\User;

class UserController extends Controller
{

    public function updateProfile(UpdateForm $form)
    {
        $user = auth()->user();
        $validate = $form->validated();

        switch ($user->role) {
            case 1:
                $doc = Hospital::find($user->id);
                foreach ($validate as $key => $value) {
                    $doc->$key = $value;
                }

                try {
                    $doc->save();
                    return Resp::Success('تم تحديث البيانات بنجاح', $doc);
                } catch (\Throwable $th) {
                    return Resp::Error('حدث خطأ ما', null);
                }
                break;
            case 2:
                $lab = Lab::find($user->id);
                foreach ($validate as $key => $value) {
                    $lab->$key = $value;
                }
                try {
                    $lab->save();
                    return Resp::Success('تم تحديث البيانات بنجاح', $lab);
                } catch (\Throwable $th) {
                    return Resp::Error('حدث خطأ ما', null);
                }
                break;
        }
    }

    public function previousReservation(Request $request)
    {
        $this->authorize('create', User::class);

        $prev = $request['type'];

        switch ($prev) {
            case 'hospital':
                $data = \App\Reservations::where('userID', auth()->user()->userID)->with('hospitalInfo.hospital', 'hospitalInfo.docInfo', 'hospitalInfo.docSchedule', 'hospitalInfo.doctor')->groupBy('token')->get();
                return Resp::Success('الطلبات السابقة للمستشفيات', $data);
                break;
            case 'lab':
                $data = \App\UserDiagnosis::where('userID', auth()->user()->userID)->with(['lab' => function ($query) {
                    $query->select('id', 'name', 'phone', 'state', 'city', 'address', 'email', 'lat', 'lng')->groupBy('attendToken')->get();
                }, 'labDiagnosis'])->groupBy('attendToken')->get();
                return Resp::Success('الطلبات السابقة للمعامل', $data);
                break;
            default:
                Resp::Error('عملية غير صحيحة', null);
                break;
        }
    }

    public function resetPassword(Request $request)
    {
        $user = auth()->user();
    }
}
