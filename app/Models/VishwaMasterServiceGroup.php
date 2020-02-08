<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VishwaMasterServiceGroup extends Model
{
	protected $table = "vishwa_master_service_groups";  

    public function getServiceType()
  {
    return $this->hasMany(VishwaMasterServiceTypes::class,'master_id','id');
  }
}
