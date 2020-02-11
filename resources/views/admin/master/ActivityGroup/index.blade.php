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
@include('includes.msg')
@include('includes.validation_messages')


<div class="row">
    <div class="col-md-12">
        <div class="content-section">
            <a href="{{route('activityGroup.create')}}"><button class="btn btn-primary "><i class="fa fa-user-plus" aria-hidden="true" title="New" ></i>&nbsp;&nbsp;Add </button></a><br><br>
            <div class="  table-responsive ">
                <table class="table table-bordered main-table search-table " >
                    <thead>
                        <tr class="t-head">
                            <th>Sr. No.</th>
                            <th>Activity Group</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $count = 1;
                      ?>
                      @foreach($activityGroups as $activityGroup)
                        <tr>
                            <td>{{$count++}}</td>
                            <td>{{$activityGroup->activity_group}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('activityGroup.edit',$activityGroup->id)}}"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp; Edit</a></li>
                                        <li><a href="{{route('activityGroup.delete',$activityGroup->id)}}"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp; Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection
