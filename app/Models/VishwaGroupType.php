<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class VishwaGroupType extends Model
{
    protected $table="vishwa_group_type";

    public $timestamps = false;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

}
