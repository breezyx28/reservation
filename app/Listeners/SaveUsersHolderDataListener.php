<?php

namespace App\Listeners;


use App\User;
use App\Helper\Signature;
use App\Helper\ResponseMessage;
use Illuminate\Support\Facades\DB;

class SaveUsersHolderDataListener
{

    public function handle($event)
    {
        $usersHolder = new User();

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
            DB::commit();

            return ResponseMessage::Success('تم بنجاح', null);
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseMessage::Error('error', $e->getMessage());
        }
    }
}
