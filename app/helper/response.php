<?php

namespace App\Helper;

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

    public static function Error(string $error, $data, int $code = 200)
    {

        return response()->json([
            'success' => false,
            'message' => null,
            'error' => $error,
            'data' => $data
        ], $code);
    }

    public static function Success(string $message, $data, int $code = 200)
    {

        return response()->json([
            'success' => true,
            'message' => $message,
            'error' => null,
            'data' => $data
        ], $code);
    }
}
