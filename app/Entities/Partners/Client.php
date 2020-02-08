<?php

namespace App\Entities\Partners;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['portal_id', 'Client_name', 'Source', 'Group', 'Type', 'File_No', 'Box_No', 'Status', 'Website', 'Activities', 'Registration_No', 'fee_comments', 'Date_Acquired'];
     protected $table='vishwa_client_info';
    public function projects()
    {
        return $this->hasMany('App\Entities\Projects\Project');
    }


    public function nameLink()
    {
        return link_to_route('projects.show', $this->Client_name, [$this->id], [
            'title' => trans(
                'app.show_detail_title',
                ['Client_name' => $this->Client_name, 'type' => trans('projects.show')]
            ),
        ]);
    }

    public function getStatusAttribute()
    {
        return $this->status == 1 ? trans('app.active') : trans('app.in_active');
    }

    public function getStatusLabelAttribute()
    {
        $color = $this->status == 1 ? ' style="background-color: #337ab7"' : '';

        return '<span class="badge"'.$color.'>'.$this->status.'</span>';
    }
}
