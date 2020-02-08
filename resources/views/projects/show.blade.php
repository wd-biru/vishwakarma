@extends('layout.project')

@section('action-buttons')
 @if(Auth::user()->user_type != 'employee')  
    {!! link_to_route('projects.edit', trans('project.edit'), [$project->id], ['class' => 'btn btn-warning']) !!}

{!! link_to_route('projects.index', trans('project.back_to_index'), ['status_id' => $project->status_id], ['class' => 'btn btn-default']) !!}
 @endif
@endsection

@section('content-project')

<div class="row">
    <div class="col-md-6">
        @include('projects.partials.project-show')
    </div>
    <div class="col-md-6">

 @if(Auth::user()->user_type != 'employee')
        {!! Form::model($project, ['route' => ['projects.status-update', $project->id], 'method' => 'patch','class' => 'well well-sm form-inline']) !!}
        {!! FormField::select('status_id', ProjectStatus::toArray(), ['label' => trans('project.status')]) !!}
        {!! Form::submit('Update Project Status', ['class' => 'btn btn-info btn-sm']) !!}
        {!! Form::close() !!}
@endif
        @include('projects.partials.project-stats')
    </div>
</div>

@endsection
