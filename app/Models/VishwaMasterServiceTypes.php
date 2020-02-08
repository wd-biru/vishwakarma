<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VishwaMasterServiceTypes extends Model
{
	protected $table = "vishwa_master_service_item";

	public function serviceItem()
	{
		return $this->belongsTo(VishwaMasterServiceGroup::class);
	}
}
