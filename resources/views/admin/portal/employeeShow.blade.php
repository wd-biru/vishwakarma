@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Portal Management</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('portal')}}">Users list</a></li>
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
            <a href="{{route('portalCreate')}}"><button class="btn btn-primary "><i class="fa fa-user-plus" aria-hidden="true" title="New" ></i>&nbsp;&nbsp;Add Portal </button></a><br><br>
            <div class="  table-responsive ">
    <table class="table table-bordered main-table search-table " >
        <thead>
            <tr class="btn-primary">
                <th>Sr No.</th>
                <th>Employee Name</th>
                <th>Email</th>
                <th>Contact No.</th>
                <th>Gender</th>
                <th>Other Phone</th>
                <th>Address</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($employees))
            <?php $i=1?>
            @foreach($employees as $list)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$list->first_name}} {{$list->last_name}}</td>
                <td>{{$list->getUserDetails->email}}</td>
                <td>{{$list->phone}}</td>
                <td>{{$list->gender}}</td>
                <td>{{$list->other_phone}}</td>
                <td>{{$list->address}}</td>
                <td>@if($list->status==1)
                                    <img src="{{ my_asset('images/activate.png') }}">
                                @else
                                    <img class="change_status"   src="{{my_asset('images/deactivate.png')}}">
                                @endif</td>
            </tr>
            @endforeach     
            @endif              
        </tbody>
    </table>
</div>
        </div>
    </div>
</div>

@endsection
