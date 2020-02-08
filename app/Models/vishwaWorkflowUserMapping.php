<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class vishwaWorkflowUserMapping extends Model
{
    protected $table="vishwa_workflow_user_mapping";

    public $timestamps = false;


    public function getWorkFlowTransaction()
    {
    	return $this->belongsTo(WorkflowTransitions::class,'Workflow_place_id','id') ;
    }


}
