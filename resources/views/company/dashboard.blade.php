@extends('layout.app')
@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;Company Dashboard</h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><i class="fa fa-home fa-lg"></i></li>
            <li><a href="#">Company Dashboard</a></li>
        </ul>
    </div>
</div>
@endsection
@section('content')
@include('includes.msg')

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
