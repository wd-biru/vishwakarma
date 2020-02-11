<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VishwaMasterServiceGroup extends Model
{
	protected $table = "vishwa_master_service_groups";
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getServiceType()
  {
    return $this->hasMany(VishwaMasterServiceTypes::class,'master_id','id');
  }
}
