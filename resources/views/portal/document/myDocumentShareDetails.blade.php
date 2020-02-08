@extends('layout.app')
@section('content')

<div class="page-title">
  <div>
	<h1><i class="fa fa-dashboard"></i>&nbsp;Employee Document Share Details</h1>
  </div>
  <div>
	<ul class="breadcrumb">
	  <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
	  <li><a href="#">Employee Document Share Details</a></li>
	</ul>
  </div>
</div>

<input type="hidden" id="portal"name="portal_id" value="">
<div class="row">
	@include('includes.msg')
	@include('includes.validation_messages')
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">All Document Share Details</h3></div>
			<div class="panel-body">
				<div class="row">
					
						<div class="col-md-12">
							<table class="table search-table">
								<thead>
									<?php $i=1 ?>

									<tr>
										<th>Sr. No.</th>
										<th>Document Name</th>
										<th>Description</th>
										<th>Upload Date</th>
										<th>Uploaded By</th>
										<th>Status</th>
										<th>Document link</th>
										<th>Share With</th>
										<th>Approval Remark</th>
									</tr>
								</thead>
								<tbody>
									@foreach($documentshare as $data)
									@foreach($documentsharewith as $value)
									@if(($data->id)==($value->doc_share_id)&&($data->portal_id)==($value->portal_id))
									<tr>
										
										<td>{{$i++}}</td>
										<td>{{$data->doc_name}}</td>
										<td>{{$data->doc_description}}</td>
										<td>{{Carbon\Carbon::parse($data->upload_date)->format('d/m/Y')}}</td>
										<td>ADMIN</td>
										@if($data->status=='APPROVED')
												<td style="color: green;">{{$data->status}}</td>
											@elseif($data->status=='REJECTED')
												<td style="color: red;">{{$data->status}}</td>
														@elseif($data->status=='PENDING')
																<td style="color: orange;">{{$data->status}}</td>
										@endif	
											
										<td><a href="{{url('public/storage/uploads/document')}}/{{$data->doc_file}}" target="_blank" download>Click here to download</a></td></td>		
										@if($value->shareEmployee_id==0)
										          <td>{{Auth::user()->name}}</td>
										    @else
										       <td>{{$value->getName->first_name}} {{$value->getName->last_name}}</td>	
										@endif
										@if(empty($data->remark_approve))
										<td></td>	
										@else
										<td>{{$data->remark_approve}}</td>
										@endif
									</tr>
									@endif
								@endforeach
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
	  jQuery('.update_doc_id').val(jQuery(this).data('doc_id')); 
      jQuery('.employee_name').val(jQuery(this).data('employee_name'));
      jQuery('.Status').val(jQuery(this).data('activ_status'));
     
      jQuery('#myModalDepartment').modal('show');
    });  
  });
</script>

@endsection


