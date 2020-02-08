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
        <h1><i class="fa fa-dashboard"></i>&nbsp;Dashboard</h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('employee.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
            <li><a href="#">Dashboard</a></li>
        </ul>
    </div>
</div>
@endsection
@section('content')


<div class="row">
  <div class="col-md-12">
    <div class="box-header with-border" style="border-top: 2px solid #003260;background-color: #fff;  margin-top: 10px;">
      <h3 class="box-title">Client List</h3>
    </div>
    <div class="box-body" style="background-color:#fff;">
      <div class="table-responsive">
      <table class="table search-table">
       <thead>
         <tr style="font-size: 14px;">
            <th>Sr. No</th>
            <th>Client Name</th> 
            <th>Status</th>
         </tr>
       </thead>
       <tbody>
         <?php $count=1; ?>
     
         @foreach($clients as $data)
       

         <tr style="    font-size: 11px;">

          <td>{{ $count++}}</td>
          <td>{{ucfirst($data->Client_name)}}</td> 
          <td>@if($data->Status ==1) Active @else DeActive @endif</td>

        </tr>

        @endforeach
      
      </tbody>
    </table>

</div>
  </div>
 
  </div>
</div>
<br> 



@endsection
