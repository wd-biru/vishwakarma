<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class MaterialRequestFlow extends Model
{
    protected $table="vishwa_material_request_flow";
    public $timestamps=false;

    public function scopeMReqFilterData($query,$portal_id,$project_id)
    {
        return $query->where('vishwa_material_request_flow.portal_id', $portal_id)
            ->where('vishwa_material_request_flow.project_id', $project_id)
            ->join('vishwa_project_tower','vishwa_material_request_flow.tower_id','vishwa_project_tower.id')
            ->orderBy('vishwa_material_request_flow.created_date', 'DESC');
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

    public function insertStatus($mreqNo , $remark = "Request Created",$status)
    {
        $addStatus = new MaterialRequestStatus();
        $addStatus->mreq_no = $mreqNo->mreq_no;
        $addStatus->status = $status;
        $addStatus->remark = $remark ;
        $addStatus->changed_by = Auth::user()->id;
        $addStatus->changed_date = date('Y-m-d');
        $addStatus->is_current_status = 1;
        $check = ($addStatus->save()) ? $this->updatePreviousStatus($mreqNo,$addStatus->id) : false ;
        return $check;
    }

    function updatePreviousStatus($mreqNo,$StatusMasterId=null)
    {
        $addStatus = MaterialRequestStatus::where('id','!=',$StatusMasterId)->where('mreq_no',$mreqNo->mreq_no)->update(['is_current_status'=> 0 ]);
        return true;
    }


}
