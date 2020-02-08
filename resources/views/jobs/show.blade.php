@extends('layout.app')

@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;{{ __('job.detail')}} </h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>  
            
    <li>{{ link_to_route('projects.index', __('project.projects')) }}</li>
    <li>{{ $job->present()->projectLink }}</li>
    <li>{{ $job->present()->projectJobsLink }}</li>
    <li class="active">{{ isset($title) ? $title : $job->name }}</li>
        </ul>
    </div>
</div>

@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="content-section">
            <h3 class="header">
                <div class="pull-right">         
                 @if(Auth::user()->user_type != 'employee')      
                        {!! html_link_to_route('projects.jobs.create', __('job.create'), [$job->project_id], ['class' => 'btn btn-success','icon' => 'plus']) !!}
                   
                        {{ link_to_route('jobs.edit', __('job.edit'), [$job], ['class' => 'btn btn-warning']) }}
                        @endif
               
                    {{ link_to_route('projects.jobs.index', __('job.back_to_index'), [$job->project_id, '#' . $job->id], ['class' => 'btn btn-default']) }}
                </div>
                {{ $job->name }} <small>{{ __('job.detail') }}</small>
            </h3>
            <br>
            <div class="row">
                <div class="col-md-5">
                    @include('jobs.partials.job-show')
                </div>
   
                <div class="col-sm-7">
                    @include('jobs.partials.job-tasks-operation')
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    @include('jobs.partials.job-tasks')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('ext_css')
   
@endsection

 
@section('script')
    {!! Html::style(url('public/css/plugins/rangeslider.css')) !!}
     <style>
        .rangeslider--horizontal {
            margin-top: 10px;
            margin-bottom: 10px;
            height: 10px;
        }
        .rangeslider--horizontal .rangeslider__handle {
            top : -5px;
            width: 20px;
            height: 20px;
        }
        .rangeslider--horizontal .rangeslider__handle:after {
            width: 8px;
            height: 8px;
        }
    </style>
 {!! Html::script(url('public/js/plugins/rangeslider.min.js')) !!}
<script>
(function() {
    $('input[type="range"]').rangeslider({ polyfill: false });

    $(document).on('input', 'input[type="range"]', function(e) {
        var ap_weight = e.currentTarget.value;
        $('#ap_weight').text(ap_weight);
    });
})();
</script>
@endsection
