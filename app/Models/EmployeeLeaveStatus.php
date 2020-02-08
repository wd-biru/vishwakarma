<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveStatus extends Model
{
    protected $table='vishwa_employee_leave_status';

    
    public function getLeaveType()
	{
		return $this->hasOne(LeaveMaster::class,'id','leave_id');
	}

	public function getLeaveStatusMaster()
	{
		return $this->hasOne(LeavesStatusMaster::class,'id','status');
	}
	
	public function getEmployee()
	{
		return $this->hasOne(EmployeeProfile::class,'id','employee_id');
	}
	
		public function getReportingEmp()
	{
		return  $this->hasOne(EmployeeProfile::class,'id','employee_id');
	}
}
