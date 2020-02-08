@extends('layout.app')

@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;{{ $project->name }} - {{trans('project.show')}} </h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>  
            <li>{{ link_to_route('projects.index',trans('project.projects'), ['status_id' => request('status_id', $project->status_id)]) }}</li>
    		<li class="active">{{ isset($title) ? $title : trans('project.show') }}</li>
        </ul>
    </div>
</div>

@endsection

{{--dd(Request::segment(3))--}}

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="content-section">
            <h3 class="header">
                <div class="pull-right">
                    @yield('action-buttons')
                </div>
                {{ $project->name }} <small>@yield('subtitle', trans('project.show'))</small>
            </h3>
            @include('projects.partials.nav-tabs')



               
                   
               

            @yield('content-project')
        </div>
    </div>
</div>
@endsection
