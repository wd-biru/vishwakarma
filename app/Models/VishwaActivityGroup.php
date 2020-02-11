<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class VishwaActivityGroup extends Model
{
	use SoftDeletes;
    public $timestamp = false;
    protected $dates = ['deleted_at'];
    protected $table="vishwa_activity_groups";
}
