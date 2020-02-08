<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VishwaServiceRegistration extends Model
{

protected $table="vishwa_service_registration";

    public function regDocs()
    {
      return $this->hasMany(VishwaServiceRegistrationDocs::class,'service_reg_id','id');
    }


    public function regProject()
    {
        return $this->hasMany(VishwaServiceRegistrationProjects::class,'service_reg_id','id');
    }
}
