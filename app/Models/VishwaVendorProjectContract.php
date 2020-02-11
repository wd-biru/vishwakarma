<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VishwaVendorProjectContract extends Model
{
    protected $table="vishwa_vendor_project_contracts";
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
