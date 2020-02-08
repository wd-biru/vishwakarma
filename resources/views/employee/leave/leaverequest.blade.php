@extends('layout.app')
@section('content')

<div class="page-title">
  <div>
	<h1><i class="fa fa-dashboard"></i>&nbsp;Leave Request</h1>
  </div>
  <div>
	<ul class="breadcrumb">
	  <li><a href="{{route('employee.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
	  <li><a href="#">Request Leaves</a></li>
	</ul>
  </div>
</div>

<div class="row">
	@include('includes.msg')
	@include('includes.validation_messages')
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"  >
				<h3 class="panel-title">Request leaves 
					<a class="pull-right" href="{{route('employee.applyleave')}}">&nbsp;&nbsp;<u>Apply Here</u>&nbsp;</a>  
					<a class="pull-right" href="{{route('employee.leave.myLeave')}}">&nbsp;<u>My Leave</u>&nbsp;&nbsp;</a> </h3>
			</div>
			<div class="panel-body">
				<div class="row">
					
						<div class="col-md-12">
							<table class="table">
								<thead>
									<tr>
										<th>Employee ID</th>
										<th>Reporting To Employee</th>
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
											
										<td>{{$data->employee_id}}</td>
										<td>{{$data->getReportingEmp->first_name}} {{$data->getReportingEmp->last_name}}</td>
										<td>{{Carbon\Carbon::parse($data->start_date)->format('d/m/Y')}}</td>
										<td>{{Carbon\Carbon::parse($data->end_date)->format('d/m/Y')}}</td>
										<td>{{$data->getLeaveType->leave_type}}</td>
										<td>{{$data->reason}}</td>
										<td>{{$data->no_of_day}}</td>
										<td><span class="lable btn-success">{{$data->status}}</span></td>
										
									<!-- 	<td><a href="{{route('employee.leave.request.store',$data->id)}}">
											<button class="btn btn-primary" id="submit" type="submit">Update</button></a></td> -->
											<td>
											 <!-- <button class="addco btn btn-primary" data-toggle="modal" data-target="#myModalDepartment" title="update">update</button> -->
											 <button class="ShowCostModal btn btn-primary"  data-leave_id="{{$data->id}}" 
               data-employee_name="{{$data->getEmployee->first_name}} {{$data->getEmployee->last_name}}" data-activ_status="{{$data->status}}">Update</button></li>
               
											</td>
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

<div class="modal fade" id="myModalDepartment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
            <h4 class="modal-title" id="myModalLabel">Leave Status update</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <form class="form-horizontal" action="{{route('employee.leave.request.store')}}" method="post" id="storedepartment">
                      {{csrf_field()}}
                        <input type="hidden" name="leave_id" class="update_leave_id">
                      <div class="form-group">
                        <label class="control-label col-md-4">Employee Name</label>
                        <div class="col-md-8">
                          <input class="form-control employee_name " autocomplete="false" type="text" name="employee_name"  placeholder="Enter employeee name" disabled="disabled">
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-4">Status</label>
                        <div class="col-md-8">
					                          <select type="text" class="form-control Status"  name="status">
																		             @foreach($leave_status as $status)
																		              <option value="{{ $status->status}}">{{ $status->status}}</option>
																		              @endforeach
					            																</select>
					                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8 subpadding">
                          <input class="btn btn-primary" type="submit"  value="submit" >
                   
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>

        


@endsection



@section('script')

<script type="text/javascript">

	$(document).ready(function () {
		$(".datepicker").datepicker({
			autoclose: true,
			todayHighlight: true,
			format: 'dd/mm/yyyy'


		});
		$(".datepicker").on("change",function(){
        var selected = $(this).val();//alert(selected);


        $(".datepickernew").datepicker({
        	minDate: selected,
        	autoclose: true,
        	todayHighlight: true,
        	format: 'dd/mm/yyyy',
        });
    });
	});
	jQuery(document).ready(function(){
		$('.numeric').keypress(function (event) {
			var keycode = event.which;
			if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
				event.preventDefault();
			}
		});
	});
</script>
<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('.ShowCostModal').on('click',function(){
     jQuery('.update_leave_id').val(jQuery(this).data('leave_id')); 
      jQuery('.employee_name').val(jQuery(this).data('employee_name'));
      jQuery('.Status').val(jQuery(this).data('activ_status'));
      jQuery('#myModalDepartment').modal('show');
    });
  });
</script>

@endsection


