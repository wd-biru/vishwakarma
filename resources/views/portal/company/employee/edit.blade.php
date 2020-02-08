@extends('layout.app')
@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-user-circle"></i>&nbsp;Employee management</h1>
    </div>
    <div>
        <ul class="breadcrumb">
           <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
           <li><a href="{{route('companyemployee')}}">Employee List</a></li>
           <li><a href="#">Edit</a></li>
       </ul>
   </div>
</div>
@endsection
@section('content')
@include('includes.msg')
@include('includes.validation_messages')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-edit"></i> Edit Employee </h3></div>
            <div class="panel-body">

                <form class="form-horizontal" action="{{route('companyemployeeInfoUpdate')}}" method="post" enctype="multipart/form-data">
                 <input type="hidden" name="update_id" value="{{$id}}">

                 {{ csrf_field() }}
                 <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <fieldset><br>
                             @foreach($editEmployee as $value)
                             <input type="hidden" name="user_id" value="{{$value->getUserDetails->id}}">
                             <div class="form-group">
                                <label class="control-label col-md-4">First Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" name="first_name" id="Client_name" placeholder="Enter first name" style="text-transform: capitalize" value="{{$value->first_name}}" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Last Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" name="last_name" value="{{$value->last_name}}" placeholder="Last Name" required="required">
                                </div>
                            </div>

                             <div class="form-group">
                                            <label class="control-label col-md-4">Gender&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8" style="display: inline">

                                            Male:&nbsp;&nbsp;&nbsp; <input type="radio" name="gender" value="MALE" @if($value->gender=='MALE' || $value->gender=='Male') checked="checked" @endif required>

                                            Female:&nbsp;&nbsp;&nbsp;<input  type="radio" name="gender" value="FEMALE" required @if($value->gender=='FEMALE' || $value->gender=='Female') checked="checked"  @endif>


                                        </div>
                                        </div>


                            <div class="form-group">
                                <label class="control-label col-sm-4">DOB <span style="color:red"> *</span></label>
                                <div class="col-sm-8">
                                  <input class="form-control dateofbirth" name="dob" value="{{date('d-m-Y', strtotime($value->dob))}}" placeholder="Enter Date of Birth" required>
                              </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-4">Contact No..&nbsp;<span style="color: #f70b0b">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="phone" value="{{$value->phone}}"  placeholder="9999988888" required>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="control-label col-md-4">Other Phone No&nbsp;<span style="color: #f70b0b">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="other_phone" id="Type" placeholder=" other contact number" value="{{$value->other_phone}}" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Address&nbsp;<span style="color: #f70b0b">*</span></label>

                            <div class="col-md-8">
                                <textarea class="form-control" name="address" value="{{$value->address}}">{{$value->address}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Status&nbsp;<span style="color: #f70b0b">*</span></label>
                            <div class="col-md-8">

                              <select class="form-control" name="status" >
                                <option value="1" @if($value->status == 1) selected @endif>Active</option>
                                <option value="0"  @if($value->status == 0) selected @endif>DeActive</option>

                            </select>

                        </div>
                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4"> Is Director:&nbsp;<span style="color: #f70b0b">*</span></label>
                                        <div class="col-md-8" style="display: inline">

                                            <input type="checkbox" name="isDirector" value="yes" class="chkDirect" id="chkDirect1"  @if($value->reporting_id== 0 || $value->reporting_id==0) checked="checked" @endif> Yes<br>
                                            <input type="checkbox" name="isDirector" value="no" class="chkDirect" id="chkDirect2"@if($value->reporting_id !=0 || $value->reporting_id !=0) checked="checked" @endif > No<br>



                                        </div>
                                    </div>
                    <div class="form-group">
                            <label class="control-label col-md-4" id="repLabel">Reporting To &nbsp;<span style="color: #f70b0b">*</span></label>

                            <div class="col-md-8">
                                <select class="form-control" id="repMenu" name="reporting_id" required >
                                    @if($Employee->reporting_id >0)
                                    <option value="{{$oneEmp->id}}">{{$oneEmp->first_name}}&nbsp;{{$oneEmp->last_name}}</option>

                                        @else
                                        @foreach($get_reporting as $value)
                                        @if($value->id >=0)
                                            <option value="{{$value->id}}">{{$value->first_name}}&nbsp;{{$value->last_name}}</option>
                                        @endif

                                        @endforeach
                                        @endif


                                </select>
                            </div>
                        </div>

                </fieldset><br>
            </div>
        </div>
    </div>


    <div class="col-md-6" style="margin-top: 15px">
        <div class="form-group">
            <label class="control-label col-sm-4">Profile Image</label>
            <div class=" col-sm-8">
                 @foreach($editEmployee as $value)

                     @if($value->profile_image ==null)
                        <div class="comlogo"  style="width: 250px; height:194px; margin: 0 auto;"><img  id="output" style="height: 168px; width: 100%; " src="{{url('public/uploads/profile_images/default.jpg')}}" alt="" title="your Logo" class=" img-thumbnail" ></div><br>
           @else

                        <div class="comlogo"  style="width: 250px; height:194px; margin: 0 auto;"><img  id="output" style="height: 168px; width: 100%; " src="{{url('public/uploads/profile_images')}}/{{$value->profile_image}}" alt="" title="your Logo" class=" img-thumbnail" ></div><br>
                     @endif

            </div>
               @endforeach
            <label class="control-label col-sm-4">Select Profile Image<span style="color:red"> *</span></label>
            <div class="col-sm-8">

                <input type="file" class="form-control" style="padding: 5px 12px;" id="image" name="profile_image" value="{{$value->profile_image}}" >
            </div>

        </div>

        <div class="form-group">
            <label class="control-label col-sm-4">Department Name<span style="color:red"> *</span></label>
            <div class="col-sm-8">

              <select class=" department form-control " id="department_id" name="department_name" required>
                <option  value="{{$desination->department_id}}">{{$designation}}</option>
                  @foreach($depart_whole as $dept_id)
                    @if($dept_id->id !=$desination->department_id)
                      <option  value="{{$dept_id->id}}">{{$dept_id->department_name}}</option>
                    @endif
                  @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-4">Desgination Name<span style="color:red"> *</span></label>
        <div class="col-sm-8">
           <select class="form-control" id="designation_id" name="designation_name"required >

                <option  value="{{$desination->id}}">{{$desination->designation}}</option>

               @foreach($desig_whole as $desig_id)
                   @if($desig_id->id !=$desination->id)
                   <option  value="{{$desig_id->id}}">{{$desig_id->designation}}</option>
                   @endif
               @endforeach
        </select>
    </div>
</div>
                                <div class="form-group">
                                <label class="control-label col-sm-4">Date of Joining <span style="color:red"> *</span></label>
                                <div class="col-sm-8">
                                  <input class="DisableBackDatepicker form-control" name="date_of_joining" value="{{$Employee->date_of_joining!=''? $Employee->date_of_joining:''}}"placeholder="Enter Joining Date" required>
                              </div>
                          </div>
</div>
<div class="row">
    <div class="col-md-12">
      <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-edit"></i> Login </h3></div>
  </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label col-sm-4">Email<span style="color:red"> *</span></label>
            <div class="col-sm-8">
                <input class="form-control" type="email" name="email" id="Box_No"  value="{{$value->getUserDetails->email}}" placeholder="xxxxxxxxxx@xxx.com" required>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label col-md-4">Password&nbsp;<span style="color: #f70b0b">*</span></label>
            <div class="col-sm-8">
                <input class="form-control" type="password" name="password" id="File_No" value="{{$value->getUserDetails->password}}"  placeholder="Enter password" required>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>
@endforeach
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <button type="submit" id="submit_btn" class="btn btn-primary">Submit</button>
        </div>


    </div>
</div>
</form>

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
    if ($("#chkDirect1").is(':checked')){
        $("#repLabel").hide();
        $("#repMenu").hide();
    }
    $('.chkDirect').on('change', function() {
        $('.chkDirect').not(this).prop('checked', false);
    });

    $(document).ready(function(){
        $("input[type='checkbox']").change(function(){
            if($(this).val()=="no")
            {
                $("#repLabel").show();
                $("#repMenu").show();
            }
            else if($(this).val()=="yes")
            {
                $("#repLabel").hide();
                $("#repMenu").hide();
            }
        });
    });


    $("#department_id").change(function() {
        if ($(this).data('options') === undefined) {
            /*Taking an array of all options-2 and kind of embedding it on the select1*/
            $(this).data('options', $('#designation_id option').clone());
        }
        var id = $(this).val();
        var options = $(this).data('options').filter('[value=' + id + ']');
        $('#designation_id').html(options);
    });


  $(document).ready(function() {

    $('#department_id').on("change",function (event) {
       event.preventDefault();
       $('#designation_id').html("");
       var department_id=$(this).val();
            //alert(department_id);
           $.ajax({

            url:APP_URL+'/portal/company/employee/employee/json/'+department_id,
            type:"get",
            data:{},
            dataType:'json',
            success:function(response){
                if(response.success)
                {
                    jQuery('#designation_id').html('<option>---select----</option>');
                    if(response.data)
                    {
                        for(var c=0;c<response.data.length;c++)
                        {
                            $("#designation_id").append('<option value="'+response.data[c].id+'">'+response.data[c].designation+'</option>');
                        }
                    }
                }
                else
                {
                    if(response.message){
                        ViewHelpers.notify("error",response.message)
                    }
                }
            },
            error: function(err){
                            //alert(err) ;
                        }

                    })

       });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#output').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

      function hideSelection(type) {
          if ($(type).val() == yes) {
              $("#repLabel").hide();
              $("#repMenu").hide();
          } else {
              $("#repLabel").show();
              $("#repMenu").show(); /* If you want to be hidden if it's not */
          }
      }
    $("#image").change(function() {
        readURL(this);
    });



                jQuery(".DisableBackDatepicker").datepicker({
                    format: 'dd/mm/yyyy',
                    startDate:"today",
                    autoclose: true,
                    todayHighlight: true,
                   // minDate:0,
                });

                jQuery(".dateofbirth").datepicker({
                     format: 'dd/mm/yyyy',
                     startDate:'-100y',
                     autoclose: true,
                     todayHighlight: true,
                     endDate: "-18y",
                    // maxDate:0,
                });







});








</script>

@endsection
