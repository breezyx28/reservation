<?php

namespace App\Helper;

use App\User;

class Signature
{
    public static $i = 0;

    public static function generate($phoneNumber, $table)
    {
        if (self::$i < 3) {

            $user = new User();

            // generate signature
            $signature = substr(uniqid(md5($phoneNumber . $table)), 0, 10);

            // check for the signature in database
            $result = $user::where('userSignature', '=', $signature)->firstOr(function () {
                return false;
            });

            /* test the signature
            if true return the $signature
            if false loop the function again untill
             complete 3 time
            */
            if ($result == false) {
                return $signature;
            } else {
                // increase i by 1
                self::$i + 1;

                // recursive funtion
                self::generate($phoneNumber, $table);
            }
        } else {

            return response()->json([
                'success' => false,
                'message' => null,
                'error' => 'حدث خطأ ما في إنشاء التوقيع الخاص',
                'data' => null
            ], 200);
        }
    }
}
