<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function Login(Request $request)
    {

        $credintials = [
            'userPhoneNumber' => $request->phoneNumber,
            'password' => $request->password,
        ];

        $token = null;

        if (!$token = JWTAuth::attempt($credintials)) {
            return ResponseMessage::Error('خطأ في كلمة السر او رقم الهاتف');
        }

        $user = auth()->user();
        $userAccount = auth()->user()->accountType;
        $usersHolder = new \App\UsersHolder();

        $data = $userAccount == 'users' ?? $usersHolder->where('userID', $user->userID)->get();

        return response()->json([
            'success' => true,
            'message' => 'تم بنجاح',
            'data' => $data[0],
            'token' => $token,
        ], 200);
    }

    // logout process
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return $this->msg->message(true, 'تم تسجسل الخروج بنجاح', null, null, 200);
        } catch (JWTException $exception) {
            return $this->msg->message(false, null, 'لا يمكن إجراء عملية تسجيل الخروج الآن ...', null, 200);
        }
    }

    protected function createNewToken($token)
    {

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 3600,
            'user' => auth()->user()
        ]);
    }
}
