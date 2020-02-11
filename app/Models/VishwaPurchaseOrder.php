<?php

namespace App\Models;

use Brexis\LaravelWorkflow\Traits\WorkflowTrait;
use Illuminate\Database\Eloquent\Model;
use App\User as UserDetails;

class VishwaPurchaseOrder extends Model
{
    use WorkflowTrait;
    protected $table = "vishwa_purchase_order";

    public function checkQty($vendorId, $purOrderId, $itemId, $orderQty)
    {
        $result = ['orderQty' => null, 'remainQty' => null, 'challanQty' => null];
        $qtyChalan = VishwaChallan::join('vishwa_vendor_challan_item','vishwa_vendor_challan.id','vishwa_vendor_challan_item.challan_map_id')
        ->where('vendor_id', $vendorId)->where("purchase_order_no", trim($purOrderId))->where('vishwa_vendor_challan_item.item_id', $itemId)->get()->sum('qty');
        $result['orderQty'] = $orderQty;
        if ($qtyChalan == 0) {
            $result['remainQty'] = $orderQty;
        } else {
            $result['remainQty'] = $orderQty - $qtyChalan;
            $result['challanQty'] = $qtyChalan;
        }
        return $result;
    }

    public function purchaseStatus()
    {
        return $this->hasMany(VishwaPurchaseStatus::class, 'indent_id', 'indent_id');
    }

    public function toCheckStage($workflow, $post)
    {
        $workFlowId = WorkFlowMaster::where('name', $workflow->getName())->first();
        foreach (WorkflowTransitions::where('workflow_id', $workFlowId->id)->get() as $key => $value) {


            if ($workflow->can($post, $value->trans_name)) {

                return $value->trans_name;
            }
        }
    }

    public function toChangeStage($workflow, $post)
    {
        $workFlowId = WorkFlowMaster::where('name', $workflow->getName())->first();

        foreach (WorkflowTransitions::where('workflow_id', $workFlowId->id)->get() as $key => $value) {

            if ($workflow->can($post, $value->trans_name)) {
                $transitions = $workflow->getEnabledTransitions($post);

                $workflow->apply($post, $value->trans_name);
                return $post->save();
            }
        }
    }

    public function insertStatus($indentDetail, $remark = "Indent Created", $status)
    {
        $addStatus = new VishwaPurchaseStatus();
        $addStatus->indent_id = $indentDetail->indent_id;
        $addStatus->status = $status;
        $addStatus->remark = $remark;
        $addStatus->changed_by = Auth::user()->id;
        $addStatus->changed_date = date('Y-m-d');
        $addStatus->is_current_status = 1;
        $check = ($addStatus->save()) ? $this->updatePreviousStatus($indentDetail, $addStatus->id) : false;
        return $check;
    }

    function updatePreviousStatus($indentDetail, $StatusMasterId = null)
    {
        $addStatus = VishwaPurchaseStatus::where('id', '!=', $StatusMasterId)->where('indent_id', $indentDetail->indent_id)->update(['is_current_status' => 0]);
        return true;
    }


    public function scopeChallanData($query, $date, $vendor_id)
    {
//        $getIndentType=VishwaIndentVendorsPrice::where('indent_id',$pIndentId)->first();
//        $getGroupTypeOne=VishwaRentablePrice::where('indent_map_id',$getIndentType->id)->first();
//        $getGroupTypeTwo=VishwaNonRentablePrice::where('indent_map_id',$getIndentType->id)->first();

        return $query->join('vishwa_vendor_challan', 'vishwa_purchase_order.indent_id', 'vishwa_vendor_challan.indent_id')
            ->join('vishwa_vendor_master', 'vishwa_vendor_challan.vendor_id', 'vishwa_vendor_master.id')
            ->whereDate('vishwa_vendor_challan.date', '>=', $date)
            ->where('vishwa_vendor_challan.vendor_id', '=', $vendor_id)
            ->orderBy('purchase_indent_id', 'desc')
            ->groupBy('vishwa_vendor_challan.challan_no')
            ->select('vishwa_vendor_challan.*', 'vishwa_vendor_master.company_name', 'vishwa_vendor_challan.indent_id as purchase_indent_id');
    }

    public function scopeFilterPurchaseData($query, $toDate, $fromDate)
    {
        return $query->join('vishwa_indent_vendor_price', 'vishwa_purchase_order.indent_id', 'vishwa_indent_vendor_price.indent_id')
            ->join('vishwa_vendor_master', 'vishwa_purchase_order.vendor_id', 'vishwa_vendor_master.id')
            ->whereDate('vishwa_purchase_order.date', '>=', $fromDate)
            ->whereDate('vishwa_purchase_order.date', '<=', $toDate)
            ->orderBy('vishwa_purchase_order.indent_id', 'desc');

    }

    public function toArray()
    {
        $attributes = $this->attributesToArray();
        return array_merge($attributes, $this->relationsToArray());
    }


    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }


}