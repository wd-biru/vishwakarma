<?php

namespace App\Models;

use Brexis\LaravelWorkflow\Traits\WorkflowTrait;
use Illuminate\Database\Eloquent\Model;
use App\User as UserDetails;

class VishwaPurchaseOrder extends Model
{
    use WorkflowTrait;
    protected $table="vishwa_purchase_order";

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

    public function purchaseStatus()
    {
        return $this->hasMany(VishwaPurchaseStatus::class,'indent_id','indent_id');
    }

    public function toCheckStage($workflow,$post)
    {
        $workFlowId=WorkFlowMaster::where('name',$workflow->getName())->first();
        foreach (WorkflowTransitions::where('workflow_id',$workFlowId->id)->get() as $key => $value) {
            if($workflow->can($post, $value->trans_name)){
                return $value->trans_name;
            }
        }
    }

    public function toChangeStage($workflow,$post)
    {
        $workFlowId=WorkFlowMaster::where('name',$workflow->getName())->first();


        foreach (WorkflowTransitions::where('workflow_id',$workFlowId->id)->get() as $key => $value) {
            if($workflow->can($post, $value->trans_name)){
                $transitions = $workflow->getEnabledTransitions($post);
                $workflow->apply($post, $value->trans_name);
                return $post->save();
            }
        }
    }

    public function insertStatus($indentDetail , $remark = "Indent Created",$status)
    {
        $addStatus = new VishwaPurchaseStatus();
        $addStatus->indent_id = $indentDetail->indent_id;
        $addStatus->status = $status;
        $addStatus->remark = $remark ;
        $addStatus->changed_by = Auth::user()->id;
        $addStatus->changed_date = date('Y-m-d');
        $addStatus->is_current_status = 1;
        $check = ($addStatus->save()) ? $this->updatePreviousStatus($indentDetail,$addStatus->id) : false ;
        return $check;
    }

    function updatePreviousStatus($indentDetail,$StatusMasterId=null)
    {
        $addStatus = VishwaPurchaseStatus::where('id','!=',$StatusMasterId)->where('indent_id',$indentDetail->indent_id)->update(['is_current_status'=> 0 ]);
        return true;
    }


}