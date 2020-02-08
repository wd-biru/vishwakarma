<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndentItem extends Model
{
    protected $table="vishwa_indent_items";

    public function getItemDetail()
    {
    	return $this->belongsTo(MaterialItem::class,'item_id');
    }
}
