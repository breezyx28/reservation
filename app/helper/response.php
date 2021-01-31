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

    public static function Error(string $error, mixed $data, int $code = 200)
    {

        return response()->json([
            'success' => false,
            'message' => null,
            'error' => $error,
            'data' => $data
        ], $code);
    }

    public static function Success(string $message, mixed $data, int $code = 200)
    {

        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => null,
            'data' => $data
        ], $code);
    }
}
