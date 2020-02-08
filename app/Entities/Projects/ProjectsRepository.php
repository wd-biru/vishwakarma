<?php

namespace App\Entities\Projects;

use App\Entities\BaseRepository;
use App\Entities\Partners\Client;
use DB;
use ProjectStatus;
use Auth;
use App\Models\EmployeeProfile;
use App\Models\Portal;
use App\User;
use App\Models;

/**
 * Projects Repository Class.
 */
class ProjectsRepository extends BaseRepository
{
    protected $model;

    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

    public function getProjects($q, $statusId, User $user)
    {
        
         $id = Auth::user()->id;
       if(Auth::user()->user_type=="employee")
            {
                     $result = EmployeeProfile::where('user_id',$id)->pluck('portal_id')->first();
                     $portal_id = Portal::where('id',$result)->first();


                      $statusIds = array_keys(ProjectStatus::toArray());

                    
                    return $this->model->latest()

                    ->where(function ($query) use ($q, $statusId, $statusIds) {


                        $query->where('name', 'like', '%'.$q.'%');

                        if ($statusId && in_array($statusId, $statusIds)) {
                            $query->where('status_id', $statusId);
                        }
                    })
                    ->where('portal_id',$portal_id)
                    ->with('customer')
                    ->paginate($this->_paginate);
            }


        $statusIds = array_keys(ProjectStatus::toArray());

            
            return $this->model->latest()

            ->where(function ($query) use ($q, $statusId, $statusIds) {


                $query->where('name', 'like', '%'.$q.'%');

                if ($statusId && in_array($statusId, $statusIds)) {
                    $query->where('status_id', $statusId);
                }
            })
            ->where('portal_id',Auth::user()->getPortal->id)
            ->with('customer')
            ->paginate($this->_paginate);

    }

    public function create($projectData)
    {
        $projectData['project_value'] = $projectData['proposal_value'] ?: 0; 
        DB::beginTransaction();

        if (isset($projectData['client_id']) == false || $projectData['client_id'] == '') {
            // $customer = $this->createNewCustomer($projectData['customer_name'], $projectData['customer_email']);
            $projectData['portal_id'] = Auth::user()->getPortal->id; 
            // $projectData['portal_id'] = Auth::user()->getPortal->id;
        } 

        $project = $this->storeArray($projectData); 
        DB::commit();

        return $project;
    }

    public function getStatusName($statusId)
    {
        //dd(ProjectStatus::getNameById($statusId));
        return ProjectStatus::getNameById($statusId);
    }

    public function createNewCustomer($customerName, $customerEmail)
    {
        $newCustomer = new Pro();
        $newCustomer->name = $customerName;
        $newCustomer->email = $customerEmail;
        $newCustomer->save();

        return $newCustomer;
    }

    public function delete($projectId)
    {
        $project = $this->requireById($projectId);

        DB::beginTransaction();

        // Delete project payments
        $project->payments()->delete();

        // Delete jobs tasks
        $jobIds = $project->jobs->pluck('id')->all();
        DB::table('tasks')->whereIn('job_id', $jobIds)->delete();

        // Delete jobs
        $project->jobs()->delete();

        // Delete project
        $project->delete();

        DB::commit();

        return 'deleted';
    }

    public function updateStatus($statusId, $projectId)
    {
        $project = $this->requireById($projectId);
        $project->status_id = $statusId;
        $project->save();

        return $project;
    }

    public function jobsReorder($sortedData)
    {
        $jobOrder = explode(',', $sortedData);
        foreach ($jobOrder as $order => $jobId) {
            $job = $this->requireJobById($jobId);
            $job->position = $order + 1;
            $job->save();
        }

        return $jobOrder;
    }
}
