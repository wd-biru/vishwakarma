@extends('layout.app')
@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;Store Create </h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>  
            <li>{{ link_to_route('projects.index',trans('project.projects'), ['status_id' => request('status_id', $project->status_id)]) }}</li>
            <li>{{ $project->present()->projectLink }}</li>
            <li class="active">Store Create</li>
        </ul>
    </div>
</div>

@endsection


@section('content')

<div class="row">
    <div class="col-sm-6">
        {!! Form::model($project, ['route' => ['store.save', $project->id], 'method' => 'post' ]) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Store Create</h3></div>
            <div class="panel-body">
            
              <input type="hidden" name="project_id" value="{{$project->id}}">
                  {{csrf_field()}}
              <div class="form-group">
                <div class="col-md-4">
                  <label for="email">Store Name</label>
                </div>
                <div class="col-md-8">
                 <input type="text" style="margin-bottom: 15px;" class="form-control" name="store_name" id="email" required="">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-4">
                  <label for="email">Store Keeper Name</label>
                </div>
                <div class="col-md-8" style="margin-bottom: 15px;">
                  <select  class="form-control store_keepers" name="store_keeper_id[]"  multiple="" required="">
                    
                    @foreach($emp_list as $list)
                    <option value="{{$list->id}}">{{$list->first_name}} {{$list->last_name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
   
        </div>
        
            <div class="panel-footer">
                {!! Form::submit('Create New Store', ['class' => 'btn btn-primary']) !!}
                {{ link_to_route('store.index', __('app.cancel'), [$project], ['class' => 'btn btn-default']) }}
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


 
 
  
