<?php

namespace App\Helper;

use Illuminate\Support\Facades\Log;

class ResponseMessage
{
    public static function Msg($success = true, $message = null, $error = null, $data = null, $code = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'error' => $error,
            'data' => $data,
        ], $code);
    }

    public static function Error(string $error, $data = null, int $code = 200)
    {
        Log::info('Issue :', ['problem' => $data]);

        return response()->json([
            'success' => false,
            'message' => null,
            'error' => $error,
            'data' => null
        ], $code);
    }

    public static function Success(string $message, $data = null, int $code = 200)
    {

        return response()->json([
            'success' => true,
            'message' => $message,
            'error' => null,
            'data' => $data
        ], $code);
    }
}
