<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\Project;
use App\Entities\Projects\ProjectsRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\CreateRequest;
use App\Http\Requests\Projects\UpdateRequest;
use Illuminate\Http\Request;
use Auth;
use DB;
/**
 * Projects Controller.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class ProjectsController extends Controller
{
    private $repo;

    public function __construct(ProjectsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $status = null;
        $statusId = $request->get('status_id');
        if ($statusId) {
            $status = $this->repo->getStatusName($statusId);
        }

        //dd($request->all());

        $projects = $this->repo->getProjects($request->get('q'), $statusId, auth()->user());

                               //dd($projects);




        return view('projects.index', compact('projects', 'status', 'statusId'));
    }

    public function create()
    {
        //$this->authorize('create', new Project());

        $customers = $this->repo->getCustomersList();

        //dd($customers);
        $state = $this->repo->getStateList(); 
     

        return view('projects.create', compact('customers','state'));
    }

    public function store(CreateRequest $request)
    {
      //  $this->authorize('create', new Project());
      //  dd($request->except('_token'));
      $project = $this->repo->create($request->except('_token'));
        flash(trans('project.created'), 'success');

        return redirect()->route('projects.show', $project);
    }

    public function show(Project $project)
    {
        

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        //$this->authorize('update', $project);

        $customers = $this->repo->getCustomersList();
        $state = $this->repo->getStateList();
        $city = $this->repo->getCityList();
       

        return view('projects.edit', compact('project', 'customers','state','city'));
    }

    public function update(Request $request, Project $project)
    {
        //$this->authorize('update', $project);
        //dd($request->all());

        $project = $this->repo->update($request->except(['_method', '_token']), $project->id);
       flash(trans('project.updated'), 'success');

        return redirect()->route('projects.edit', $project);
    }

    public function delete(Project $project)
    {
       // $this->authorize('delete', $project);

        return view('projects.delete', compact('project'));
    }

    public function destroy(Project $project)
    {
     //   $this->authorize('delete', $project);

        if ($project->id == request('project_id')) {
            $this->repo->delete($project->id);
            flash(trans('project.deleted'), 'success');
        } else {
            flash(trans('project.undeleted'), 'danger');
        }

        return redirect()->route('projects.index');
    }

    public function subscriptions(Project $project)
    {
        $this->authorize('view-subscriptions', $project);

        return view('projects.subscriptions', compact('project'));
    }

    public function payments(Project $project)
    {
        $this->authorize('view-payments', $project);

        $project->load('payments.partner');

        return view('projects.payments', compact('project'));
    }

    public function statusUpdate(Request $request, Project $project)
    {
       // $this->authorize('update', $project);
        //dd($request->all());
        $project = $this->repo->updateStatus($request->get('status_id'), $project->id);
        flash(trans('project.updated'), 'success');

        return redirect()->route('projects.show', $project);
    }

    public function jobsReorder(Request $request, Project $project)
    {
        //$this->authorize('update', $project);

        if ($request->ajax()) {
            $data = $this->repo->jobsReorder($request->get('postData'));

            return 'oke';
        }
    }
}
