<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MasterMaterialsGroup extends Model
{
    protected $table="vishwa_master_material_group";


    function getCountItem()
    {    	
        return $this->hasMany(MaterialItem::class,'group_id','id')->get()->count(); 
    } 
}
