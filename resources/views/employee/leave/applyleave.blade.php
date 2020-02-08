@extends('layout.app')
<!-- <link rel="stylesheet" type="text/css" href="{{ my_asset('css/custom.css') }}">  -->
@section('content')
<div class="page-title">
	<div>
		<h1><i class="fa fa-dashboard"></i>&nbsp;Apply&nbsp;Leave </h1>
	</div>
	<div>
		<ul class="breadcrumb">
			<li><a href="{{route('employee.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
			<li><a href="#">Leave</a></li>
		</ul>
	</div>
</div>

<div class="row">
	@include('includes.msg')
	@include('includes.validation_messages')
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"  >
				<h3 class="panel-title">Apply Here 
				 <a class="pull-right" href="{{route('employee.leave.myLeave')}}">&nbsp;&nbsp;<u>My Leave</u>&nbsp;</a>  
				 <a class="pull-right" href="{{route('employee.leave.request')}}">&nbsp;<u>Leave Requests</u>&nbsp;&nbsp;</a> </h3>

				
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						<form id="myform"class="form-horizontal" action="{{route('employee.applyleaves.store')}}" method="post">
							{{csrf_field()}}
							<input type="hidden" name="portal_id" value="{{$portal->portal_id}}">
							<input type="hidden" name="employee_id" value="{{$portal->id}}">
							<div class="form-group">
								<label class="col-md-4 control-label">Leave Category<span style="color: red;" class="required">*</span></label>
								<div class="col-md-8">
									<select class="form-control" name="leave_id">
										@foreach($leaves as $leave)
										<option value="{{$leave->id}}">{{$leave->leave_type}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group is-empty is-fileinput">
								<label class="col-md-4 control-label">Start Date<span style="color: red;" class="required">*</span></label>
								<div class="col-md-8" id="datepicker">
									<input type="text" name="start_date" required="" id="datepicker1" class="form-control ">
								</div>
							</div>
							<div class="form-group is-empty is-fileinput">
								<label class="col-md-4 control-label">End Date<span style="color: red;" class="required">*</span></label>
								<div class="col-md-8" id="datepicker">
									<input type="text" name="end_date" required="" id="datepicker2" class="form-control ">
								</div>
							</div>
							
							<div class="form-group is-empty">
								<label class="col-md-4 control-label">Reason<span style="color: red;" class="required">*</span></label>
								<div class="col-md-8">
									<textarea class="form-control" name="reason" rows="3" required=""></textarea>
								</div>
							</div>
							<div class="form-group is-empty is-fileinput">
								<label class="col-md-4 control-label">No. Of Day<span style="color: red;" class="required">*</span></label>
								<div class="col-md-8">
									<input type="text" name="no_days"  class="form-control numeric" value="">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-4">
									<input type="submit" id="submit" class="btn btn-success" style="background: #131257;">
								</div>
							</div>
						</form>
					</div>
					<div class="col-md-4">
						<div class="panel panel-custom">
							<!-- Default panel contents -->
							<div class="panel-heading" style="border-bottom: 1px solid #131257;">
								<div class="panel-title">
									<strong>My Leave Details</strong>
								</div>
							</div>
							<table class="table">
								<tbody>
									@foreach($leaves as $leave)
									<tr>
										<td><strong>{{$leave->leave_type}}</strong>:</td>
										<td>{{$leave->number_of_leaves}}</td>
										</tr>

										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>




			</div>
		</div>
	</div>
 


@endsection


@section('script')

<script type="text/javascript">
jQuery(document).ready(function(){
	$('.numeric').keypress(function (event) {
		var keycode = event.which;
		if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
			event.preventDefault();
		}
	});	
});

 
jQuery(document).ready(function(){
   	var dateToday = new Date();

	$('#datepicker1').datepicker({                                     
	    'startDate': dateToday,
			autoclose: true,
			numberOfMonths: 2,
			todayHighlight: true,
			format: 'dd/mm/yyyy'
	});
	var dateToday = new Date();
    $("#datepicker2").datepicker({
    	 'startDate': dateToday,
    	numberOfMonths: 2,
    	autoclose: true,
    	todayHighlight: true,
    	format: 'dd/mm/yyyy',
    });
	$("#datepicker2").change(function () {
	    var final = $("#datepicker2").datepicker("getDate");    
	    var start = $("#datepicker1").datepicker("getDate");
	    var days = new Date((final-start));
	    var day=(days/86400000);
	    if(day<0 )    {
	    	$('.numeric').val('Invalid date Selected');
	    	$('#submit').attr('disabled','disabled');
	    }else if((Math.abs(days/86400000))>=0)    {
			var day=Math.abs(days/86400000)+1;
		    if(day>120){
		    	alert("Date of Leave is Exceed from Limit");
		    	$('.numeric').val('Your Leave Limit Exceed');
				$('#submit').attr('disabled','disabled');
		    }else {
			   $('.numeric').val(day);
			   $('#submit').removeAttr('disabled');
			}
		}
	});
});

 
$(document).ready(function(){
  $('#myform').on('submit',function(){
		$("#submit").attr('disabled',true);
	});
	$("#submit").attr('disabled',false);
});		
		
		
</script>
@endsection
