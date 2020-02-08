@extends('layout.app')
@section('title')
<div class="page-title">
  <div>
    <h1><i class="fa fa-dashboard"></i>&nbsp;Vendor Dashboard</h1>
  </div>
  <div>
    <ul class="breadcrumb">
      <li><a href="{{route('vendor.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>

    </ul>
  </div>
</div>
@endsection
@section('content')
@include('includes.msg')




@endsection
@section('script')

@endsection
