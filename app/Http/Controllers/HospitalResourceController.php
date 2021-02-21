<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage;
use Illuminate\Http\Request;
use App\Http\Requests\HospitalRequest;
use App\Http\Requests\updateUser as UpdateForm;
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

            $data = \App\Hospital::all()->chunk(100)->toArray();
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
        $validated = (object) $request->validated();

        $hospital = new \App\Hospital();

        foreach ($validated as $key => $value) {
            $hospital->$key = $value;
        }

        try {
            $hospital->save();
            return ResponseMessage::Success('تم بنجاح');
        } catch (\Exception $e) {
            return ResponseMessage::Error('حدث خطأ ما', $e->getMessage());
        }
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
