<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VishwaMasterBillingCycle extends Model
{
    protected $table="vishwa_master_billing_cycle";
    public $timestamps=false;
    use softDeletes;
    protected $dates=['deleted_at'];

}
