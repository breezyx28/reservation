<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {

        $data = [
            'name' => 'Mohamed Ahmed'
        ];

        return response()->json($data, 200);
    }
}
