<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentShare extends Model
{
    protected $table='vishwa_doc_share_details';
    public function getName()
   {
   	  return $this->belongsTo('App\Models\EmployeeProfile','shareEmployee_id','id');
   }

 
}
