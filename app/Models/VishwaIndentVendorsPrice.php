<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MaterialItem;

use App\User as UserDetails;


class VishwaIndentVendorsPrice extends Model
{
    protected $table="vishwa_indent_vendor_price";


    public function getMaterialItem()
    {
    	return $this->belongsTo(MaterialItem::class,'item_id','id');
      
    }

    function getIndent()
    { 
        return  $this->belongsTo(Indent::class,'indent_id','indent_id');
    }

}