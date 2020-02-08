@extends('layout.app')
@section('content')
<div class="page-title">
  <div>
	<h1><i class="fa fa-dashboard"></i>&nbsp;Upload&nbsp;Document</h1>
  </div>
  <div>
	<ul class="breadcrumb">
	 <li><a href="{{route('employee.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
	  <li><a href="#">Upload&nbsp;Document</a></li>
	</ul>
  </div>
</div>



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
				<button id="btnClear" class="btn btn-danger btn-md center-block pull-left" data-toggle="modal" data-target="#myModal" style="width: 108px;display: inline-block;background-color: #337ab7;margin-top: 8px;border-color: #337ab7;float: right;" onclick="btnClear_Click">Upload&nbsp;<i class="fa fa-cloud-upload"></i></button>
			</div>
			<div class="col-md-4 ">
				<a class="btn btn-success pull-right" style="margin-top: 8px;" href="{{route('employeedocument.documentShareWithMe')}}">Documents</a>
				<a class="btn btn-info pull-right" style="margin-top: 8px;" href="{{route('employeedocument.show')}}">Approval Request</a>			
			</div>						
		</div>
	</div>
</div>


<div class="row">
	@include('includes.msg')
	@include('includes.validation_messages')
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Uploaded Document</h3>
			</div>
			
			<div class="search-section">
				<div class="row">
					<div class="col-md-12">
						<div class="">
						</div>
					</div>
				</div>
			</div>
			
			<div class="panel-body">
				<div class="row">				
					<div class="col-md-12" style="margin-left: 20px;">
						@if(!empty($documentshare))
						@foreach($documentshare as $docs)
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
                <li class="list-group-item" style="    font-size: 10px;">
                	<b>For Approval</b>
                	@if($docs->for_approval==0)
                	<?php $portal=App\Models\Portal::where('id',$docs->portal_id)->first(); ?>
                   <a class="pull-right">{{$portal->name}} {{$portal->surname}}</a>
                  @else
                 
                 <a class="pull-right">{{$docs->getApproval->first_name}} {{$docs->getApproval->last_name}}</a>
                  @endif
                </li>
                
              </ul>
              <div class="btn-group" style="    width: 100%;">
                      <a type="button" class="btn btn-primary showSharesList" data-doc_id="{{$docs->id}}"" data-doc_name="{{$docs->doc_name}}" class="btn btn-primary"  style="    width: 70%;
    display: inline-block;    background-color: #013366;
    border-color: #013366;">Share list</a>
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
  
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      	<div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	          	<h4 class="modal-title" style="text-align: center;color: black;">Upload Document</h4>
	        </div>
			<form class="form-horizontal form-label-left" id="DocumentDetails" class="form-horizontal" action="{{route('employeedocument.store')}}" method="post" enctype="multipart/form-data">
				{{csrf_field()}}
				<input type="hidden" name="portal_id" value="{{$employee->portal_id}}">
				<input type="hidden" name="employee_id" value="{{$employee->id}}">
		        <div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
		                        <label class="control-label col-md-4 col-sm-4 col-xs-12" style="font-weight: 100;">Document Name<span class="required" style="color:red;">*</span></label>
		                        <div class="col-md-8 col-sm-8 col-xs-12">
		                          	<input type="text" name="doc_name" id="doc_name" value="{{old('doc_name')}}" class="form-control " required/>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="control-label col-md-4 col-sm-4 col-xs-12" style="font-weight: 100;">Document Upload</label>
		                        <div class="col-md-8 col-sm-8 col-xs-12">
									<input type="file" name="doc_file" id="doc_file" class="form-control " value="{{old('doc_file')}}" required>	
		                    	</div>
		                    </div>
		                    
		                    	
		                    <div class="form-group">
								<div class="" id="needToApprove">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" style="font-weight: 100;">Need To Approve</label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="checkbox" name="needtoapprove" id="needtoapprove">
									</div>
								</div>
							</div>  
							<div class="form-group " id="Approved">
								<label class="col-md-4 control-label">For Approval</label>
								<div class="col-md-8">
									<select class="form-control" name="for_approval_emp_id">
										<option value="">------ select ------</option>
										<option value="0">{{$portal->name}}{{$portal->surname}}</option>
										@foreach($data as $value)
										<option value="{{ $value->id}}">{{$value->first_name}}{{$value->last_name}}</option>
										@endforeach
									</select>
								</div>
							</div>                   
		                    <div class="form-group">
		                        <label class="control-label col-md-4 col-sm-4 col-xs-12" style="font-weight: 100;">Share With <span class="required" style="color:red;">*</span></label>
		                        <div class="col-md-8 col-sm-8 col-xs-12">
									<select class="form-control tags"  name="doc_share[]" multiple required >
										<option value="0">{{$portal->name}}{{$portal->surname}}</option>
										@foreach($empdetails as $list)
										<option value="{{$list->id}}">{{$list->first_name}}</option>
										@endforeach
									</select>                         
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="control-label col-md-4 col-sm-4 col-xs-12" style="font-weight: 100;">Date<span class="required" style="color:red;">*</span></label>
		                        <div class="col-md-8 col-sm-8 col-xs-12">
		                          <input type="text" name="upload_date" id="datepicker1" value="{{old('doc_description')}}" class="form-control " required>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="control-label col-md-4 col-sm-4 col-xs-12" style="font-weight: 100;">Document Description<span class="required" style="color:red;">*</span></label>
		                        <div class="col-md-8 col-sm-8 col-xs-12">
		                          <input type="text" name="doc_description" id="doc_description" value="{{old('doc_description')}}"class="form-control " required>
		                        </div>
		                    </div>
		                    
		                    <div class="form-group">
		                        <label class="control-label col-md-4 col-sm-4 col-xs-12" style="font-weight: 100;">Note/Remark</span>
		                        </label>
		                        <div class="col-md-8 col-sm-8 col-xs-12">
		                          <textarea class="form-control" value="{{old('remark_upload')}}" name="remark_upload" rows="4"></textarea>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		        <div class="modal-footer">
		          	<div class="form-group">
		                <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
		                  	<button type="submit" class="btn btn-success" style="background: #1a3d5c;border: 1px solid #1a3d5c;">Submit</button>
		                </div>
		            </div>
	        	</div> 
	        </form>					
	    </div>      
    </div>      
