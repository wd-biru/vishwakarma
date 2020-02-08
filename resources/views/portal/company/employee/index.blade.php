@extends('layout.app')
@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-user-circle"></i>&nbsp;Employee Management</h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
            <li><a href="{{route('company')}}">Employee List</a></li>
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
            <div><a href="{{route('companyemployeeCreate')}}"><button class="btn btn-primary "><i class="fa fa-user-plus" aria-hidden="true" title="New" style="padding-top: 5px;padding: 4px;"></i>Add </button></a><br><br></div>

            {{--check Export Data--}}
            <a href="{{ route('export') }}"><button class="btn btn-success">Download Excel xls</button></a>
            {{--<a href="{{ route('export',['id'=>'xlsx']) }}"><button class="btn btn-success">Download Excel xlsx</button></a>--}}
            {{--<a href="{{ route('export',['id'=>'csv']) }}"><button class="btn btn-success">Download CSV</button></a>--}}

            {{--<form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">--}}

                {{--@csrf--}}
                {{--<input type="file" name="file" class="form-control">--}}
                {{--<br>--}}
                {{--<button class="btn btn-info">Import User Data</button>--}}
            {{--</form>--}}


            <div class="  table-responsive ">
                <table class="table table-bordered main-table search-table " >
                    <thead>
                        <tr class="btn-primary-th">

                            <th>Sr. No</th>
                            <th>Employee Name</th>
                            
                            <th>Contact No.</th>
                            <th>Gender</th>
                            <th>Other Phone</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody><?php $i = 1;?>
                      @foreach($employee_list as $list_value)
                        <tr>

                            <td>{{$i++}}</td>
                            <td>{{$list_value->first_name}} {{$list_value->last_name}}</td>
                             
                            <td>{{$list_value->phone}}</td>
                            <td>{{$list_value->gender}}</td>
                            <td>{{$list_value->other_phone}}</td>
                            <td>{{$list_value->address}}</td>
                            <td class="table-status">
                             @if($list_value->status==1)
                                    <img src="{{ my_asset('images/activate.png') }}">
                                @else
                                    <img class="change_status"  src="{{my_asset('images/deactivate.png')}}">

                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('employee.permission',[$list_value->id])}}"><i class="fa fa-key"></i>Permission</a></li>
                                        <li><a href="{{route('companyemployeeInfoEdit',[$list_value->id])}}"><i class="fa fa-edit"></i>Edit</a></li>
                                        <li><a href="{{route('companyemployeeDelete',[$list_value->id])}}" onclick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash"></i>Delete</a></li>
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
