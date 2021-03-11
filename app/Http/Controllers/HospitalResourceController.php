<?php

namespace App\Http\Controllers;

use App\Hospital;
use App\Helper\ResponseMessage;
use Illuminate\Http\Request;
use App\Http\Requests\HospitalRequest;
use App\Http\Requests\updateUser as UpdateForm;
use App\Events\RegisterUsersHolderEvent;
use Illuminate\Support\Facades\Hash;
use Facade\FlareClient\Http\Response;

class HospitalResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $data = \App\Hospital::all();
            return ResponseMessage::Success('تم بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(HospitalRequest $request)
    {
        $validate = (object) $request->validated();

        $hospital = new Hospital();

        $hospital->name = $validate->name;
        $hospital->phone = $validate->phone;
        $hospital->password = Hash::make($validate->password);
        $hospital->state = $validate->state;
        $hospital->city = $validate->city;
        $hospital->email = $validate->email;
        $hospital->lat = $validate->lat;
        $hospital->role = 1;
        $hospital->activity = 1;
        $hospital->verified = 0;

        $data = event(new RegisterUsersHolderEvent($hospital, 'hospital'))[0]->original;

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = \App\Hospital::find($id);
            return ResponseMessage::Success('تم بنجاح', $data);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateForm $form, $id)
    {
        $validate = $form->validated();

        $hospital = \App\Hospital::find($id);

        foreach ($validate as $key => $value) {
            $hospital->$key = $value;
        }

        try {
            $hospital->save();
            return ResponseMessage::Success('تم تحديث البيانات بنجاح', $hospital);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            \App\Hospital::find($id)->delete();
            return ResponseMessage::Success('تم مسح البيانات بنجاح',);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }
}