</div>

<!--  Share List -->
<div class="modal fade" id="shareDataModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<span class="caption-subject font-red-sunglo bold uppercase" >Share List</span>
			</div>
			<div class="modal-body">
				<input type="text" disabled="" class="form-control" name="document_name" value="" id="document_name">
				<br>
				<div id="SharedTable">
					<!-- SHARED LIST DATA -->
				</div>
			</div>
			<div class="modal-footer">				
			</div>
		</div>
	</div>
</div>
<!-- End Share List -->


<!-- Document Detail -->
<div class="modal fade" id="shareDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<span class="caption-subject font-red-sunglo bold uppercase" >Document Details</span>
			</div>
			<div class="modal-body">
				<div id="DocTable">
					<!-- Docs Detail Data -->
				</div>				
			</div>	
			<div class="modal-footer">				
			</div>		
		</div>
	</div>
</div>
<!-- End Document Detail -->



@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<script type="text/javascript">
jQuery(function(){
	var vil={
		init:function(){
			vil.select();
			//.vil.EmployeeOtherDetails();
			$('.numeric').keypress(function (event) {
				var keycode = event.which;
				if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
					event.preventDefault();
				}
			});	
		},
		select:function(){
			jQuery('.tags').select2({
				tags: true,
				tokenSeparators: [','],
				placeholder: "Share Document With"
			});
		},
    }
    vil.init(); 
});

$(document).ready(function(){
	var dateToday = new Date();

	$('#datepicker1').datepicker({                                     
		'startDate': dateToday,
		autoclose: true,
		numberOfMonths: 2,
		todayHighlight: true,

	});
});
jQuery(document).ready(function(){
	$('#Approved').hide();
	$('#needtoapprove').on('click',function(){	

		if (this.checked) {
			this.setAttribute("checked", "checked");
			$('#Approved').show();
		} else {
			this.removeAttribute("checked");
			$('#Approved').hide();
		}
		snippet.log(this.parentNode.innerHTML);
	});
});

$(document).ready(function(){
	$('#myform').on('submit',function(){
		$("#submit").attr('disabled',true);
	});
	$("#submit").attr('disabled',false);
});		

</script>

<script type="text/javascript">	
    jQuery(document).on('click','.showSharesList',function(){
        var doc_id = jQuery(this).data('doc_id');
        var doc_name = jQuery(this).data('doc_name');
        jQuery('#document_name').val(doc_name);
        
        jQuery.ajax({
            url:"{{route('getShareListEmp')}}",
            type:"GET",
            data:{doc_id:doc_id},
            dataType:'html',
            success: function(response){ 
                jQuery('#SharedTable').html(response);
                jQuery('.searchTable').DataTable({});
            	jQuery('#shareDataModal').modal('show'); 
            },
            error: function(){
                alert('SERVER NOT RESPONDING') ;
            }
        }); 
       return false;
    });

    jQuery(document).on('click','.showDocDetails',function(){
        var doc_id = jQuery(this).data('doc_id');      
        jQuery.ajax({
            url:"{{route('getDocDetailEmp')}}",
            type:"GET",
            data:{doc_id:doc_id},
            dataType:'html',
            success: function(response){ 
                jQuery('#DocTable').html(response);
            	jQuery('#shareDetailModal').modal('show'); 
            },
            error: function(){
                alert('SERVER NOT RESPONDING') ;
            }
        }); 
       return false;
    });
</script>

@endsection

