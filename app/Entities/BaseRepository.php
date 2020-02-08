<?php

namespace App\Entities;

use App\Entities\Projects\Job;
use App\Entities\Projects\Project;
use App\Entities\Partners\Client;
use App\Models\States;
use App\Models\Cities;

use App\Models\MaterialItem;
use Auth;
use App\Models\EmployeeProfile;
/**
 * Base Repository Class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
abstract class BaseRepository extends EloquentRepository
{
    
    public function getCustomersList()
    {
        //dd('asdghjk');
        return Client::orderBy('Client_name')->where('portal_id',Auth::user()->getPortal->id)->pluck('Client_name', 'id');
    }

    public function getStateList()
    {
        //dd('asdghjk');
        return States::get()->pluck('name', 'id');
    }

    public function getCityList()
    {
        //dd('asdghjk');
        return Cities::get()->pluck('name', 'id');
    }

    public function getProjectsList()
    {
        return Project::orderBy('name')->pluck('name', 'id');
    }


    public function getWorkersList()
    {
        return EmployeeProfile::where('portal_id',Auth::user()->getPortal->id)->orderBy('first_name')->pluck('first_name', 'id');
        
    }

    public function requireJobById($jobId)
    {
        return Job::findOrFail($jobId);
    }

    public function getMaterialList($materialgroup_id)
    {
        return MaterialItem::findOrFail($materialgroup_id);
    }
}
