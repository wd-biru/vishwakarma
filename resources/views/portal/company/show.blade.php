
@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-building"></i>&nbsp;Company Management</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('company')}}">Company List</a></li>
                <li><a href="#">view</a></li>
            </ul>
        </div>
    </div>

@endsection
@section('content')
@include('includes.validation_messages')


@foreach($client_list as $client)
    <div class="mytabs">
        <div class="cardtb">
            <div class="tabshorizontal">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-plus"></i>  <span><strong>View </strong></span></a></li>

                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="row">
                            <form class="form-horizontal" action="{{route('companyUpdate',[base64_encode($client->id)])}}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">

                                            <fieldset>
                                                <legend>Company</legend>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Company Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                                    <div class="col-md-8">
                                                    <input class="form-control" type="text" name="Company_name" id="Company_name" placeholder="Enter full name" style="text-transform: capitalize" value="{{$client->Client_name}}" required="" disabled>
                                                </div>
                                                </div>

                                                <!-- <div class="form-group">
                                                    <label class="control-label col-md-4">Activities</label>
                                                    <div class="col-md-8">
                                                         <select class="form-control"  name="Activities" required>

                                                           </select>
                                                </div>
                                                </div> -->
                                                <!-- <div class="form-group">
                                                    <label class="control-label col-md-4">Box File No&nbsp;<span style="color: #f70b0b">*</span></label>
                                                    <div class="col-md-8">
                                                    <input class="form-control" type="text" name="Box_No" id="Box_No"  value="{{old('Box_No')}}" placeholder="Enter Box File No. Ex. C 9/1" required="">
                                                </div>
                                                 </div> -->
                                                <!-- <div class="form-group">
                                                    <label class="control-label col-md-4">File No&nbsp;<span style="color: #f70b0b">*</span></label>
                                                    <div class="col-md-8">
                                                    <input class="form-control" type="text" name="File_No" id="File_No" value="{{old('File_No')}}"  placeholder="Enter File No. Ex. 303" required="">
                                                </div>
                                                </div> -->
                                                <!-- <div class="form-group">
                                                    <label class="control-label col-md-4">Source of Client&nbsp;<span style="color: #f70b0b">*</span></label>
                                                    <div class="col-md-8">
                                                        <select class="form-control" name="Source" >

                                                        </select>
                                                    </div>
                                                </div> -->
                                                <!-- <div class="form-group">
                                                    <label class="control-label col-md-4">Group Member</label>
                                                    <div class="col-md-8">
                                                    <input class="form-control" type="text" name="Group" id="Group" value="{{old('Group')}}"  placeholder="Ex. N/A">
                                                </div>
                                                  </div> -->
                                                <!-- <div class="form-group" >
                                                    <label class="control-label col-md-4">Type of Client&nbsp;<span style="color: #f70b0b">*</span></label>
                                                    <div class="col-md-8">
                                                        <select class="form-control" name="Type" >

                                                        </select>
                                                    </div>
                                                </div> -->
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Status&nbsp;<span style="color: #f70b0b">*</span></label>
                                                    <div class="col-md-8">
                                                    <select class="form-control" name="Status" disabled>
                                                      <option value="1" @if($client->Status == 1) selected @endif>Active</option>
                                                      <option value="0"  @if($client->Status == 0) selected @endif>DeActive</option>
                                                    </select>
                                                </div>
                                                </div>

                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">

                                            <fieldset>
                                                <legend>More Details</legend>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Logo&nbsp;</label>
                                                    <div class="col-md-8">
                                                        <div class="comlogo"  style="width: 250px; height:194px; margin: 0 auto;">
                                                          @if($client->logo == null)
                                                          <img  id="output" style="height: 168px; width: 100%; " src="{{ my_asset('uploads/company_images/default.jpg') }}" alt="" title="your Logo" class=" img-thumbnail" required></div>
                                                            @else
                                                            <img  id="output" style="height: 168px; width: 100%; " src="{{my_asset('uploads/company_images/'.$client->logo )}}" alt="" title="your Logo" class=" img-thumbnail" required></div>
                                                            @endif
                                                        <!-- <input class="" id="image"  value="{{old('logo')}}"  type="file" name="logo" placeholder="Enter logo_img"> -->
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Regestration NO.&nbsp;<span style="color: #f70b0b">*</span></label>
                                                    <div class="col-md-8">
                                                    <input class="form-control" type="text" value="{{$client->Registration_No}}" name="Registration_No" id="reg_no" placeholder="HE 1117" required disabled>
                                                </div>
                                                </div>


                                                   <div class="form-group">
                                                    <label class="control-label col-md-4">Website</label>
                                                    <div class="col-md-8">
                                                      @if($client->Website == null)
                                                      <input class="form-control" type="text" value="No Website Registered" name="Website" id="Website" placeholder="https://www.google.com" disabled>
                                                      @else
                                                    <input class="form-control" type="text" value="{{$client->Website}}" name="Website" id="Website" placeholder="https://www.google.com" disabled>

                                                    @endif
                                                </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Date Acquired&nbsp;<span style="color: #f70b0b">*</span></label>
                                                    <div class="col-md-8">
                                                      @if($client->Date_Acquired != null)
                                                    <input class="form-control datepicker" name="Date_Acquired" value="{{$client->Date_Acquired}}" placeholder="Date Acquired"  type="text" required="" disabled>
                                                      @else
                                                    <input class="form-control datepicker" name="Date_Acquired" value="{{$client->Date_Acquired}}" placeholder="Date Acquired"  type="text" required="" disabled>
                                                    @endif
                                                </div>
                                                </div>

                                            </fieldset><br>
                                            <!-- <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit" id="submit_btn" class="btn btn-primary pull-right">Submit</button>
                                                    </div>
                                            </div> -->

                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="clearix"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--tabs end here-->
    </div>


