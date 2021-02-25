<?php

namespace App\Http\Controllers;

use App\Lab;
use App\Events\RegisterUsersHolderEvent;
use App\Helper\ResponseMessage;
use App\Http\Requests\LabRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\updateUser as UpdateForm;


class LabResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $data = \App\Lab::all();
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
    public function create(LabRequest $request)
    {
        $validate = (object) $request->validated();

        $lab = new Lab();

        $lab->name = $validate->name;
        $lab->phone = $validate->phone;
        $lab->password = Hash::make($validate->password);
        $lab->state = $validate->state;
        $lab->city = $validate->city;
        $lab->email = $validate->email;
        $lab->lat = $validate->lat;
        $lab->role = 1;
        $lab->activity = 1;
        $lab->verified = 0;

        $data = event(new RegisterUsersHolderEvent($lab, 'lab'))[0]->original;

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
            $data = \App\Lab::find($id);
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

        $lab = \App\Lab::find($id);

        foreach ($validate as $key => $value) {
            $lab->$key = $value;
        }
        try {
            $lab->save();
            return ResponseMessage::Success('تم تحديث البيانات بنجاح', $lab);
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
            \App\Lab::find($id)->delete();
            return ResponseMessage::Success('تم مسح البيانات بنجاح',);
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
    }
}
