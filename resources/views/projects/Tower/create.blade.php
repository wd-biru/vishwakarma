@extends('layout.app')
@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;Tower Create </h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>  
            <li>{{ link_to_route('projects.index',trans('project.projects'), ['status_id' => request('status_id', $project->status_id)]) }}</li>
            <li>{{ $project->present()->projectLink }}</li>
            <li class="active">Tower Create</li>
        </ul>
    </div>
</div>

@endsection




@section('content')
@include('includes.msg')
@include('includes.validation_messages')
<div class="row">
    <div class="col-sm-6">
        {!! Form::model($project, ['route' => ['Tower.save', $project->id], 'method' => 'post' ]) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Tower Create</h3></div>
            <div class="panel-body">
            
              <input type="hidden" name="project_id" value="{{$project->id}}">
                  {{csrf_field()}}
              <div class="form-group">
                <div class="col-md-4">
                  <label for="email">Tower Name</label>
                </div>
                <div class="col-md-8">
                 <input type="text" style="margin-bottom: 15px;" class="form-control" name="tower_name" id="tower_name" required="">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-4">
                  <label for="email">Tower Incharge</label>
                </div>
                <div class="col-md-8" style="margin-bottom: 15px;">
                  <select  class="form-control store_keepers" name="tower_keeper_id[]"  multiple="" required="">
                    
                    @foreach($emp_list as $list)
                    <option value="{{$list->id}}">{{$list->first_name}} {{$list->last_name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
   
        </div>
        
            <div class="panel-footer">
                {!! Form::submit('Create New Tower', ['class' => 'btn btn-primary']) !!}
                {{ link_to_route('Tower.Index', __('app.cancel'), [$project], ['class' => 'btn btn-default']) }}
            </div>
        {!! Form::close() !!}
    </div>
  </div>
    <div class="col-sm-6">
        @include('projects.partials.project-show')
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$('.store_keepers').select2({
                    tags: true,
                    tokenSeparators: [','],
                    placeholder: "Select Store Keepers"
                });
 
</script>
@endsection


 
 
  
