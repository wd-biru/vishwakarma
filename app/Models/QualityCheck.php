<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualityCheck extends Model
{
    protected $table='vishwa_quality_check';



    public function scopeQualityFilterData($query,$portal_id,$project_id)
    {
        return $query->where('vishwa_quality_check.portal_id', $portal_id)
            ->where('vishwa_quality_check.project_id', $project_id)
            ->orderBy('vishwa_quality_check.created_at', 'DESC');
    }
}
