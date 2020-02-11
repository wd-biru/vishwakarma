<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VishwaVendorProjectContractPrice extends Model
{
    protected $table="vishwa_vendor_project_contract_prices";

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
