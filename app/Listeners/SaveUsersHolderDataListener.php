<?php

namespace App\Listeners;

use App\User;
use App\Helper\Signature;
use App\Helper\ResponseMessage;
use App\Verify;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\VerificationController as Verification;

class SaveUsersHolderDataListener
{

    public function handle($event)
    {
        $usersHolder = new User();
        $verify = new Verify();

        // user holder table
        $usersHolder->userSignature = Signature::generate($event->user->phone, $event->table);
        $usersHolder->userPhoneNumber = $event->user->phone;
        $usersHolder->password = $event->user->password;
        $usersHolder->accountType = $event->table;

        DB::beginTransaction();
        try {
            //code...
            $event->user->save();
            $usersHolder->userID = $event->user->id;
            $usersHolder->save();

            // send verification code
            $ver = new Verification();
            $ver->sendCode($verify, $event->user->phone, $usersHolder);

            // commit if OK
            DB::commit();

            return ResponseMessage::Success('تم بنجاح', null);
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseMessage::Error('error', $e->getMessage());
        }
    }
}
