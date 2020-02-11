@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Contract Price</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="#">Contract Price</a></li>
                <li><a href="#">Add</a></li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    @include('includes.msg')
    @include('includes.validation_messages')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
 	<script src="{{URL::to('public/js/dropzone.js')}}"></script>

    <div class="row">
    	<div class="col-md-12">
    		 <div class="panel">
	            <label>
	                <button name="unit_system_no" class="btn btn-primary radio" onclick="window.location.reload();">Mannualy Entry </button>
	            </label> 
	                &nbsp;&nbsp;&nbsp;
	            <label>
	              <button name="unit_system_no" id="upload_contract" class="btn btn-primary radio"> Upload</button>
	            </label> 
        	</div>
    	</div>
    </div>

    <div class="row" id="contractPrice">

        @if(isset($vendor_item_price))

                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">&nbsp;Indent :{{$id}} Price</h3>
                            <h4 class="pull left" style="margin-top: 22px;"><b style="color: red">Note:*</b> Red Box : L1 & Green Box : L2</h4>
                        </div>
                        <div class="panel-body">

                            <div class="card col-md-12">
                                <form action="{{route('storeRentableContract')}}" id="form1" method="POST">
                                    {{ csrf_field() }}

                                    <div class="  table-responsive ">
                                        <table class="table table-bordered main-table">
                                            <thead>
                                            <tr class="t-head">
                                                <th>Sr. No.</th>
                                                <th>Material Name.</th>
                                                <th>Unit.</th>
                                                <th>Quantity.</th>
                                                <th>Per Day Price</th>
                                                <th>Recovery Price</th>

                                            </tr>
                                            </thead>
                                            <tbody><?php $i = 1;?>

                                            @foreach($vendor_item_price as $list)
                                                <tr>

                                                    <input type="hidden" name="updated_id[]" value="{{$list->id}}">
                                                    <td>{{$i++}}</td>
                                                    <input type="hidden" name="indent_id[]"
                                                           value="{{$list->indent_id}}">
                                                    <?php   $item_name = DB::table('vishwa_materials_item')->where('id', $list->item_id)->first();?>
                                                    <td><input type="hidden" name="item_id[]"
                                                               value="{{$list->item_id}}">{{$item_name->material_name}}
                                                    </td>
                                                    <td><input type="hidden" name="unit[]"
                                                               value="{{$list->unit}}">{{$list->unit}}</td>
                                                    <td><input type="hidden" name="qty[]" class="qty"
                                                               value="{{$list->qty}}">{{$list->qty}}</td>

                                                    <td>
                                                        <input class="form-control price priceMax priceMax_{{$list->item_id}}"
                                                               type="number" step="any"  autocomplete="off" name="per_day_price[]"
                                                               data-qty="{{$list->qty}}" data-id="{{$list->item_id}}"
                                                               data-indent_id="{{$list->indent_id}}"
                                                               id="forcolor{{$list->item_id}}"
                                                               data-vendor_id="{{Auth::user()->getVendor->id}}"
                                                               class="form-control price" readonly=""
                                                               @if($getIndentNonPrice->count()>0)
                                                               @foreach($getIndentNonPrice as $val)
                                                               @if($val->item_id == $list->item_id)  value="{{$val->per_day_price}}"
                                                        @endif
                                                        @endforeach
                                                        @endif placeholder="Price" required>
                                                    </td>

                                                    <td><input class="form-control" type="number" autocomplete="off"
                                                               step="any"
                                                               name="recovery_price[]" class="form-control price" readonly=""
                                                               @if($getIndentNonPrice->count()>0)
                                                               @foreach($getIndentNonPrice as $val)
                                                               @if($val->item_id == $list->item_id)  value="{{$val->recovery_price}}"
                                                        @endif
                                                        @endforeach
                                                        @endif placeholder="Tax Rate" required>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                        <br>
                                        <div class="form-group">
                                        	 <label class="control-label col-md-4">Effective Date:&nbsp;<span
                                                        style="color: #f70b0b">*</span></label>
                                        	  <div class="col-md-12">
                                        <input  class="datepicker" autocomplete="off" name="effective_date" id="effective_date" placeholder="Effective Date" style="font-size: 14px;"  required>
                                        </div>
                                    </div>
                                    <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Freight:&nbsp;<span
                                                        style="color: #f70b0b">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" required name="freight"
                                                       id="freight" readonly=""
                                                       required
                                                       @if($getIndentNonPrice->count()>0)
                                                       @foreach($getIndentNonPrice as $val)
                                                       value="{{$val->freight}}"
                                                        @endforeach
                                                        @endif>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Loading/Unloading:&nbsp;<span
                                                        style="color: #f70b0b">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="loading" id="loading"
                                                       required readonly=""
                                                       @if($getIndentNonPrice->count()>0)
                                                       @foreach($getIndentNonPrice as $val)
                                                       value="{{$val->loading}}"
                                                        @endforeach
                                                        @endif>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Kata Parchi Charges:&nbsp;<span
                                                        style="color: #f70b0b">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="kpcharges" id="kpcharges"
                                                       required readonly=""
                                                       @if($getIndentNonPrice->count()>0)
                                                       @foreach($getIndentNonPrice as $val)
                                                       value="{{$val->kpcharges}}"
                                                        @endforeach
                                                        @endif >
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary" style="margin-top: 15px;">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                    
                        </div>
                    </div>
                </div>
   			</div>
     	@endif
	</div>
 

	<div class="container-fluid" style="display: none;" id="upload_contract_view">
	    <div class="row">
	        <div class="col-md-12">
	            <form action ="" class ="dropzone" id="my-awesome-dropzone" method="post" enctype="multipart/form-data">
	                {{ csrf_field() }}
	                <input type="file" name="uploadedDocx" multiple />
	            </form>
	        </div>
	    </div>
	</div>
   
@endsection

@section('script')

    <script type="text/javascript">
       
        $(document).ready( function() {
            $('#effective_date').datepicker({
                format:"dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
            });
           
        });

		$("#upload_contract").click(function () {
			$("#upload_contract_view").show();
			$("#contractPrice").hide();
		});


    </script>

@endsection




















