<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\DoctorInfo;
use App\HospitalInfo;
use App\Hospital;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {

        $validated = (object) $request->validate([
            'search' => 'required|string'
        ]);

        $searchString = $validated->search;
        // 'docInfo', 'hospital'
        // $search = HospitalInfo::with(['doctor' => function ($query) use ($searchString) {
        //     $query->where('fullName', 'like', '%' . $searchString . '%');
        // }])
        //     ->get();

        $search = HospitalInfo::whereHas('doctor', function ($query) use ($searchString) {
            $query->where('fullName', 'like', '%' . $searchString . '%');
        })->with(['doctor' => function ($query) use ($searchString) {
            $query->where('fullName', 'like', '%' . $searchString . '%');
        }, 'docInfo'])->orWhereHas('docInfo', function ($query) use ($searchString) {
            $query->where('specialization', 'like', '%' . $searchString . '%');
        })->with('doctor')->get();

        // $search = HospitalInfo::with('docInfo')
        //     ->get();

        return response()->json([
            'success' => true,
            'message' => null,
            'error' => null,
            'data' => $search,
        ], 200);
    }
}
