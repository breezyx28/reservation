<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\DoctorInfo;
use App\HospitalInfo;
use App\LabDiagnosis;
use App\Hospital;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchDoc(Request $request)
    {
        $validated = (object) $request->validate([
            'search' => 'required|string'
        ]);

        $searchString = $validated->search;

        $search = HospitalInfo::whereHas('doctor', function ($query) use ($searchString) {
            // $query->where('fullName', 'like', '%' . $searchString . '%')->where('activity', '=', '1');
            $query->where('fullName', $searchString)->where('activity', '=', '1');
        })->with(['doctor' => function ($query) use ($searchString) {
            // $query->where('fullName', 'like', '%' . $searchString . '%')->where('activity', '=', '1');
            $query->where('fullName', $searchString)->where('activity', '=', '1');
        }, 'docInfo', 'hospital.hospitalServices.services', 'docSchedule'])
            ->orWhereHas('docInfo', function ($query) use ($searchString) {
                $query->where('specialization', $searchString);
            })->with('doctor')
            ->get();

        return response()->json([
            'success' => true,
            'message' => null,
            'error' => null,
            'data' => $search,
        ], 200);
    }

    public function searchLab(Request $request)
    {

        $validated = (object) $request->validate([
            'search' => 'required|string'
        ]);

        $searchString = $validated->search;

        $search = LabDiagnosis::where('name', $searchString)->with(['lab' => function ($query) {
            // $search = LabDiagnosis::where('name', 'like', '%' . $searchString . '%')->with(['lab' => function ($query) {
            $query->select('id', 'name', 'phone', 'state', 'city', 'address', 'email', 'lat', 'lng');
        }, 'labServices' => function ($query) {
            $query->select('labID', 'name', 'price', 'note')->where('activity', '1');
        }])->get();

        return response()->json([
            'success' => true,
            'message' => null,
            'error' => null,
            'data' => $search,
        ], 200);
    }
}
