<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgreementItem extends Model
{
    protected $table="vishwa_rentable_item_price";
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
