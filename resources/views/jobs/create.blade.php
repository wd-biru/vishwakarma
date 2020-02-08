@extends('layout.app')
@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;{{ __('job.create')}} </h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>  
            <li>{{ link_to_route('projects.index',trans('project.projects'), ['status_id' => request('status_id', $project->status_id)]) }}</li>
            <li>{{ $project->present()->projectLink }}</li>
            <li class="active">{{ isset($title) ? $title :   __('job.create') }}</li>
        </ul>
    </div>
</div>

@endsection


@section('content')

<div class="row">
    <div class="col-sm-6">
        {!! Form::open(['route' => ['projects.jobs.store', $project->id]]) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('job.create') }}</h3></div>
            <div class="panel-body">
                {!! FormField::text('name', ['label' => __('job.name')]) !!}
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group "><label for="price" class="control-label">PRICE</label>&nbsp;<div class="input-group"><span class="input-group-addon">INR</span><input class="form-control text-right" name="price" type="text" value="0" id="price"></div></div>
                    </div>
                    <div class="col-sm-5">
                        <label for="worker_id" class="control-label">Worker</label>
                        <select name="worker_id" id="id-worker">
                            @forelse($workers as $data)
                            <option value="{{$data->id}}">{{$data->first_name}} {{$data->last_name}}</option>
                            @empty
                            <option value="0">No Record Found</option>
                            @endforelse
                        </select>
                        

                         </div>
                    <div class="col-sm-3">
                        {!! FormField::radios('type_id', [1 => __('job.main'), __('job.additional')], ['value' => 1, 'label' => __('job.type'), 'list_style' => 'unstyled']) !!}
                    </div>
                </div>
                {!! FormField::textarea('description', ['label' => __('job.description')]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::submit(__('job.create'), ['class' => 'btn btn-primary']) !!}
                {{ link_to_route('projects.jobs.index', __('app.cancel'), [$project], ['class' => 'btn btn-default']) }}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-sm-6">
        @include('projects.partials.project-show')
    </div>
</div>
@endsection
@section('script') 
<script type="text/javascript">     
    jQuery('#proposal_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });
    $("#id-worker").select2({
        placeholder: "Select a Customer",
        allowClear: true
    });
   
</script>
@endsection