@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-bank" aria-hidden="true"></i></i>&nbsp;Bank Master</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('bankMaster.index')}}">Bank Master</a></li>
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
            <a href="{{route('bankMaster.create')}}"><button class="btn btn-primary "><i class="fa fa-user-plus" aria-hidden="true" title="New" ></i>&nbsp;&nbsp;Add </button></a><br><br>
            <div class="  table-responsive ">
                <table class="table table-bordered main-table search-table " >
                    <thead>
                        <tr class="t-head">
                            <th>Sr. No.</th>
                            <th>Bank Name</th>
                            <th>IFSC Code</th>
                            <th>Country</th>
                            <th>Address/State/City</th>
                            <th>District</th>
                            <th>Pincode</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1;
                        ?>
                        @foreach($bankmasters as $bankmaster)
                        <tr>
                            <td>{{$count++}}</td>
                            <td>{{ $bankmaster->bank_name }}</td>
                            <td>{{ $bankmaster->ifsc_code }}</td>
                            <td>{{ $bankmaster->country }}</td>
                            <td>{{ $bankmaster->address }}/{{ $bankmaster->state}}/{{ $bankmaster->city}}</td>
                            <td>{{ $bankmaster->district }}</td>
                            <td>{{ $bankmaster->pincode }}</td>
                            <td>{{ $bankmaster->status }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('bankMaster.edit',$bankmaster->id)}}"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp; Edit</a></li>
                                        <li><a href="{{route('bankMaster.show',$bankmaster->id)}}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp; View</a></li>
                                        <li>
                                            <a href="{{route('bankDelete',$bankmaster->id)}}"><i class="fa fa-eye" aria-hidden="true"> delete</i></a>
                                        </li>
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
@section('script')


@endsection


