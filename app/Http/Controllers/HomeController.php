<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class HomeController extends Controller
{
    public function home(Request $request)
    {

        // JWTAuth::setToken($request->input('token'));
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $data = [
            'token' => $user,
            'name' => 'Mohamed Ahmed'
        ];

        return response()->json($data, 200);
    }
}
