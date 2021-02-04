<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage as Resp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Doctor;
use App\Lab;
use App\Http\Requests\updateUser as UpdateForm;

class UserController extends Controller
{
    private $roles = [0 => 'admin', 1 => 'hospital', 2 => 'lab'];

    public function updateProfile(Request $request, UpdateForm $form)
    {
        $user = auth()->user();
        $validate = $form->validated();

        switch ($user->role) {
            case 1:
                $doc = Doctor::find($user->id);
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

    public function resetPassword(Request $request)
    {

        $user = auth()->user();
    }
}
