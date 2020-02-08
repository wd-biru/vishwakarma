@extends('layout.app')@section('title')
<div class="page-title">
  <div>
    <h1><i class="fa fa-dashboard"></i>&nbsp;Portal Dashboard</h1>
  </div>
  <div>
    <ul class="breadcrumb">
      <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>

    </ul>
  </div>
</div>
@endsection
@section('content')
@include('includes.msg')


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

<?php
$companies = Auth::user()->getPortal->getCompany->sortByDesc('created_at');



?>
<div class="row">
  <div class="col-lg-4 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <div class="inner-box">
          <h3>{{count(Auth::user()->getPortal->getCompany)}}</h3>
        </div>
        <p class="order" style="float: right;"><b>Clients</b></p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="{{route('company')}}" class="small-box-footer" style="font-size:14px;color: black;">More info
        <i class="fa fa-arrow-circle-right" style="color:green;"></i>
      </a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <div class="inner-box" style="background-color: #ecb442;">
          <h3>{{count(Auth::user()->getPortal->getEmployee)}}</h3>
        </div>
        <p class="order" style="float: right;"><b>Employess</b></p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="{{route('companyemployee')}}" class="small-box-footer" style="font-size:14px;color: black;">More info
        <i class="fa fa-arrow-circle-right" style="color:#ecb442;"></i>
      </a>
    </div>
  </div>
  <!-- ./col -->

  <!-- ./col -->
  <div class="col-lg-4 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <div class="inner-box" style="background-color: #ff5252;">
          <h3>{{$countValue}}</h3>
        </div>
        <p class="order" style="float: right;"><b>Projects</b></p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="{{ route('projects.index') }}" class="small-box-footer" style="font-size:14px;color: black;">More info
        <i class="fa fa-arrow-circle-right" style="color:#ff5252"></i>
      </a>
    </div>
  </div>
  <!-- ./col -->
</div>


<div class="row">
  <div class="col-md-12">
    <div class="box-header with-border" style="border-top: 2px solid #b62722;background-color: #fff;  margin-top: 10px;">
      <h3 class="box-title">Client List</h3>
    </div>
    <div class="box-body" style="background-color:#fff;">
<div class="table-responsive" >
      <table class="table" id="search2">
       <thead>
         <tr style="font-size: 14px;">
            <th>Sr. No</th>
            <th>Client Name</th>
            <th>Status</th>
         </tr>
       </thead>
       <tbody>
         <?php $count=0; ?>
         @if($count < 5)

         @foreach($companies as $data)
         <?php
         $count++;
         ?>

         <tr style="font-size: 11px;">
          <td>{{ $count}}</td>
          <td><a href="{{route('companyShow',[base64_encode($data->id)])}}">{{ucfirst($data->Client_name)}}</a></td>
          <td class="table-status">
              @if($data->Status==1)
              <img src="{{ my_asset('images/activate.png') }}">
              @else
              <img class="change_status"  src="{{my_asset('images/deactivate.png')}}">
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
    <a href="{{route('company')}}" class="uppercase">View All </a>
  </div>
</div>
</div>
<div class="row">
<div class="col-md-12">
  <div class="box-header with-border" style="border-top: 2px solid #b62722;background-color: #fff; margin-top: 10px;">
    <h3 class="box-title">Employee List</h3>
  </div>
  <div class="box-body" style="background-color:#fff;">
<div class="table-responsive">

    <table class="table" id="search1" >
     <thead>
       <tr  style="font-size: 14px;">
        <th>Sr. No</th>
        <th>Employee Name</th>
        <th>Contact No.</th>
        <th>Reporting</th>
        <th>Gender</th>
        <th>Other Phone</th>
        <th>Address</th>
        <th>Status</th>
       </tr>
     </thead>
     <tbody>
       <?php $count=0; ?>
       @if($count < 5)
       @foreach($employee_list as $data)
       <?php
       $reporting = App\Models\EmployeeProfile::where('id',$data->reporting_id)->value('first_name');
       $count++;
       ?>

      <tr style="font-size:11px;">
        <td>{{$count}}</td>
        <td><a href="{{route('companyemployeeInfoEdit',[$data->id])}}">{{ucfirst($data->first_name)}} {{ucfirst($data->last_name)}}</a></td>
        <td>{{$data->phone}}</td>
        <td>{{ucfirst($reporting)}}</td>
        <td>{{$data->gender}}</td>
        <td>{{$data->other_phone}}</td>
        <td>{{$data->address}}</td>
        <td class="table-status">
          @if($data->status==1)
            <img src="{{ my_asset('images/activate.png') }}">
          @else
            <img src="{{my_asset('images/deactivate.png')}}">
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
  <a href="{{route('companyemployee')}}" class="uppercase">View All </a>
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

          $('#search1').DataTable({
            "language": {
              "emptyTable": "No data available"
    }
          });

    $('#search2').DataTable({
            "language": {
              "emptyTable": "No data available"
    }
          });


</script>
@endsection
