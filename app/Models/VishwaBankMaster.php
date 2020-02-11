<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class VishwaBankMaster extends Model
{
	use SoftDeletes;
    protected $table="vishwa_bank_master";
    protected $dates = ['deleted_at'];
    public $timestamp = false;
}
