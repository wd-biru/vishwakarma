<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
   protected $table='vishwa_docs_details';

   public function getApproval()
   {
   	  return $this->belongsTo('App\Models\EmployeeProfile','for_approval','id');
   }
   
}
