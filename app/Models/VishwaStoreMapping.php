<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User as UserDetails;

class VishwaStoreMapping extends Model
{
    //
    protected $table="vishwa_store_employee_mapping";

    public function getStoreDetail()
    {
        return $this->belongsTo(VishwaProjectStore::class,'store_id','id');
    }
   
   	public function getEmpDetails()
    {
        return $this->belongsTo(EmployeeProfile::class,'store_keeper_id');
    } 


}

