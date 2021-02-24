<?php

namespace App\Http\Controllers;

use App\Events\HospitalServicesEvent;
use App\Helper\ResponseMessage;
use App\HospitalServices;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServicesRequest;
use App\Http\Requests\UpdateHospitalServicesRequest;
use App\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    public function index()
    {
        try {
            $data = \App\LabServices::with('lab')->all()->chunk(100)->toArray();
            return ResponseMessage::Success('تم بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }

    public function viewHospitalServices()
    {
        $user = auth()->user();

        try {
            $data = \App\HospitalServices::where('hospitalID', $user->userID)->with('services')->get();

            $array = [];
            foreach ($data as $key => $value) {
                if ($data[$key] == 'services') {
                    array_push($array, $value);
                }
            }

            return ResponseMessage::Success('تم بنجاح', $array);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ في جلب البيانات', $e->getMessage());
        }
    }

    public function create(ServicesRequest $request)
    {
        $validate = (object) $request->validated();
        $hospitalID = auth()->user()->userID;
        $services = new \App\Services();
        $hospitalServices = new \App\HospitalServices();

        foreach ($validate as $key => $value) {
            $services->$key = $value;
        }

        DB::beginTransaction();

        try {

            $services->save();
            $hospitalServices->servicesID = $services->id;
            $hospitalServices->hospitalID = $hospitalID;
            $hospitalServices->save();

            DB::commit();
            return ResponseMessage::Success('تم إضافة الفحص بنجاح', $services);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }

    public function update(UpdateHospitalServicesRequest $request, Services $serviceID)
    {
        $validate = (object) $request->validated();

        $services = \App\Services::find($serviceID);

        foreach ($validate as $key => $value) {
            $services->$key = $value;
        }

        try {

            $services->save();

            return ResponseMessage::Success('تم تحديث الخدمة بنجاح', $services);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }

    public function delete(Services $serviceID)
    {
        $user = auth()->user();

        DB::beginTransaction();
        try {
            \App\Services::find($serviceID)->delete();
            \App\HospitalServices::where(['servicesID' => $serviceID, 'hospitalID' => $user->userID])->delete();
            DB::commit();
            return ResponseMessage::Success('تم حذف الخدمة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }
}
