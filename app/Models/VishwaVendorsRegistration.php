<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User as UserDetails;


class VishwaVendorsRegistration extends Model
{
    protected $table="vishwa_vendor_master";

    function getUser()
    {
        return $this->belongsTo(UserDetails::class,'user_id','id');
    }

    function getState()
    {
        return $this->belongsTo(States::class,'state','id');
    }

    function getCity()
    {
        return $this->belongsTo(Cities::class,'city','id');
    }

    function getMaterial($mat_ids)
    { 
        return MasterMaterialsGroup::whereIn('id',$mat_ids)->get();
    }

    function getPortalMap()
    {
        return $this->hasMany(VishwaVendorPortalMapping::class,'vendor_id','id');
    }

}
