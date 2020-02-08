<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portal extends Model
{
    protected $table = 'vishwa_portals';

    public function getCompany()
    {
    
    	return $this->hasMany(Client::class,'portal_id','id');
    }
    public function getEmployee()
    {
    
        return $this->hasMany(EmployeeProfile::class,'portal_id','id');
    }
    public function getUser()
    {
    
        return $this->belongsTo('App\User','user_id','id');
    }

    public function getPortalServices()
    {
        return $this->hasMany(PortalSelectService::class,'portal_id','id');
    }

    public function isPortalServiceExist($pPortalId,$pServiceId,$pServices)
    {
    	$retVal = false;

    	if(isset($pPortalId) && isset($pServiceId)){
    		if(isset($pServices) && count($pServices)>0){
    			foreach($pServices as $service){
		    		if($service->service_id == $pServiceId){
			    		$retVal = true;
			    		break;
		    		}
		    	}
	    	}
    	}
    	return $retVal;
    }

}
