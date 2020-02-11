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
           <li><a href="#">Add</a></li>
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
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-edit"></i> Add Employee </h3></div>
            <div class="panel-body">

                <form id="form_validate" class="form-horizontal" action="{{route('companyemployeeInfoStore')}}" method="post" enctype="multipart/form-data">

                 {{ csrf_field() }}
                 <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <fieldset><br>

                             <div class="form-group">
                                <label class="control-label col-md-4">First Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" name="first_name" id="Client_name" placeholder="Enter first name" style="text-transform: capitalize" value="{{old('first_name')}}" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Last Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" name="last_name" value="{{old('last_name')}}" placeholder="Last Name" required="required">
                                </div>
                            </div>

                             <div class="form-group">
                                            <label class="control-label col-md-4">Gender&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8" style="display: inline">

                                            Male:&nbsp;&nbsp;&nbsp; <input type="radio" name="gender" value="MALE" >

                                            Female:&nbsp;&nbsp;&nbsp;<input  type="radio" name="gender" value="FEMALE" >


                                        </div>
                                        </div>


                            <div class="form-group">
                                <label class="control-label col-sm-4">Date Of Birth <span style="color:red"> *</span></label>
                                <div class="col-sm-8">
                                  <input class="form-control dateofbirth datepicker" name="dob" value="{{old('dob')}}" placeholder="Enter Date of Birth" required>
                              </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-4">Contact No..&nbsp;<span style="color: #f70b0b">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="phone" value="{{old('phone')}}"  placeholder="9999988888" required>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="control-label col-md-4">Other Phone No&nbsp;<span style="color: #f70b0b">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="other_phone" id="Type" placeholder=" other contact number" value="{{old('other_phone')}}" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Address&nbsp;<span style="color: #f70b0b">*</span></label>

                            <div class="col-md-8">
                                <textarea class="form-control" name="address" value="">{{old('address')}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Status&nbsp;<span style="color: #f70b0b">*</span></label>
                            <div class="col-md-8">

                              <select class="form-control" name="status" >
                                <option value="1">Active</option>
                                <option value="0">DeActive</option>

                            </select>

                        </div>
                    </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4"> Is Director:&nbsp;<span style="color: #f70b0b">*</span></label>
                                    <div class="col-md-8" style="display: inline">

                                        {{--Yes&nbsp;&nbsp; <input type="radio" name="isDirector" value="yes">--}}
                                        {{--&nbsp;No &nbsp;&nbsp; <input type="radio" name="isDirector" value="no">--}}
                                        <input type="checkbox" name="isDirector" value="yes" class="chkDirect" id="chkDirect1"> Yes<br>
                                        <input type="checkbox" name="isDirector" value="no" class="chkDirect" id="chkDirect2" checked> No<br>



                                    </div>
                                </div>
                    <div class="form-group">
                            <label class="control-label col-md-4" id="repLabel">Reporting To &nbsp;<span style="color: #f70b0b">*</span></label>

                            <div class="col-md-8">
                                <select class="form-control" id="repMenu" name="reporting_id" required >
                                  <option value="0" >----------------Select Name----------------</option>
                                  @foreach($Employee as $value)
                                  <option value="{{$value->id}}">{{$value->first_name}}<p> </p>{{$value->last_name}}</option>
                                @endforeach
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

                <div class="comlogo"  style="width: 250px; height:194px; margin: 0 auto;"><img  id="output" style="height: 168px; width: 100%; " src="" alt="" title="your Logo" class=" img-thumbnail" ></div><br>
            </div>

            <label class="control-label col-sm-4">Select Profile Image<span style="color:red"> *</span></label>
            <div class="col-sm-8">

                <input type="file" class="form-control" style="padding: 5px 12px;" id="image" name="profile_image" value="" >
            </div>

        </div>

        <div class="form-group">
            <label class="control-label col-sm-4">Department Name<span style="color:red"> *</span></label>
            <div class="col-sm-8">

              <select class=" department form-control " id="department_id" name="department_name" required>

                <option  value="">-------------select--------------</option>
                @foreach($department as $dep)
                <option  value="{{$dep->id}}">{{$dep->department_name}}</option>
                @endforeach

            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-4">Desgination Name<span style="color:red"> *</span></label>
        <div class="col-sm-8">
           <select class="form-control" id="designation_id" name="designation_name" required >

                <option value="">----------------select---------------</option>

        </select>
    </div>
</div>
            <div class="form-group">
            <label class="control-label col-sm-4">Date of Joining <span style="color:red"> *</span></label>
            <div class="col-sm-8">
              <input class="DisableBackDatepicker form-control" name="date_of_joining" value="" placeholder="Enter Joining Date" required value="{{old('date_of_joining')}}">
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
                <input class="form-control" type="email" name="email" id="Box_No"  value="{{old('email')}}" placeholder="www@email.com" required>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label col-md-4">Password&nbsp;<span style="color: #f70b0b">*</span></label>
            <div class="col-sm-8">
                <input class="form-control" type="password" name="password" id="File_No" value="{{old('password')}}"  placeholder="Enter password" required>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>

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
    // $('#chkDirect1').prop('checked', false);
    // document.getElementById("#chkDirect1").checked = false;
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


$(document).ready(function() {
    $('#department_id').on('change', function () {
        var dept_id = $(this).val();
        var op = " ";
        var _token = $('input[name="_token"]').val();
        $.ajax({
            type: 'get',
            url: "{{route('findDesignationsData')}}",
            data: {'id': dept_id},
            success: function (data) {
                op += ' <option value="0">----------------select---------------</option>';
                console.log(data);
                for (var i = 0; i < data.length; i++) {
                    op += ' <option value="' + data[i].id + '">' + data[i].designation + '</option>';
                }
                $(document).find('#designation_id').html(" ");
                $(document).find('#designation_id').append(op);
            },
            error: function () {
            }
        });
    });


    $("input[name='designation_name']").on('change', function () {
        debugger
        var desig_id = $(this).val();
        var _token = $('input[name="_token"]').val();
alert(desig_id);
        console.log(desig_id);
        $.ajax({
            type: 'post',
            url: "{{route('companyemployeeInfoStore')}}",
            data: {'id': desig_id, '_token': _token},
            datatype:'html',
            success: function (data) {
                //console.log(data);
            },
            error: function () {
            }
        });
    });

});




  $(document).ready(function() {
        $('.numeric').keypress(function (event) {
            return isNumber(event, this)
        });

    });


    // THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
    function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }


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

    jQuery(".DisableBackDatepicker").datepicker({
        format: 'dd/mm/yyyy',
        startDate:"today",
        autoclose: true,
        todayHighlight: true,
        minDate:0,
        // endDate: "today",
    });

    jQuery(".dateofbirth").datepicker({
        format: 'dd/mm/yyyy',
        startDate:'-100y',
        autoclose: true,
        todayHighlight: true,
        endDate: "-18y",
    });


    </script>

@endsection
