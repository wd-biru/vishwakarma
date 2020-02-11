<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GateEntry extends Model
{
    protected $table = "vishwa_gate_entry_details"; 

    public $timestamps=false;
    use SoftDeletes;

    protected $dates = ['deleted_at'];



    public function scopeGateEntryFilter($query,$portal_id,$project_id)
    {
        return $query->leftjoin('vishwa_vendor_challan', 'vishwa_gate_entry_details.challan_no', 'vishwa_vendor_challan.challan_no')
            ->leftjoin('vishwa_vendor_master', 'vishwa_vendor_challan.vendor_id', 'vishwa_vendor_master.id')
            ->select('vishwa_vendor_challan.*', 'vishwa_gate_entry_details.*', 'vishwa_vendor_master.company_name')
            ->where('vishwa_gate_entry_details.portal_id', $portal_id)
            ->where('vishwa_gate_entry_details.project_id', $project_id)
            ->orderBy('vishwa_gate_entry_details.incoming_time', 'DESC');
    }

}
