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

    public function checkQty($vendorId,$purOrderId,$itemId,$orderQty)
    {
        $result=['orderQty'=>null,'remainQty'=>null , 'challanQty'=>null];
        $qtyChalan = VishwaChallan::where('vendor_id',$vendorId)->where("purchase_order_no",trim($purOrderId))->where('item_id',$itemId)->get()->sum('qty');


        $result['orderQty']=$orderQty;
        if($qtyChalan==0){
            $result['remainQty']=$orderQty;
        }else{
            $result['remainQty']=$orderQty-$qtyChalan;
            $result['challanQty']=$qtyChalan;
        }
        return $result;
    }
}