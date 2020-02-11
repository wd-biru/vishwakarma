@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-user" aria-hidden="true"></i></i>&nbsp;Sub Activity Work</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('subActivity.index')}}">Sub Activity Work</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')


<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plus"></i> Add Sub Activity Work</h3></div>
            <div class="panel-body">
                @include('includes.msg')
                @include('includes.validation_messages')

                    <form class="form-horizontal" action="{{route('subActivity.update',[$subActivity->id])}}" method="post" enctype="multipart/form-data"> 
                        {{ csrf_field() }}
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body"> 
                                    <fieldset>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Group Name:&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <select name="activity_group_id" class="form-control" required="">
                                                    @foreach($activityGroups as $activityGroup)
                                                    <option value="">Select Activity Group</option>
                                                    <option value="{{$activityGroup->id}}" {{ ($activityGroup->id == $subActivity->activity_group_id) ? 'selected' : '' }}>{{$activityGroup->activity_group}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Sub Activity Work:&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Sub Activity Work" name="sub_activity_name" required="" value="{{$subActivity->sub_activity_work}}">
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit_btn" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

