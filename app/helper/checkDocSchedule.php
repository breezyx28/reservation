<?php

namespace App\Helper;

class DocAvilable
{

    public static function checkDate($id, $dateParam)
    {
        $check = strtotime($dateParam) > strtotime(date(now())) ? true : false;

        if (!$check) {
            return false;
        }

        $reservDate = strtotime($dateParam);
        $reservDay =  strtolower(date('l', $reservDate));

        $checkDay = \App\HospitalInfo::where('id', '=', $id)->with('docSchedule')->get();

        $data = $checkDay[0]->docSchedule;

        if (!$data->$reservDay || $data->off == 1) {
            return false;
        }

        return true;
    }
}
