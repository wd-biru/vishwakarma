<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model
{
    protected $table="vishwa_time_sheets";

    function getTypeName()
    {
       return $this->belongsTo(ServiceMaster::class,'task_type','id');
    }
    function getClientName()
    {
        return $this->belongsTo(Client::class,'client_id','id');
    }
    function getUserName()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
