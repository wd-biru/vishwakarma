<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 


class VishwaBankAccount extends Model
{
    use SoftDeletes;
    protected $table="vishwa_portal_bank_mapping";
    public $timestamp = false;
}
