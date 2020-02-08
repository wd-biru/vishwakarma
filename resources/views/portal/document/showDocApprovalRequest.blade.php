@extends('layout.app')
@section('content')

<div class="page-title">
	<div>
		<h1><i class="fa fa-dashboard"></i>&nbsp;Document Approval Request</h1>
	</div>
	<div>
		<ul class="breadcrumb">
		  <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
		  <li><a href="#"> Approval Request </a></li>
		</ul>
	</div>
</div>
<!-- Search Bar -->
<div class="row" >
	<div class="col-md-12" style="">
		<div class="col-md-12 search-top-section">
			<div class="col-md-1">
				<div style="margin-top: 8px;" class="search-heading">
					<h3 >Search</h3>
				</div>
			</div>
			<div class="col-md-5 top_search">
				<div class="input-group" style="margin-top: 8px;">
					<input type="text" class="form-control" placeholder="Search for...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Go!</button>
					</span>
				</div>
			</div>
			<div class="col-md-2">

			</div>
			<div class="col-md-4 ">
				<a class="btn btn-success pull-right" style="margin-top: 8px;" href="{{route('documentManagemet.documentShareWithMe')}}">Documents</a>
				<a class="btn btn-primary pull-right" style="margin-top: 8px;margin-right: 10px;"  href="{{route('documentManagemet.index')}}">Upload Document</a>			
			</div>
		</div>
	</div>
</div>
<!-- End Search Bar -->
<input type="hidden" id="portal"name="portal_id" value="">
<div class="row">
	@include('includes.msg')
	@include('includes.validation_messages')
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">All Document Approval Request Here</h3></div>
			<div class="panel-body">
				<div class="row">
										<div class="col-md-12" style="margin-left: 20px;">

						@if(!empty($document))
						@foreach($document as $docs)
						@if($docs->status == "APPROVED")
						<div class="col-md-2 document-type" style="    padding-bottom: 8px;background-color: #168e4c;">
						@elseif($docs->status == "PENDING")
						<div class="col-md-2 document-type" style="    padding-bottom: 8px;background-color: #e8a817;">
						@else
						<div class="col-md-2 document-type" style="    padding-bottom: 8px;background-color: #f13737;">
						@endif
						<div class="box box-primary">
							<?php
                                $ext = pathinfo($docs->doc_file, PATHINFO_EXTENSION);
                                ?>
            <div class="box-body box-profile">
            	@switch($ext)
				    @case('xlsx')
				        <img class="profile-user-img img-responsive img-circle" style="    height: 55px;margin: 0 auto;" src="{{my_asset('images/file-images/xlsx.png')}}" alt="File xlsx Image">
				        @break
				    @case('pdf')
				        <img class="profile-user-img img-responsive img-circle" style="    height: 55px;     margin: 0 auto;" src="{{my_asset('images/file-images/pdf.png')}}" alt="File pdf Image">
				        @break
				    @case('docx')
				        <img class="profile-user-img img-responsive img-circle" style="    height: 55px;     margin: 0 auto;" src="{{my_asset('images/file-images/doc.png')}}" alt="File doc Image">
				        @break
				    @case('csv')
				        <img class="profile-user-img img-responsive img-circle" style="    height: 55px;     margin: 0 auto;" src="{{my_asset('images/file-images/csv.png')}}" alt="File csv Image">
				        @break
				    @case('txt')
				        <img class="profile-user-img img-responsive img-circle" style="    height: 55px;     margin: 0 auto;" src="{{my_asset('images/file-images/txt.png')}}" alt="File txt Image">
				        @break
				    @default
				    	<img class="profile-user-img img-responsive img-circle" style="    height: 55px;     margin: 0 auto;"  src="{{my_asset('images/file-images/default.png')}}" alt="File txt Image">
				    	@break
				@endswitch
              <!-- <img  src="../../dist/img/user4-128x128.jpg" alt="User profile picture"> -->

              <h3 class="profile-username text-center" style=" color: #fff;   font-size: 15px;">{{$docs->doc_name}}</h3>

              <p class="text-muted text-center" style=" color: #fff;">{{$docs->doc_description}}</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item" style="font-size: 10px;">
                  <b>Upload BY</b> <a class="pull-right">{{$docs->upload_by}}</a>
                </li>

              </ul>
              <div class="btn-group" style="    width: 100%;">
                      <a type="button" class="btn btn-primary ShowActionModal" data-doc_id="{{$docs->id}}"
               data-doc_name="{{$docs->doc_name}}" data-activ_status="{{$docs->status}}" class="btn btn-primary"  style="    width: 70%;
    display: inline-block;    background-color: #013366;
    border-color: #013366;">Action</a>
                      <a type="button" class="btn btn-primary" href="{{url('public/storage/uploads/document')}}/{{$docs->doc_file}}" target="_blank" download style="    width: 30%;
    display: inline-block;    background-color: #013366;
    border-color: #013366;"><i style="size: 24px;" class="fa fa-download"></i></a>
                    </div>

            </div>
            <!-- /.box-body -->
          </div>

						</div>
						@endforeach
						@endif



					</div>
				</div>
			</div>


				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="myModalAction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
            <h4 class="modal-title" id="myModalLabel">Document Status update</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <form class="form-horizontal" action="{{route('documentManagemet.update')}}" method="post" id="storedepartment">
                      {{csrf_field()}}
                        <input type="hidden" name="doc_id" class="update_doc_id">
                      <div class="form-group">
                        <label class="control-label col-md-4">Document Name</label>
                        <div class="col-md-8">
                          <input class="form-control doc_name " autocomplete="false" type="text" name="employee_name"  placeholder="Enter employeee name" disabled="disabled">
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-4">Status</label>
                        <div class="col-md-8">
					   <select type="text" class="form-control Status" name="status">
					  <option value="PENDING">PENDING</option>
					    <option value="APPROVED">APPROVED</option>
					    <option value="REJECTED">REJECTED</option>
					  </select>
					  </div>
					  </div>
					  <br>
					 <div class="form-group">
								<label class="col-md-4 control-label">Note/Remark</label>
								<div class="col-md-8">
									<textarea class="form-control" id="Remark" name="remark_approve"  rows="4" disabled="disabled"></textarea>
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
	  jQuery(document).ready(function(){
	  jQuery('.ShowActionModal').on('click',function(){
	  jQuery('.update_doc_id').val(jQuery(this).data('doc_id'));
      jQuery('.doc_name').val(jQuery(this).data('doc_name'));
      jQuery('.Status').val(jQuery(this).data('activ_status'));

      jQuery('#myModalAction').modal('show');
    });

  });
	  jQuery(document).ready(function(){
	  jQuery('.Status').on('change',function(){
	  	var status=$('.Status').val();

	  	if(status=='REJECTED')
	     {
	  		$('#Remark').removeAttr('disabled');
	  		$('#Remark').attr('required','true');
	     }

	  	else if(status=='APPROVED')
	  	{
	  		$('#Remark').removeAttr('disabled');
	  		$('#Remark').removeAttr('required');
	  	}

	  });
	});
</script>

@endsection
