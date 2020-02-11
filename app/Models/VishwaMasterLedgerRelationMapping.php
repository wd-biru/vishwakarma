<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class VishwaMasterLedgerRelationMapping extends Model
{
	use SoftDeletes;
	public  $timestamps = false;
    protected $dates = ['deleted_at'];
	protected $table = "vishwa_master_ledger_relationship_mapping";

}
