@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-user" aria-hidden="true"></i></i>&nbsp;Activity Group</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('activityGroup.index')}}">Activity Group</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')


<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plus"></i> Add Activity Group</h3></div>
            <div class="panel-body">
                @include('includes.msg')
                @include('includes.validation_messages')

                    <form class="form-horizontal" action="{{route('activityGroup.store')}}" method="post" enctype="multipart/form-data"> 
                        {{ csrf_field() }}
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body"> 
                                    <fieldset>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Group Name:&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Enter Group Name" name="group_name" required="">
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

