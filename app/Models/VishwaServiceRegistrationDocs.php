<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VishwaServiceRegistrationDocs extends Model
{


  public function serviceReg()
  {
    return $this->belongsTo(VishwaServiceRegistration::class);
  }
}
