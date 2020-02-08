@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-gear" aria-hidden="true"></i></i>&nbsp;Services Masters</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('master.service')}}">Services list</a></li>
                <!-- <li><a href="#">list</a></li> -->
            </ul>
        </div>
    </div>
@endsection
@section('content')
@include('includes.msg')
@include('includes.validation_messages')


  <div class="col-md-12">
      <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> Services list</h3>
            </div>



            <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                  <a data-toggle="modal" data-target="#myModalServicesAdd" class="btn btn-primary pull-right"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add </a>
                </div>
              </div>
              <div class="clearfix"></div>
              <br>
            <div class="  table-responsive ">
                <table class="table table-bordered main-table search-table " >
                    <thead>
                        <tr class="t-head">
                            <th>Sr No.</th>
                            <th>Service Name</th>
                           <!--  <th>Year</th>
                            <th>Month</th> -->
                            <th>No Of Attributes</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody><?php $i=1?>
                        @foreach($services as $data)
                        <tr>
                            <td>{{$i++}}</a></td>
                            <td>{{$data->service_name}}</td>

                            <td>{{count($data->getAttributesss)}}</td>
                            <td>
                                <div class="dropdown pull-left">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Action
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('master.service.attribute.show',[$data->id])}}"  ><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</a></li>
                                        <li><a href="" class=" addId" data-id="{{$data->id}}"
                                         data-service_name="{{$data->service_name}}"

                                         data-toggle="modal"
                                         data-target="#myModalAdd"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp; Edit</a></li>
                                        <li><a href="{{route('master.service.delete',[$data->id])}}"   onclick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp; Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalServicesAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" style="padding-left: 130px;" aria-label="Close"> × </button>
                    <h5 class="modal-title"><i class="fa fa-plus"></i>&nbsp;Service</h5>
                </div>
                <div class="modal-body">
                    <div class="form portlet-body ">

                        {{csrf_field()}}
                        <div class="form-group is-empty">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Service Name:</label>
                                    <div class="col-md-7">
                                        <input class="form-control col-md-8" type="text" id="myModalServicesAddinput"  name="service_name" value="{{old('service_name')}}" placeholder="Enter Service Name">
                                    </div>
                                </div>
                            </div>
                           <!--  <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Year:</label>
                                    <div class="col-md-4">
                                        <input class="form-control col-md-8" type="checkbox"  name="year" value="1">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Month:</label>
                                    <div class="col-md-4">
                                        <input class="form-control col-md-8" type="checkbox"  name="month" value="1" >
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <button type="button" id="myModalServicesbutton" class="btn btn-primary pull-right"><i class="fa fa-check">&nbsp;Submit</i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="myModalServicesEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h5 class="modal-title"><i class="fa fa-plus"></i>&nbsp;Service</h5>
            </div>
            <div class="modal-body">
                <div class="form portlet-body ">
                    <form action="{{route('master.service.update')}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="update_id" value="" id="update_id">
                        <div class="form-group is-empty">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Service Name:</label>
                                    <div class="col-md-8">
                                        <input class="form-control col-md-8" type="text"  name="service_name" id="service_name" value="{{old('service_name')}}" placeholder="Enter Service Name">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Year:</label>
                                    <div class="col-md-4">
                                        <input class="form-control col-md-8" type="checkbox"  name="year"  id="year" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Month:</label>
                                    <div class="col-md-4">
                                        <input class="form-control col-md-8" type="checkbox"  name="month" id="month" value="" >
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12" style="text-align: center;">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check">&nbsp;Submit</i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.addId').on('click',function(){
            var id=jQuery(this).data('id');
            var service_name=jQuery(this).data('service_name');
            // var year=jQuery(this).data('year');
            // var month=jQuery(this).data('month');
            // if(year=='Yes'){
            //     document.getElementById("year").checked = true;
            // }else{
            //     document.getElementById("year").checked = false;
            // }
            // if(month=='Yes'){
            //     document.getElementById("month").checked = true;
            // }else{
            //     document.getElementById("month").checked = false;
            // }

            jQuery('#update_id').val(id);
            jQuery('#service_name').val(service_name);
            // jQuery('#year').val(year);
            // jQuery('#month').val(month);
            jQuery('#myModalServicesEdit').modal('show');
            console.log(id,service_name,year,month);
        });
    });



$('#myModalServicesbutton').on('click', function () {
      var input = jQuery('#myModalServicesAddinput').val();
    if(input =='')
            {
            alert('please fill Service');
            return false;
            }
        var service_name = $('#myModalServicesAddinput').val();
        $.ajax({
            type: 'post',
            url: "{{route('master.service.add')}}",
            data: { service_name: service_name, _token: '{{csrf_token()}}' },
            dataType : 'json',
            success: function(response){
                         //alert();
                            if(response.success){
                              if(response.message){
                                 ViewHelpers.notify("success",response.message);
                                 location.reload(true);
                              }
                            }
                            else{
                              if(response.message){
                                 ViewHelpers.notify("error",response.message);
                              }
                            }
                        },
                        error: function(err){
                            location.reload(true);
                        }
        });
    });



$(document).keypress(function(e) {
  if ($("#myModalServicesAdd").hasClass('in') && (e.keycode == 13 || e.which == 13)) {
   $("#myModalServicesbutton").click();
  }
})







</script>
@endsection