@endforeach
@endsection

@section('script')
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#output').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image").change(function() {
        readURL(this);
    });
    jQuery(function(){
        var vil={
            init:function(){
                // vil.clientUpdate();
               // vil.getfile();
                vil.year();
                vil.date();
                vil.emailUnique();
                vil.mobileUnique();
                 $('.numeric').keypress(function (event) {
                        var keycode = event.which;
                        if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
                            event.preventDefault();
                        }
                    });
                console.log('hello');
            },

            year:function(){
                jQuery('.date-own').datepicker({
                    minViewMode: 2,
                    todayHighlight: true,
                    format: 'yyyy'
                });
            },
            emailUnique:function () {
                jQuery("#Email").on('keyup',function () {
                   var email = jQuery('#Email').val();
                   if(email){
                       jQuery.get('checkEmailUnique',{
                           email:email,
                           '_token': jQuery('meta[name="csrf-token"]').attr('content'),
                       },function(response){
                           jQuery('#email_status').html(response);
                           if(response=="OK")                               {
                               jQuery('#submit_btn').show();
                               return true;
                            }else{
                               jQuery('#submit_btn').show();
                               return false;
                            }
                        });
                    }else{
                       jQuery('#email_status').html("");
                       return false;
                    }
                });
            },
            mobileUnique:function () {
                jQuery("#Mobile").on('keyup',function () {
                    var mobile = jQuery('#Mobile').val();
                    if(mobile){
                        if(mobile.length > 9 && mobile.length < 16){
                            jQuery('#mobile_status').html("");
                            jQuery('#submit_btn').show();
                            jQuery.get('checkMobileUnique',{
                                mobile:mobile,
                                '_token': jQuery('meta[name="csrf-token"]').attr('content'),
                            },function(response){
                                jQuery('#mobile_status').html(response);
                                if(response==null){
                                    jQuery('#submit_btn').show();
                                    return true;
                                }else{
                                    jQuery('#submit_btn').show();
                                    return false;
                                }
                            });
                        }else{
                            jQuery('#submit_btn').hide();
                            jQuery('#mobile_status').html("length must be greater than nine(9) and less than sixteen(16)");
                        }
                    }else{
                        jQuery('#mobile_status').html("");
                        return false;
                    }
                });
            },
            date:function(){
                jQuery(".datepicker").datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                });
            },
            selectRo:function(){
                jQuery('#category_id').on('change',function(){
                    console.log('hello');
                    vil.getfile();
                });
            },
        }
        vil.init();
    });
</script>
@endsection
