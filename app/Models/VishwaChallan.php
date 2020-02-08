<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User as UserDetails;

class VishwaChallan extends Model
{
    //
    protected $table="vishwa_vendor_challan";

    public function getChalanDetail($vendorId,$purOrderId,$itemId,$challanNO)
    { 
    	$qtyChalan = VishwaChallan::where('challan_no',$challanNO)->where('vendor_id',$vendorId)->where("purchase_order_no",trim($purOrderId))->where('item_id',$itemId)->first();

    	return $qtyChalan;  
    }  
}