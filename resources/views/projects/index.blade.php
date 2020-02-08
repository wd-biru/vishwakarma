@extends('layout.app')


@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;PMO </h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="content-section">
            <h3 class="header">
            @if(Auth::user()->user_type != 'employee')
                {!! link_to_route('projects.create', trans('project.create'), [], ['class' => 'btn btn-primary pull-right']) !!}
                @endif
                {{ trans('project.index_title', ['status' => $status]) }} <small>({{ $projects->total() }} {{ trans('project.found') }})</small>
            </h3>
            <br>
            <div class="well well-sm text-right">
                <div class="pull-left hidden-xs">{{ $projects->appends(Request::except('page'))->render() }}</div>
                {!! Form::open(['method' => 'get', 'class' => 'form-inline']) !!}
                {!! FormField::select('status_id', ProjectStatus::toArray(), ['value' => $statusId, 'placeholder' => trans('project.all')]) !!}
                {!! Form::text('q', Request::get('q'), ['class' => 'form-control index-search-field', 'placeholder' => trans('project.search'), 'style' => 'width:100%;max-width:350px']) !!}
                {!! Form::submit(trans('project.search'), ['class' => 'btn btn-primary btn-sm']) !!}
                {!! link_to_route('projects.index', 'Reset', [], ['class' => 'btn btn-default btn-sm']) !!}
                {!! Form::close() !!}
            </div>
            <div class="table-responsive">
                <table class="table table-condensed table-hover">
                    <thead>
                        <th>{{ trans('app.table_no') }}</th>
                        <th>{{ trans('project.name') }}</th>
                        <th class="text-center">{{ trans('project.start_date') }}</th>
                        <th class="text-center">{{ trans('project.work_duration') }}</th>
                        @can('see-pricings', new App\Entities\Projects\Project)
                        <th class="text-right">{{ trans('project.project_value') }}</th>
                        @endcan
                        <th class="text-center">{{ trans('app.status') }}</th>
                        <th>{{ trans('project.customer') }}</th>
                        <th>{{ trans('app.action') }}</th>
                    </thead>
                    <tbody>
                        @if(Auth::user()->user_type != 'employee')
                        @forelse($projects as $key => $project)
                        <tr>
                            <td>{{ $projects->firstItem() + $key }}</td>
                            <td>{{ $project->nameLink() }}</td>
                            <td class="text-center">{{ $project->start_date }}</td>
                            <td class="text-right">{{ $project->present()->workDuration }}</td>
                            @can('see-pricings', new App\Entities\Projects\Project)
                            <td class="text-right">{{ formatRp($project->project_value) }}</td>
                            @endcan
                            <td class="text-center">{{ $project->present()->status }}</td>
                            <td>{{-- $project->customer->Client_name --}}</td>
                            <td>
                                {!! html_link_to_route('projects.show', '', [$project->id], ['icon' => 'search', 'class' => 'btn btn-primary btn-xs', 'title' => trans('app.show')]) !!}
                                {!! html_link_to_route('projects.edit', '', [$project->id], ['icon' => 'edit', 'class' => 'btn btn-warning btn-xs', 'title' => trans('app.edit')]) !!}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">{{ $status }} {{ trans('project.not_found') }}</td>
                        </tr>
                        @endforelse
                        @else
                        <?php
                            $array = array(1 => 'Planned', 2 => 'Progress', 3 => 'Done', 4 => 'Closed', 5 => 'Canceled', 6 => 'On Hold');

                            $status_id = array_search($status, $array);

                               

                                $worker_id = Auth::user()->getEmp->id;
                            
                            if ($status_id==null) {
                                $projectData = DB::table('vishwa_projects')
    ->join('vishwa_employee_project_mapping','vishwa_projects.id','=','vishwa_employee_project_mapping.project_id')
    ->join('vishwa_client_info','vishwa_projects.client_id','=','vishwa_client_info.id')
                                ->where('vishwa_employee_project_mapping.employee_id',$worker_id)
                                ->get();

                        
                            }else{
                            $projectData = DB::table('vishwa_projects')
    ->join('vishwa_employee_project_mapping','vishwa_projects.portal_id','=','vishwa_employee_project_mapping.portal_id')
    ->join('vishwa_client_info','vishwa_projects.client_id','=','vishwa_client_info.id')
                                ->where('vishwa_employee_project_mapping.employee_id',$worker_id)
                                ->where('vishwa_projects.status_id','=',$status_id)
                                ->get();
                                
                            }
                            $i=1;

                        

                        
                        ?>
                        @forelse($projectData as $key => $project)
                        <tr>
                            <td>{{$i++}}</td>
                            <td><a href="{{url('projects',[$project->project_id])}}" title="Show'{{$project->name}}'detail">{{$project->name}}</a></td>
                            <td class="text-center">{{ $project->start_date }}</td>
                            <td class="text-right"></td>
                            @can('see-pricings', new App\Entities\Projects\Project)
                            <td class="text-right">{{ formatRp($project->project_value) }}</td>
                            @endcan
                            <td></td>
                            <td>{{ $project->Client_name }} </td>
                            <td>
                                {!! html_link_to_route('projects.show', '', [$project->project_id], ['icon' => 'search', 'class' => 'btn btn-info btn-xs', 'title' => trans('app.show')]) !!}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">{{ $status }} {{ trans('project.not_found') }}</td>
                        </tr>
                        @endforelse

                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{ $projects->appends(Request::except('page'))->render() }}
@endsection
