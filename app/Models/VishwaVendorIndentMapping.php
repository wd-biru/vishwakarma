<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\User as UserDetails;


class VishwaVendorIndentMapping extends Model
{
    protected $table="vishwa_vendor_indent_mapping";

    function getVendor($vendor_ids)
    { 
        return VishwaVendorsRegistration::whereIn('id',$vendor_ids)->get();
    }

    function getVendorIndent()
    { 
        return  $this->belongsTo(IndentMaster::class,'indent_id','indent_id');
    }


  
}