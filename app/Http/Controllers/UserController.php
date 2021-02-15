<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage as Resp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hospital;
use App\Http\Requests\ResetPasswordRequest;
use App\Lab;
use App\Http\Requests\updateUser as UpdateForm;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function updateProfile(UpdateForm $form)
    {
        $user = auth()->user();
        $validate = $form->validated();

        switch ($user->accountType) {
            case 'hospital':
                $hospital = Hospital::find($user->userID);

                foreach ($validate as $key => $value) {
                    $hospital->$key = $value;
                }

                try {
                    $hospital->save();
                    return Resp::Success('تم تحديث البيانات بنجاح', $hospital);
                } catch (\Exception $e) {
                    return Resp::Error('حدث خطأ ما', $e);
                }
                break;
            case 'lab':
                $lab = Lab::find($user->userID);
                foreach ($validate as $key => $value) {
                    $lab->$key = $value;
                }
                try {
                    $lab->save();
                    return Resp::Success('تم تحديث البيانات بنجاح', $lab);
                } catch (\Exception $e) {
                    return Resp::Error('حدث خطأ ما', $e);
                }
                break;
            default:
                return Resp::Error('غير مسموح لك بتعديل بياناتك');
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
                Resp::Error('عملية غير صحيحة');
                break;
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = auth()->user();

        $validated = (object) $request->validated();

        if (!Hash::check($validated->oldPassword, $user->password)) {
            return Resp::Error('كلمة السر القديمة غير صحيحة');
        }

        $newPassword = Hash::make($validated->newPassword);

        DB::beginTransaction();
        try {

            [
                'hospital' => \App\Hospital::where('id', $user->userID)->update(['password' => $newPassword]),
                'lab' => \App\Lab::where('id', $user->userID)->update(['password' => $newPassword])
            ][$user->accountType];

            \App\User::where('userID', $user->userID)->update(['password' => $newPassword]);

            DB::commit();
            return Resp::Success('تم تغيير كلمة السر بنجاح', "new pasword is : $validated->newPassword");
        } catch (\Exception $e) {
            DB::rollback();
            return Resp::Error('لم يتم تعين كلمة السر', $e->getMessage());
        }
    }

    public function forgetPassword(Request $request)
    {
        $user = auth()->user();
    }
}
