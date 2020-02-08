@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Service Management</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('portal')}}">Users list</a></li>
                <!-- <li><a href="#">list</a></li> -->
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
            <!-- <a href="{{route('portalCreate')}}"><button class="btn btn-primary ">
              <i class="fa fa-user-plus" aria-hidden="true" title="New" ></i>&nbsp;&nbsp;Add
            </button></a>
            <br><br> -->
            <div class="  table-responsive ">
                <table class="table table-bordered main-table search-table " >
                    <thead>
                        <tr class="t-head">
                            <th>Sr. No.</th>
                            <th>Registration No.</th>
                            <th>Service Type</th>
                            <th>Company Name</th>
                            <th>Company Email</th>
                            {{--<th>Project Count </th>--}}
                            <th>Phone No.</th>
                            {{--<th>Mobile No.</th>--}}
                            {{--<th>Address</th>--}}
                             <th>Status</th>
                             <th>Action</th>

                        </tr>
                    </thead>
                    <tbody><?php $i=1;?>
                        @foreach($serviceregister as $list)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>
                           <a href="{{route('SrvcList.show',[$list->id])}}">
                                {{$list->contact_name}}
                           </a>
                            </td>
                            <td>{{$list->contact_email}}</td>
                            <td>{{$list->company_name}}</td>
                            <td>{{$list->email}}</td>
                            <td>{{$list->phone_no}}</td>

                             <td>
                                @if($list->is_active==1)
                                    <img src="{{ my_asset('images/activate.png') }}">
                                @else
                                    <img class="change_status"   src="{{my_asset('images/deactivate.png')}}">
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('SrvcList.edit',[$list->id])}}"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp; Edit</a></li>
                                        <li><a href="{{route('SrvcList.show',[$list->id])}}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp; View</a></li>
                                        {{--<li><a href="{{route('portalEmployeeShow',[$list->id])}}"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; View Employee</a></li>--}}
                                        <li><a href="{{route('SrvcList.destroy',[$list->id])}}" onclick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp; Delete</a></li>
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
