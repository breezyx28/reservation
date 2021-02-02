<?php

namespace App\Http\Controllers;

use App\Events\RegisterUsersHolderEvent;
use App\Helper\ResponseMessage;
use App\Hospital;
use App\User;
use App\Lab;
use App\Helper\Signature;
use App\Http\Controllers\Controller;
use App\Http\Requests\HospitalRequest;
use App\Http\Requests\LabRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUserController extends Controller
{
    public function createLab(LabRequest $request)
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

    public function createHospital(HospitalRequest $request)
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
}
