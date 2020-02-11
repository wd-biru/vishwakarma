<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentMaster extends Model
{
    protected $table = 'vishwa_department_master';
    use SoftDeletes;
    protected $dates = ['deleted_at'];


  	function getDesignations()
  	{
        return $this->hasMany(DesignationMaster::class,'department_id','id');
   	}

    public function getEmployee()
    {
        return $this->hasMany(EmployeeProfile::class,'department_id','id');
    }
}
