@extends('layout.app')
<!-- <link rel="stylesheet" type="text/css" href="{{ my_asset('css/custom.css') }}">  -->
@section('content')

<div class="page-title">
  <div>
    <h1><i class="fa fa-tag"></i>&nbsp;Leave</h1>
  </div>
  <div>
    <ul class="breadcrumb">

      @if(Auth::user()->user_type=='portal')
	    <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>

        @endif
		<li><a href="#">Leave List</a></li>

    </ul>
  </div>
</div>
<div class="row">
	@include('includes.msg')
	@include('includes.validation_messages')
</div>

		<div class="row">
					<div class="col-md-12">
						<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModalleave">
							Add New Leave Type&nbsp;<i class="fa fa-plus"></i>
							 </a>
					<div >
					<div class="col-md-12">
						  <div class="content-section">

							<div class="modal fade" id="myModalleave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
											<h5 class="modal-title"><i class="fa fa-plus"></i>&nbsp;Leave</h5>
										</div>
										<div class="modal-body">
											<div class="form portlet-body ">
												<form action="{{route('employeeleavetype.store')}}" method="post">
													{{csrf_field()}}
													<div class="form-group is-empty">
														<div class="row">
															<input type="hidden" class="portal_id" name="portal_id" value=" {{$portal->id}}">
															<div class="col-md-12 col-sm-12" style="margin-bottom: 10px;">
																<input typet="text" class="form-control" name="leave_type" id="leavemaster" placeholder="Leave Type" required="">
																<span id="error_leave"></span>
															</div>

															<div class="col-md-12 col-sm-12">
																<input typet="text" class="form-control numeric" name="no_of_leaves" placeholder="Number of leaves in a year" required="">
															</div>
														</div>
													</div>
													<div class="form-actions">
														<div class="row">
															<div class="col-md-12" style="text-align: center;">
																<button type="submit" class="btn btn-primary" id="LeaveMasters"><i class="fa fa-check">&nbsp;Submit</i></button>
															</div>
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div id="content">
								<div class="portlet box blue">
									<div class="portlet-title">

										<div class="clearfix"></div>
										<div class="tools">
										</div>
									</div>

									<div class="portlet-body">

										<div class="modal fade" id="edit_leave_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
														<h5 class="modal-title"><i class="fa fa-edit"></i> Edit LeaveTypes</h5>
													</div>
													<div class="modal-body">
														<div class="form portlet-body ">
															<form action="{{route('employeeleavetype.update')}}" method="post">
																<div class="form-group is-empty">
																	{{csrf_field()}}
																	<div class="row">
																		<input type="hidden" name="update_id" class="update_id">
																		<input type="hidden" name="portal_id" class="auth" value="{{$portal->id}}">
																		<div class="col-md-12 col-sm-12" style="margin-bottom:10px;">
																			<input typet="text" class="form-control leave_type leave_type " id="leave_types" name="leave_type" placeholder="Enter Leave Type" required="">

																		</div>
																		<div class="col-md-12 col-sm-12">
																			<input typet="text" class="form-control no_of_leaves numeric" id="no_of_leaves" name="no_of_leaves" placeholder="Enter no of leave" required="">
																			<span id="leave_typeerr"></span>
																		</div>
																	</div>
																</div>
																<div class="form-actions">
																	<div class="row">
																		<div class="col-md-12" style="text-align:center;">
																			<button type="submit" id="update"class="btn btn-primary"><i class="fa fa-edit">Update</i></button>
																		</div>
																	</div>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal fade" id="delete_leave_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
														<span class="caption-subject font-red-sunglo bold uppercase">Confirmation</span>
													</div>
													<div class="modal-body" id="info">Are you sure ! You want to delete?</div>
													<div class="modal-footer">
														<form action="{{route('employeeleavetype.delete')}}" method="post">
															{{csrf_field()}}
															<input type="hidden" name="delete_id" class="delete_id">
															<button type="button" data-dismiss="modal" class="btn default">Cancel</button>
															<button type="submit"  class="btn btn-danger" id="delete"><i class="fa fa-trash"></i> Delete</button>
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="table-responsive">
										<table class="table table-bordered  search-table">
											<thead>
												<tr class="btn-primary-th">
													<th>#</th>

													<th>Leave</th>
													<th>Number of Leaves</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<input type="hidden" name="" value="{{$i=1}}">

												<tr>
													@foreach($leave_list as $data)
													<td>{{$i++}}</td>

													<td>{{$data->leave_type}}</td>
													<td>{{$data->number_of_leaves}}</td>
													<td>
														<a class="btn purple EditLeave" href="#" data-toggle="modal" data-leave_name="{{$data->leave_type}}" data-leave_id="{{$data->id}}" data-no_of_leave="{{$data->number_of_leaves}}"><i class="fa fa-edit"></i> View/Edit</a>
														<a class="btn btn-danger deleteLeave" href="#" data-toggle="modal" data-leave_id="{{$data->id}}"><i class="fa fa-trash"></i> Delete </a>
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
	    jQuery('.EditLeave').on('click',function () {
	    	var update_id = jQuery(this).data('leave_id');
	    	var leave_name = jQuery(this).data('leave_name');
	    	var no_of_leave = jQuery(this).data('no_of_leave');
	        jQuery('.update_id').val(update_id);
	        jQuery('.leave_type').val(leave_name);
	        jQuery('#no_of_leaves').val(no_of_leave);
	        jQuery('#edit_leave_modal').modal('show');
	    });
	});
	jQuery(document).ready(function(){
	    jQuery('.deleteLeave').on('click',function () {
	    	var delete_id = jQuery(this).data('leave_id');
	        jQuery('.delete_id').val(delete_id);
	        jQuery('#delete_leave_modal').modal('show');
	    });
	});


