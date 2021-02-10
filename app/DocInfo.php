<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocInfo extends Model
{
    protected $table = 'doc_info';

    public function doctor()
    {
        return $this->belongsTo('App\Doctor', 'docID');
    }

    public function hospitalInfo()
    {
        return $this->belongsToMany('App\HospitalInfo', 'hospitalInfoID');
    }
}
