<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentMaster extends Model
{
    protected $table = 'vishwa_department_master';


  	function getDesignations()
  	{
        return $this->hasMany(DesignationMaster::class,'department_id','id');
   	}

    public function getEmployee()
    {
        return $this->hasMany(EmployeeProfile::class,'department_id','id');
    }
}
