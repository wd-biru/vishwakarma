<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeTimeSheet extends Model
{
    protected $table = 'vishwa_employee_time_sheet';

    function getClientName()
    {
        return $this->belongsTo(Client::class,'client_id','id');
    }
    function getEmployeeName()
    {
        return $this->belongsTo(EmployeeProfile::class,'employee_id','id');
    }
}