//
//store leave
jQuery(document).ready(function(){

$('#leavemaster').on('change',function(){
  var error_leave = '';
  var leavemaster = $('#leavemaster').val();
  var portal_id=$('.portal_id').val();


   $.ajax({
    url:APP_URL+'/portal/employee/check/'+leavemaster+'/'+portal_id,
    type:"get",
	data:{},
    success:function(result)
    {
     if(result == 'unique')
     {
	      $('#error_leave').html('<label class="text-success">leave type Available</label>');
	      $('#leavemaster').removeClass('has-error');
	      $('#LeaveMasters').attr('disabled', false);
     }
     else
     {
	      $('#error_leave').html('<label class="text-danger">leave_type already Exists</label>');
	      $('#leavemaster').addClass('has-error');
	      $('#LeaveMasters').attr('disabled', 'disabled');
	     }
    }
   })
 });
});




//for edit leave
jQuery(document).ready(function(){
 	jQuery('#leave_types').on('change',function(){
  var leave_typeerr = '';
  var leave_types = jQuery('#leave_types').val();
  var no_of_leave=$('.no_of_leaves').val();

   $.ajax({
   			url:APP_URL+'/portal/employee/checkleave/'+leave_types +'/'+no_of_leave,
			type:"get",
			data:{},
    success:function(result)
    {
     if(result == 'unique')
     {
	      jQuery('#leave_typeerr').html('<label class="text-success">leave type Available</label>');
	      jQuery('#leave_types').removeClass('has-error');
	      jQuery('#update').attr('disabled', false);
     }
     else
     {
	      jQuery('#leave_typeerr').html('<label class="text-danger">leave_type already Exists</label>');
	      jQuery('#leave_types').addClass('has-error');
	      jQuery('#update').attr('disabled', 'disabled');
	     }
    }
   })
 });

});

  $('.numeric').keypress(function (event) {
    var keycode = event.which;
    if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
        event.preventDefault();
    }
});







	</script>

@endsection
