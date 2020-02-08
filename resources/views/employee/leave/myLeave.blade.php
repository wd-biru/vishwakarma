@extends('layout.app')
@section('content')

<div class="page-title">
  <div>
	<h1><i class="fa fa-dashboard"></i>&nbsp; Leaves</h1>
  </div>
  <div>
	<ul class="breadcrumb">
	 <li><a href="{{route('employee.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
	  <li><a href="#">Leaves</a></li>
	</ul>
  </div>
</div>


<div class="row">
	@include('includes.msg')
	@include('includes.validation_messages')
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading" 	>
				<h3 class="panel-title">leaves 
<a class="pull-right"  href="{{route('employee.applyleave')}}">&nbsp;&nbsp;<u>Apply Here</u>&nbsp;</a><a class="pull-right" href="{{route('employee.leave.request')}}">&nbsp;<u>Leave Requests</u>&nbsp;&nbsp;</a> 
				</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<table class="table">
							<thead>
								<tr>
									<th>Start Date</th>
									<th>End Date</th>
									<th>Leave Category</th>
									<th>Reason</th>
									<th>Days</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
									@foreach($leave_data as $data)
								<tr>
									<td>{{Carbon\Carbon::parse($data->start_date)->format('d/m/Y')}}</td>
									<td>{{Carbon\Carbon::parse($data->end_date)->format('d/m/Y')}}</td>
									<td>{{$data->getLeaveType->leave_type}}</td>
									<td>{{$data->reason}}</td>
									<td>{{$data->no_of_day}}</td>
									<td><span class="lable btn-success">{{$data->status}}</span></td>
									@if($data->is_active==1)
									<td>
										<a href="" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="View"><i class="fa fa-edit"></i></a>
									</td>
									@else
									<td></td>
									@endif
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
				

@endsection