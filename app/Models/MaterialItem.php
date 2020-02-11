<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialItem extends Model
{
    protected $table="vishwa_materials_item";

    public function getUnitDetail()
    {
    	return $this->belongsTo(MasterUnit::class,'material_unit');
    }
    public function getGroupDetail()
    {
    	return $this->belongsTo(MasterMaterialsGroup::class,'group_id');
    }

    public function toArray()
    {
        $attributes = $this->attributesToArray();
        return array_merge($attributes, $this->relationsToArray());
    }


    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    
}
