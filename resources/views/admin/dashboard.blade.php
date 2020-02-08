@extends('layout.app')
<style type="text/css">
.box-header {
  color: #444;
  display: block;
  padding: 10px;
  position: relative;
}
.box-header.with-border {
  border-bottom: 1px solid #f4f4f4;
}
.box-body {
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  border-bottom-right-radius: 3px;
  border-bottom-left-radius: 3px;
  padding: 10px;
}
.box-footer {
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  border-bottom-right-radius: 3px;
  border-bottom-left-radius: 3px;
  border-top: 1px solid #f4f4f4;
  padding: 10px;
  background-color: #ffffff;
}
.box-header > .fa, .box-header > .glyphicon, .box-header > .ion, .box-header .box-title {
  display: inline-block;
  font-size: 18px;
  margin: 0;
  line-height: 1;
  width: 100%;
}
</style>
@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;Admin Dashboard</h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></li></a>

        </ul>
    </div>
</div>
@endsection
@section('content')
@include('includes.msg')
<div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
            <div class="inner-box">
                <h3>{{count($portals)}}</h3>
            </div>
          <p class="order" style="float: right;">Active Users</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="{{route('portal')}}" class="small-box-footer" style="font-size:16px;color: black;">More info
            <i class="fa fa-arrow-circle-right" style="color:green;"></i>
        </a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
            <div class="inner-box" style="background-color: #ecb442;">
                <h3></h3>
            </div>
          <p class="order" style="float: right;">Services</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="" class="small-box-footer" style="font-size:16px;color: black;">More info
            <i class="fa fa-arrow-circle-right" style="color:#ecb442;"></i>
        </a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
            <div class="inner-box" style="background-color: #29b6f6;">
                <h3></h3>
            </div>
          <p class="order" style="float: right;">Fees</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="" class="small-box-footer" style="font-size:16px;color: black;">More info
            <i class="fa fa-arrow-circle-right" style="color: #29b6f6;"></i>
        </a>
      </div>
    </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="box-header with-border" style="border-top: 2px solid #d13631;background-color: #fff;  margin-top: 10px;">
      <h3 class="box-title">Users List</h3>
    </div>
    <div class="box-body" style="background-color:#fff;">
<div class="table-responsive">
      <table class="table search-table" >
       <thead>
         <tr style="font-size: 14px;" class="t-head">
            <th>Sr. No.</th>
            <th>User Name</th>
            <th>Sur Name</th>
            <th>Contact No.</th>
            <th>Other Phone</th>
            <th>No. of Companies</th>
            <th>No. of Employees</th>
            <th>Address</th>
            <th>Status</th>
         </tr>
       </thead>
       <tbody>
         <?php $count=0; ?>
         @if($count < 5)
         @foreach($portals as $list)
         <?php
         $count++;
         ?>

         <tr style="font-size: 11px;">

            <td>{{$count}}</td>
            <td><a href="{{route('portalInfoEdit',[$list->id])}}">{{$list->name}}</a></td>
            <td>{{$list->surname}}</td>
            <td>{{$list->mobile}}</td>
            <td>{{$list->other_mobile}}</td>
            <td>{{count($list->getCompany)}}</td>
            <td>{{count($list->getEmployee)}}</td>
            <td>{{$list->address}}</td>
            <td>
                @if($list->status==1)
                    <img src="{{ my_asset('images/activate.png') }}">
                @else
                    <img class="change_status"   src="{{my_asset('images/deactivate.png')}}">
                @endif
            </td>

        </tr>

        @endforeach
        @endif
      </tbody>
    </table>
</div>

  </div>
  <div class="box-footer text-center">
    <a href="{{route('portal')}}" class="uppercase">View All </a>
  </div>
</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
  jQuery('.date-own').datepicker({
      minViewMode: 2,
      todayHighlight: true,
      format: 'yyyy'
  });
</script>
@endsection
