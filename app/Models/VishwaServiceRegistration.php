<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VishwaServiceRegistration extends Model
{

protected $table="vishwa_service_registration";
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function regDocs()
    {
      return $this->hasMany(VishwaServiceRegistrationDocs::class,'service_reg_id','id');
    }


    public function regProject()
    {
        return $this->hasMany(VishwaServiceRegistrationProjects::class,'service_reg_id','id');
    }
}
