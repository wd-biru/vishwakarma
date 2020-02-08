<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User as UserDetails;

class VishwaProjectTower extends Model
{
    //
    protected $table="vishwa_project_tower";
    public $timestamps = false;

    function getTowerename($tower_ids)
    { 
        return EmployeeProfile::whereIn('id',$tower_ids)->get();
    }

     
}