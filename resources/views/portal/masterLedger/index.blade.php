@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-money" aria-hidden="true"></i></i>&nbsp; Master Ledger</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('masterLedger.index')}}">Master Ledger</a></li>
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
            <a href="{{route('masterLedger.create')}}"><button class="btn btn-primary "><i class="fa fa-user-plus" aria-hidden="true" title="New" ></i>&nbsp;&nbsp;Add </button></a><br><br>
            <div class="  table-responsive ">
                <table class="table table-bordered main-table search-table " >
                    <thead>
                        <tr class="t-head">
                            <th>Sr. No.</th>
                            <th>Client Type</th>
                            <th>Opening Balance</th>
                            <th>Closing Balance</th>
                            <th>As on Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php
                    		$count = 1;
                    	?>
                    	@foreach($masterLedgers as $masterLedger)
                        <tr>
                        	<td>{{$count++}}</td>
                        	<td>{{$masterLedger->name}}</td>
                        	<td>{{$masterLedger->opening_balance}}</td>
                        	<td>{{$masterLedger->closing_balance}}</td>
                        	<td>{{$masterLedger->opening_balance_date}}</td>
                        	<td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" style="width: 20px;">
                                        <li><a href=""><i class="fa fa-eye" aria-hidden="true"></i>&nbsp; View</a></li>
                                        <li><a href="{{route('masterLedger.edit',$masterLedger->id)}}"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp; Edit</a></li>
                                        <li><a href="{{route('masterLedger.delete',$masterLedger->id)}}" onclick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp; Delete</a></li>
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



