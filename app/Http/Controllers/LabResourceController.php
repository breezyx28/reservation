<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage;
use App\Http\Requests\LabRequest;
use Illuminate\Http\Request;
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

            $data = \App\Lab::all()->chunk(100)->toArray();
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
        $validated = (object) $request->validated();

        $lab = new \App\Lab();

        foreach ($validated as $key => $value) {
            $lab->$key = $value;
        }

        try {
            $lab->save();
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
