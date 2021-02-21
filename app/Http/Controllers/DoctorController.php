<?php

namespace App\Http\Controllers;

use App\DocInfo;
use App\DocSchedule;
use App\Doctor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Helper\ResponseMessage;
use App\HospitalInfo;
use App\http\Requests\doctorRequest as DoctorForm;

class DoctorController extends Controller
{
    // public function view(Doctor $doctor)
    // {
    //     try {

    //         $data = $doctor::all()->chunk(100)->toArray();
    //         return ResponseMessage::Success('تم بنجاح', $data);
    //     } catch (\Exception $e) {
    //         return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
    //     }
    // }

    public function createDoctor(DoctorForm $request)
    {
        $this->authorize('create', Doctor::class);

        $validate = (object) $request->validated();

        $user = auth()->user()->userID;
        $doctor = new Doctor();
        $doctorInfo = new DocInfo();
        $doctorSchdule = new DocSchedule();
        $hospitalInfo = new HospitalInfo();

        $doctor->fullName = $validate->fullName;
        $doctor->gender = $validate->gender;
        $doctor->phone = $validate->phone;
        $doctor->email = $validate->email;

        DB::beginTransaction();
        try {

            $doctor->save();

            $doctorInfo->specialization = $validate->specialization;
            $doctorInfo->interviewPrice = $validate->interviewPrice;

            $doctorInfo->docID = $doctor->id;

            $doctorSchdule->docID = $doctor->id;

            $doctorInfo->save();
            $doctorSchdule->save();

            $hospitalInfo->docID = $doctor->id;
            $hospitalInfo->docInfoID = $doctorInfo->id;
            $hospitalInfo->docScheduleID = $doctorSchdule->id;
            $hospitalInfo->hospitalID = $user;

            $hospitalInfo->save();

            DB::commit();
            return ResponseMessage::Success('تم حفظ الطبيب بنجاج', $doctor);
        } catch (\Throwable $e) {
            DB::rollBack();
            return ResponseMessage::Error('حدث خطأ ما اثناء حفظ الطبيب', $e->getMessage());
        }
    }
}
