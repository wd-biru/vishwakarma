@extends('layout.app')

@section('title', __('job.add_from_other_project').' | '.$project->name)

@section('content')
@include('projects.partials.breadcrumb',['title' => __('job.add_from_other_project')])

<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('job.add_from_other_project') }}</h3></div>
            <div class="panel-body">
                {!! Form::open(['method' => 'get']) !!}
                <div class="form-group">
                    <label for="project_id" class="text-primary">{{ __('project.project') }}</label>
                    <div class="input-group">
                        {!! Form::select('project_id', $projects, request('project_id'), [
                            'class'       => 'form-control customer-select',
                            'placeholder' => '-- '.__('project.select').' --'
                        ]) !!}
                        <span class="input-group-btn"><button class="btn btn-default btn-sm" type="submit">{{ __('project.show_jobs') }}</button></span>
                    </div>
                </div>
                {!! Form::close() !!}
                @if ($selectedProject)
                {!! Form::open(['route' => ['projects.jobs.store-from-other-project', $project->id]]) !!}
                <ul class="list-unstyled">
                    @forelse($selectedProject->jobs as $key => $job)
                    <li>
                        <label for="job_id_{{ $job->id }}">
                        {!! Form::checkbox('job_ids['.$job->id.']', $job->id, null, ['id' => 'job_id_'.$job->id]) !!}
                        {{ $job->name }}</label>
                        <ul style="list-style-type:none">
                            @foreach($job->tasks as $task)
                            <li>
                                <label for="{{ $job->id }}_task_id_{{ $task->id }}" style="font-weight:normal">
                                {!! Form::checkbox($job->id.'_task_ids['.$task->id.']', $task->id, null, ['id' => $job->id.'_task_id_'.$task->id]) !!}
                                {{ $task->name }}</label>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @empty
                    <li><div class="alert alert-info">{{ __('job.not_found') }}</div></li>
                    @endforelse
                </ul>
                @else
                    <div class="alert alert-info">{{ __('job.select_project') }}</div>
                @endif
                {!! Form::submit(__('job.add'), ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>

            <div class="panel-footer">
                {{ link_to_route('projects.jobs.index', __('app.cancel'), [$project], ['class' => 'btn btn-default']) }}
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        @include('projects.partials.project-show')
    </div>
</div>
@endsection
