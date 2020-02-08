<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class VishwaVendorPortalMapping extends Model
{
    protected $table="vishwa_portal_vendor_mapping";

    function getCompany()
    {
        return $this->belongsToMany(Portal::class,'company_name','id');
    }

    


}