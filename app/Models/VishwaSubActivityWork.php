<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class VishwaSubActivityWork extends Model
{
	use SoftDeletes;
    public $timestamp = false;
    protected $dates = ['deleted_at'];
    protected $table="vishwa_sub_activity_works";
}
