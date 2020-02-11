<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialConfig extends Model
{
    protected $table="vishwa_material_config";
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
