<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User as UserDetails;

class VishwaProjectStore extends Model
{
    //
    protected $table="vishwa_project_store";

	public function getStoreEmp()
    {
        return $this->hasMany(VishwaStoreMapping::class,'store_id');
    }
    

}
