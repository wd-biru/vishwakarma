<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
class EmployeeProfile extends Model
{
    protected $table="vishwa_employee_profile";
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $appends = ['complete_name'];
    public function getCompleteNameAttribute()
    {
        return $this->attributes['first_name'].
            ' ' . $this->attributes['last_name'];
    }

    public function getUserDetails()
    {

    	return $this->belongsTo('App\User','user_id','id');
    }

    public function getDepartment()
    {
      	return $this->hasMany(DepartmentMaster::Class,'department_id','id');
    }

    public function getDesignation()
    {
      return $this->belongsTo(DesignationMaster::Class,'designation_id','id');
    }

    public function getUserPortal()
    {
        return $this->belongsTo('App\Models\Portal','portal_id','id');
    }

    public function getWorkFlowUserStage()
    {
        if(Auth::user()->user_type=="employee"){
            return $this->hasMany(vishwaWorkflowUserMapping::class,'emp_id','id') ;
        } 
    }

    public function getUserStage($currentStage)
    { 
        $userStage="";

        if(Auth::user()->getEmp->getWorkFlowUserStage!=null && Auth::user()->getEmp->getWorkFlowUserStage->count()>0){
            foreach(Auth::user()->getEmp->getWorkFlowUserStage as $value) {
//dd($currentStage,$value->getWorkFlowTransaction->trans_name);
                if($currentStage!=null &&  ($currentStage == $value->getWorkFlowTransaction->trans_name)){
                    $userStage = $value->getWorkFlowTransaction->trans_name;  
                    break;
                }
                else{

                    if('To_create' == $value->getWorkFlowTransaction->trans_name){
                        $userStage = $value->getWorkFlowTransaction->trans_name; 
                    }
                }
            }
        }


        return $userStage;
    }
}
