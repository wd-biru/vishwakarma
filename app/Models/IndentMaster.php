<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Brexis\LaravelWorkflow\Traits\WorkflowTrait;

class IndentMaster extends Model
{
	use WorkflowTrait;
    protected $table="vishwa_indent_masters";

    public function indentItems()
    {
        return $this->hasMany(IndentItem::class,'indent_id','indent_id');
    }

    public function indentStatus()
    {
        return $this->hasMany(IndentStatus::class,'indent_id','indent_id');
    }

    public function getCreatorDetails()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function getVendorsPrice()
    {
        return $this->hasMany(VishwaIndentVendorsPrice::class,'indent_id','indent_id');
    } 

    public function toCheckStage($workflow,$post)
    {
        $workFlowId=WorkFlowMaster::where('name',$workflow->getName())->first();
//        dd($workFlowId->id);
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
        $addStatus = new IndentStatus();
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
        $addStatus = IndentStatus::where('id','!=',$StatusMasterId)->where('indent_id',$indentDetail->indent_id)->update(['is_current_status'=> 0 ]);
        return true;
    }

    public function getPriceAginstEachVendor($pVendorId,$pIndentId,$pItemId,$InputUserPrice=null)
    {      
        $retRentVal = false;  $l1Total = $l2Total = null;$retNonRentVal = false;
        if(isset($pVendorId) && isset($pIndentId) && isset($pItemId)){



            $getIndentType=VishwaIndentVendorsPrice::where('indent_id',$pIndentId)->first();
            $getGroupTypeOne=VishwaRentablePrice::where('indent_map_id',$getIndentType->id)->first();
            $getGroupTypeTwo=VishwaNonRentablePrice::where('indent_map_id',$getIndentType->id)->first();



            if($getGroupTypeOne != null)
            {
                $getPrice = VishwaIndentVendorsPrice::join('vishwa_indent_vendor_rentable_price','vishwa_indent_vendor_price.id','vishwa_indent_vendor_rentable_price.indent_map_id')
                ->where('vendor_id',$pVendorId)->where('vishwa_indent_vendor_price.indent_id',$pIndentId)->where('vishwa_indent_vendor_rentable_price.item_id',$pItemId)->first();
                $AllQuoteDataForLowest = VishwaRentablePrice::where('indent_map_id',$getIndentType->id)->where('item_id',$pItemId)->groupBy('per_day_price')->orderBy('per_day_price','ASC')->get();

                if(count($AllQuoteDataForLowest)>0 ){
                    $l1Total = $AllQuoteDataForLowest[0]->per_day_price;
                    if(count($AllQuoteDataForLowest)>=2 ){
                        $l2Total = $AllQuoteDataForLowest[1]->per_day_price;
                    }
                }

                if($getPrice==null){

                    //dd( $l1Total,$l2Total,$AllQuoteDataForLowest);
                    $getPrice = ['lowest'=>'','LowColor'=>''];
                    if($l1Total != null && $InputUserPrice <= $l1Total){
                        $getPrice['lowest'] = "L1";
                        $getPrice['LowColor'] = "red";
                    }elseif($l2Total != null || $l2Total == null &&  ($l1Total > $InputUserPrice) <= $l2Total){
                        $getPrice['lowest'] = "L2";
                        $getPrice['LowColor'] = "green";
                    }elseif($l2Total != null &&  ($l2Total >=$InputUserPrice) <= $l1Total){
                        $getPrice['lowest'] = "L2";
                        $getPrice['LowColor'] = "green";
                    }
                    else{
                        $getPrice['lowest'] = "L1";
                        $getPrice['LowColor'] = "red";
                    }
                    if($InputUserPrice!=null){
                        $retRentVal = $getPrice;
                    }else{
                        $retRentVal = false;
                    }
                }
                else{
                    if($l1Total != null && $getPrice->per_day_price <= $l1Total){
                        $getPrice->lowest = "L1";
                        $getPrice->LowColor = "red";
                    }elseif($l2Total != null &&  $l2Total >= $l1Total) {
                        $getPrice['lowest'] = "L2";
                        $getPrice['LowColor'] = "green";
                    }elseif($l2Total != null && $getPrice->per_day_price == $l2Total){
                        $getPrice->lowest = "L2";
                        $getPrice->LowColor = "green";
                    }
                    else{
                        $getPrice->lowest = "";
                        $getPrice->LowColor = "fff";
                    }
                    $retRentVal = $getPrice;
                }


            }

           if($getGroupTypeTwo != null)
           {
               $getPrice = VishwaIndentVendorsPrice::join('vishwa_indent_vendor_non_rentable_price','vishwa_indent_vendor_price.id','vishwa_indent_vendor_non_rentable_price.indent_map_id')
                   ->where('vendor_id',$pVendorId)->where('vishwa_indent_vendor_price.indent_id',$pIndentId)->where('vishwa_indent_vendor_non_rentable_price.item_id',$pItemId)->first();
               $AllQuoteDataForLowest = VishwaNonRentablePrice::where('indent_map_id',$getIndentType->id)->where('item_id',$pItemId)->groupBy('price')->orderBy('price','ASC')->get();

               if(count($AllQuoteDataForLowest)>0 ){
                   $l1Total = $AllQuoteDataForLowest[0]->price;
                   if(count($AllQuoteDataForLowest)>=2 ){
                       $l2Total = $AllQuoteDataForLowest[1]->price;
                   }
               }

               if($getPrice==null){

                   //dd( $l1Total,$l2Total,$AllQuoteDataForLowest);
                   $getPrice = ['lowest'=>'','LowColor'=>''];
                   if($l1Total != null && $InputUserPrice <= $l1Total){
                       $getPrice['lowest'] = "L1";
                       $getPrice['LowColor'] = "red";
                   }elseif($l2Total != null || $l2Total == null &&  ($l1Total > $InputUserPrice) <= $l2Total){
                       $getPrice['lowest'] = "L2";
                       $getPrice['LowColor'] = "green";
                   }elseif($l2Total != null &&  ($l2Total >=$InputUserPrice) <= $l1Total){
                       $getPrice['lowest'] = "L2";
                       $getPrice['LowColor'] = "green";
                   }
                   else{
                       $getPrice['lowest'] = "L1";
                       $getPrice['LowColor'] = "red";
                   }
                   if($InputUserPrice!=null){
                       $retNonRentVal = $getPrice;
                   }else{
                       $retNonRentVal = false;
                   }
               }
               else{
                   if($l1Total != null && $getPrice->price <= $l1Total){
                       $getPrice->lowest = "L1";
                       $getPrice->LowColor = "red";
                   }elseif($l2Total != null &&  $l2Total >= $l1Total) {
                       $getPrice['lowest'] = "L2";
                       $getPrice['LowColor'] = "green";
                   }elseif($l2Total != null && $getPrice->price == $l2Total){
                       $getPrice->lowest = "L2";
                       $getPrice->LowColor = "green";
                   }
                   else{
                       $getPrice->lowest = "";
                       $getPrice->LowColor = "fff";
                   }
                   $retNonRentVal = $getPrice;
               }

           }


        }

        if($getGroupTypeTwo != null)
        {
            return $retNonRentVal;
        }
        else
        {
            return $retRentVal;
        }



    }
}