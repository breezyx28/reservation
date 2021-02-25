<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class VerificationController extends Controller
{
    private $code, $phone;
    protected const api_key = 'bWVkb255N2JlQGdtYWlsLmNvbTp1MXFhcGJAJkFz';

    private $msg = null;

    private function cleanPhone($phone)
    {
        $error = false;

        if (!strlen($phone) == 10) {
            $error = true;
        }
        if ($phone[0] == '0') {
            $phone = substr_replace($phone, "249", 0, 1);
        }
        if (!is_numeric($phone)) {
            $error = true;
        }
        if (!$error) {
            return $phone;
        } else {
            return $error;
        }
    }

    public function sendCode($ver, $phone, $userHolder)
    {
        $this->phone = $this->cleanPhone($phone);
        $this->code = rand(10000, 999);

        $http = Http::get('https://mazinhost.com/smsv1/sms/api', [
            'action' => 'send-sms',
            'api_key' => self::api_key,
            'to' => $this->phone,
            'from' => 'Dawakom',
            'sms' => "رمز تأكيد الحساب $this->code",
        ]);

        $resp =  $http->json();


        if (isset($resp['balance']) && $resp['balance'] < 1) {

            return false;

            // return $this->msg->message(false, null, 'الرجاء التواصل مع إدارة النظام', null, 500);
        }

        if ($resp['code'] != "ok") {
            return false;

            // return $this->msg->message(false, null, 'خطأ في عملية ارسال رمز التأكيد', null, 403);
        }

        $set = $ver::where('usersHolderID', $userHolder->id)->firstOr(function () {
            return false;
        });

        if (!$set) {
            $ver->usersHolderID = $userHolder->id;
            $ver->statue = 0;
            $ver->code = $this->code;
        }

        if (!$ver->save()) {
            return false;

            // return $this->msg->message(false, null, 'لا يمكن حفظ بيانات تأكيد الحساب', null, 500);
        }

        // return $this->msg->message(true, 'تم إرسال رمز التأكيد إلى ' . $phone, null, null, 200);
        return true;
    }
}
