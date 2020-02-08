<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceMaster extends Model
{
    protected $table="vishwa_master_services";

    public function getAttributesss()
    {
    	return $this->hasMany(ServiceAttributeMaster::class,'service_id','id');
    }
}
