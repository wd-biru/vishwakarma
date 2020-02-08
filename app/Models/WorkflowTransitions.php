<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkflowTransitions extends Model
{
    protected $table = "work_flow_transitions";
    public $timestamps = false;
    public function getPlaceFrom(){
        return $this->belongsTo( WorkflowPlace::class,'place_from_id','id');    	
    }

    public function getPlaceTo(){
        return $this->belongsTo( WorkflowPlace::class,'place_to_id','id');    	
    }
}
