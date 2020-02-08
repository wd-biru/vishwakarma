<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Client extends Model
{
    protected  $table ="vishwa_client_info";

    public function getRegisterNo()
    {
        return $this->hasOne(ClientSecInfo::class,'id','Client_id');
    }



    public function getServices()
    {
        return $this->hasMany(ClientSelectService::class,'client_id','id');
    }

    public function getPreServices()
    {
        return $this->hasMany(PreprationService::class,'client_id','id');
    }

    public function getProject()
    {
        return $this->hasMany(DB::table('projects'),'customer_id','id');
    }

    public function isClientServiceExist($pClientId,$pServiceId,$pServices)
    {
    	$retVal = false;

    	if(isset($pClientId) && isset($pServiceId)){
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

    public function isClientServiceAttributeExist($pClientId,$pAttributeId,$pServiceId,$pServices,$pYear,$pMonth)
    {
        $retVal = false;

        if(isset($pClientId) && isset($pAttributeId) && isset($pServiceId) && isset($pYear) && isset($pMonth) ){
            if(isset($pServices) && count($pServices)>0){
                foreach($pServices as $service){
                    if($service->client_id == $pClientId and $service->attribute_id == $pAttributeId and $service->service_id == $pServiceId and $service->status == 1 and $service->year == $pYear and $service->month == $pMonth){
                        $retVal = true;
                        break;
                    }
                }
            }

        }

        return $retVal;
    }
}
