@extends('layout.app')
@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;{{ __('job.edit')}} </h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>  
           
            <li class="active"><a href="#">{{ isset($title) ? $title :   __('job.edit') }}</a></li>
        </ul>
    </div>
</div>

@endsection



@section('content')
<div class="row"><br>
    <div class="col-md-6">
        {!! Form::model($job, ['route' => ['jobs.update', $job], 'method' => 'patch']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ $job->name }} <small style="font-size: 12Px;">{{ __('job.edit') }}</small></h3></div>
            <div class="panel-body">
                {!! FormField::text('name', ['label' => __('job.name')]) !!}
                <div class="row">
                    <div class="col-sm-4">
                        
                        <div class="form-group "><label for="price" class="control-label">Price</label>&nbsp;<div class="input-group"><span class="input-group-addon">INR</span><input class="form-control text-right" name="price" type="text" value="{{$job->price}}" id="price"></div></div>
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::select('worker_id', $workers, ['label' => __('job.worker')]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::radios('type_id', [1 => __('job.main'), __('job.additional')], ['value' => 1, 'label' => __('job.type'), 'list_style' => 'unstyled']) !!}
                    </div>
                </div>
                {!! FormField::textarea('description', ['label' => __('job.description')]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::hidden('project_id', $job->project_id) !!}
                {!! Form::submit(__('job.update'), ['class' => 'btn btn-primary']) !!}
                {{ link_to_route('jobs.show', __('app.show'), [$job], ['class' => 'btn btn-info']) }}
                {{ link_to_route('projects.jobs.index', __('job.back_to_index'), [$job->project_id], ['class' => 'btn btn-default']) }}
                {{ link_to_route('jobs.delete', __('job.delete'), [$job], ['class' => 'btn btn-danger pull-right']) }}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-sm-6">
        @include('projects.partials.project-show', ['project' => $job->project])
    </div>
</div>

@endsection

@section('script')
@endsection
