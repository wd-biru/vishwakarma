@extends('layout.app')
<style type="text/css">

</style>
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-bookmark" aria-hidden="true"></i></i>&nbsp;Company Management</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('master.comMgmt.index')}}">Company Management</a></li>
                <li><a href="#">Menus</a></li>
                <!-- <li><a href="#">list</a></li> -->
            </ul>
        </div>
    </div>
@endsection
@section('content')
@include('includes.msg')
@include('includes.validation_messages')



    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading right_tab">
                <h3 class="panel-title"><i class="fa fa-list"></i> Menus</h3>
            </div>
            <div class="panel-body right_tab">
                <li><a href="{{route('comMgmt.Source')}}"> Source Of Client </a></li>
                <li><a href="{{route('comMgmt.TypeClient')}}"> Type Of Client</a></li>
                <li><a href="{{route('comMgmt.Activites')}}"> Activites</a></li>
                <li><a href="{{route('comMgmt.Category')}}"> Category</a></li>
                <li><a href="{{route('comMgmt.Worktype')}}"> Time Log Work Type</a></li>
            </div>
        </div>
    </div>


 
   


@endsection