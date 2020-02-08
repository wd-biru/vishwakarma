<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveMaster extends Model
{
    protected $table='vishwa_leave_type_master';

    public function getportalName()
	{
		return  $this->hasOne(Portal::class,'id','portal_id');
	}

	
}

