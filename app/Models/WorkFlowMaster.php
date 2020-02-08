<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkFlowMaster extends Model
{
    protected $table = "work_flow_masters";
    public $timestamps = false;

    public function getPlace(){
    	return $this->hasMany(WorkflowPlace::class,'workflow_id','id');
    }

    public function getTransaction(){
    	return $this->hasMany(WorkflowTransitions::class,'workflow_id','id');
    }
}
