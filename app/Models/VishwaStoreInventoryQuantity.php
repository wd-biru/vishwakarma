<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use App\User as UserDetails;


class VishwaStoreInventoryQuantity extends Model
{
    protected $table = "vishwa_store_inventory_qty";


    public function scopeFilterAlterData($query, $portal_id, $store_id)
    {
        return $query->join('vishwa_materials_item', 'vishwa_materials_item.id', '=', 'vishwa_store_inventory_qty.item_id')
            ->select('vishwa_store_inventory_qty.*', 'vishwa_materials_item.material_name')
            ->where('vishwa_store_inventory_qty.portal_id', '=', $portal_id)
            ->where('vishwa_store_inventory_qty.store_id', '=', $store_id);
    }


}