<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\VishwaVendorsRegistration;

use App\User as UserDetails;


class VishwaVendorsPrice extends Model
{
    protected $table="vishwa_vendor_price";

    public function getVendor()
    {
        return $this->hasOne(VishwaVendorsRegistration::class,'vendor_id','id');
    }

}
