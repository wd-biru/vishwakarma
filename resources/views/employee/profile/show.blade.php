@extends('layout.app')

@section('title')

<div class="page-title">
    <div>
        <h1><i class="fa fa-user-circle"></i>&nbsp;My Profile</h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('employee.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
            <li><a href="#">Edit</a></li>
         </ul>
     </div>
</div>
@endsection
@section('content')
<style type="text/css">
.box {
    position: relative;
    border-radius: 3px;
    background: #ffffff;
    border-top: 3px solid #d2d6de;
    margin-bottom: 20px;
    width: 100%;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}
.box-widget {
    border: none;
    position: relative;
}
.widget-user .widget-user-header {
    padding: 20px;
    height: 110px;
    border-top-right-radius: 3px;
    border-top-left-radius: 3px;
}
.widget-user .widget-user-username {
    margin-top: 0;
    margin-bottom: 5px;
    font-size: 25px;
    font-weight: 300;
    text-shadow: 0 1px 1px rgba(0,0,0,0.2);
}
.widget-user .widget-user-desc {
    margin-top: 0;
}
.widget-user .widget-user-image {
    position: absolute;
    top: 65px;
    left: 50%;
        width: 25%;
    
        border-radius: 50%;
    margin-left: -45px;
}
.widget-user .box-footer {
    padding-top: 30px;
}
.widget-user-image img {
    border: 3px solid #fff;    
}
.widget-user .widget-user-username {
    color: #ffffff;
    font-size: 20px;
    margin-top: 0;
    margin-bottom: 5px;
    font-size: 25px;
    font-weight:bold;
   
    text-shadow: 0 1px 1px rgba(0,0,0,0.2);
}
.widget-user-desc{
    color: #ffff;
    font-size: 18px;
}
.box-footer {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-right-radius: 3px;
    border-bottom-left-radius: 3px;
    border-top: 1px solid #f4f4f4;
    padding: 10px;
    background-color: #fff;
}
.box .border-right {
    border-right: 1px solid #f4f4f4;
}
.description-block {
    display: block;
    margin: 10px 0;
    text-align: center;
}
</style>
          
 @include('includes.msg')
 @include('includes.validation_messages')          
<div class="row">
    <div class="col-md-4">
        <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-black" style="background:url('http://localhost/acc-nextweb/public/uploads/profile_images/1533642506.jpg') center center;">
                <h3 class="widget-user-username" style="    color: #013366;">{{ucfirst(Auth::user()->getImageEmp->first_name)}}&nbsp;{{ucfirst(Auth::user()->getImageEmp->last_name)}}</h3>
                <?php $depart = App\Models\DepartmentMaster::where('id',Auth::user()->getImageEmp->department_id)->first();?>
                {{--<h5 class="widget-user-desc">{{ucfirst($depart->department_name)}}</h5>--}}
            </div>
            
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header">{{Auth::user()->getImageEmp->phone}}</h5>
                            <span class="description-text">PHONE</span>
                        </div>
                  <!-- /.description-block -->
                    </div>
                <!-- /.col -->
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                             
                            <span class="description-text">DATE OF BIRTH</span>
                        </div>
                      <!-- /.description-block -->
                    </div>
                <!-- /.col -->
                    <div class="col-sm-4">
                        <div class="description-block">
                             
                            <span class="description-text">DATE OF JOINING</span>
                        </div>
                  <!-- /.description-block -->
                    </div>
                <!-- /.col -->
                </div>
              <!-- /.row -->
            </div>
        </div>
       
          <!-- /.widget-user -->
    </div>

    <div class="col-md-8">
        <div class="mytabs">
            <div class="row">
                <div class="col-md-12">
                    <div class="content-section">            
                        <div class="tabshorizontal">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">


                                <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-edit"></i>  <span>Personal Details</span></a></li>

 
                                <li role="presentation" ><a href="#banks" aria-controls="Contact" role="tab" data-toggle="tab"><i class="fa fa-envelope-o"></i>  <span>Banks Info</span></a></li>
                            </ul>
                  <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active " id="profile">
                                     <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-edit"></i>Employeement </h3>
                                        </div>
                                        <div class="panel-body">
                                            <form class="form-horizontal" action="{{route('employee.profile.update',$employee->id)}}" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="update_id" value="{{$employee->id}}">

                                                {{ csrf_field() }}
                                                <div class="col-md-6">
                                                    <div class="card">
                                                        <div class="card-body"> 
                                                          
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">First Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="text" name="first_name" id="Client_name" placeholder="Enter first name" style="text-transform: capitalize" value="{{$Employee->first_name}}"required>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="user_id" value="{{$Employee->user_id}}">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Last Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="text" name="last_name" value="{{$Employee->last_name}}" placeholder="Last Name"required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Gender&nbsp;<span style="color: #f70b0b">*</span></label>
                                                                <div class="col-md-8" style="display: inline">
                                                                    Male:&nbsp;&nbsp;&nbsp; <input type="radio" name="gender" value="MALE" @if($Employee->gender=='MALE' || $Employee->gender=='Male') checked="checked" @endif required>
                                             
                                                                    Female:&nbsp;&nbsp;&nbsp;<input  type="radio" name="gender" value="FEMALE" required @if($Employee->gender=='FEMALE' || $Employee->gender=='Female') checked="checked"  @endif>
                                                                </div>
                                                            </div> 
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Marital status&nbsp;</label>
                                                                <div class="col-md-8" style="display: inline">

                                                                    @if($Employee->Marital_status==null)
                                                                        Yes:&nbsp;&nbsp;&nbsp; <input type="radio" name="Marital_status" value="yes" checked="checked"  style="margin-left: 2px;">
                                                                        No:&nbsp;&nbsp;&nbsp;<input  type="radio" name="Marital_status" value="no" style="margin-left: 2px;">
                                                                    @else
                                                                   
                                                                    Yes:&nbsp;&nbsp;&nbsp; <input type="radio" name="Marital_status" value="yes"  @if($Employee->Marital_status=='yes'  ) checked="checked"  @endif style="margin-left: 2px;">
                                                                                                            
                                                                 
                                                                    No:&nbsp;&nbsp;&nbsp;<input  type="radio" name="Marital_status" value="no" @if($Employee->Marital_status=='no' || $Employee->Marital_status=='single') checked="checked" @endif>                                        
                                                                    
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                                <label class="control-label col-sm-4">DOB <span style="color:red"> *</span></label>
                                                                <div class="col-sm-8">
                                                                    <input class="datepicker form-control" data-date-format="mm/dd/yyyy" name="dob" type="date" value="{{$Employee->dob}}"placeholder="Enter Date of Birth"required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Address&nbsp;<span style="color: #f70b0b">*</span></label>
                                                                <div class="col-md-8">
                                                                    <textarea class="form-control" name="address" value="{{$Employee->address}}">{{$Employee->address}}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group" >
                                                                <label class="control-label col-md-4">Postal Code&nbsp;</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control numeric" type="text" name="Postal_code" id="Type" placeholder=" other contact number" value="{{$Employee->Postal_code}}" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Town&nbsp;</label>
                                                                <div class="col-md-8">
                                                                    <textarea class="form-control" name="Town" value="{{$Employee->Town}}">{{$Employee->Town}}</textarea>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                             
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card">
                                                        <div class="card-body"> 
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Id number&nbsp;</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control " type="text" name="Id_number" value="{{$Employee->Id_number}}"  placeholder="9999988888">
                                                                </div>
                                                            </div>
                                                            <div class="form-group" >
                                                                <label class="control-label col-md-4">Nationality&nbsp;</label>
                                                                <div class="col-md-8">
                                                                    <select name="Nationality" class="form-control">

                                                                        @foreach($nationality_data as $data)

                                                                        <option @if($Employee->Nationality == $data->NationalityID ) selected @endif value="{{$data->NationalityID}}">{{$data->Nationality}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Contact NO..&nbsp;<span style="color: #f70b0b">*</span></label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="text" name="phone" value="{{$Employee->phone}}"  placeholder="9999988888"required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group" >
                                                                <label class="control-label col-md-4">Other Phone No&nbsp;<span style="color: #f70b0b">*</span></label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="text" name="other_phone" id="Type" placeholder=" other contact number" value="{{$Employee->other_phone}}" >
                                                                </div>
                                                            </div>
                                                          
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Personal Email&nbsp;</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="email" name="Personal_email" id="Client_name" placeholder="Personal_email" style="text-transform: capitalize" value="{{$Employee->Personal_email}}">
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="user_id" value="{{$Employee->user_id}}">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Emergency contact&nbsp;</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control " type="text" name="Emergency_contact" value="{{$Employee->Emergency_contact}}" placeholder="Emergency_contact">
                                                                </div>
                                                            </div>
                                                            
                                                        
                                                            <div class="form-group">
                                                                <label class="control-label col-sm-4">Emergency tel </label>
                                                                <div class="col-sm-8">
                                                                    <input class=" form-control numeric" name="Emergency_tel" type="text" value="{{$Employee->Emergency_tel}}" placeholder="EEmergency tel">
                                                                </div>
                                                            </div>
                                                             
                                                            
                                                            
                                                            <div class="form-group">
                                                                
                                                                <div class="col-md-12">
                                                                    <div class="pull-right">
                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                        </div>
                                                                </div>
                                                            </div>
                                                           
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                               <!--  <div class="col-md-6" style="margin-top: 15px">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-4">Profile Image</label>
                                                        <div class=" col-sm-8">
                                                            <div class="comlogo"  style="width: 250px; height:194px; margin: 0 auto;"><img  id="output" style="height: 130px;    width: 75%; " src="{{url('public/uploads/profile_images')}}/{{$Employee->profile_image}}" alt="" title="your Logo" class=" img-thumbnail" ></div><br>
                                                        </div>
                                                        <label class="control-label col-sm-4">Select Image</label>
                                                        <div class="col-sm-8">
                                                            <input type="file" class="form-control" style="padding: 5px 12px;" id="image" name="profile_image" value="{{$Employee->profile_image}}">
                                                        </div>
                                                    </div>  
                                                </div>     <br>      <br>      <br> -->
                                               
                                            </form>
                                        </div>
                                    </div>
                                </div>
                               
                                <div role="tabpanel" class="tab-pane  " id="banks">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Bank Details</h3>
                                        </div>
                                        <div class="panel-body">
                                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModalBank" title="Add"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp; Bank Account</a>  <hr>
                                            <div id="bank_Holder">
                              
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


          
<!-- BANK MODAL -->
<div class="modal fade" id="myModalBank" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </div>
                <h4 class="modal-title" id="myModalLabel">Bank Accounts<span style="color:red"> *</span></h4>
            </div>
            <form class="form-horizontal" action="" id="EmployeeBankDetails" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                {{ csrf_field() }}
                    <input type="hidden" name="portal_id" id="portal" value="{{$employee->portal_id}}">
                    <input type="hidden" name="employee_id" id="employee" value="{{$employee->id}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-4 ">Account Holder Name&nbsp;</label>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="account_holder_name"placeholder="Enter Account holder name" style="text-transform: capitalize" value="" required>
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label class="control-label col-md-4 ">Account Number&nbsp;<span style="color: #f70b0b">*</span></label>
                                <div class="col-md-7">
                                    <input class="form-control numeric" type="text" name="account_number" " placeholder="Enter Account Number" style="text-transform: capitalize" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                         
                                <label class="control-label col-md-4">Bank Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="bank_name"  placeholder="Enter Bank name" style="text-transform: capitalize" value="" required>
                                </div>
                            </div>
                  
                            <div class="form-group">
                                <label class="control-label col-md-4">Branch Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="branch_name"  placeholder="Enter Branch name" style="text-transform: capitalize" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 ">IFSC CODE&nbsp;<span style="color: #f70b0b">*</span> </label>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="ifsc_code"  placeholder="Enter IFSC Code" style="text-transform: capitalize" value="" required>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="control-label col-md-4 ">IBAN No.&nbsp;<span style="color: #f70b0b">*</span> </label>
                                <div class="col-md-7">
                                    <input class="form-control numeric" type="text" name="iban_number"  placeholder="Enter IBAN number" style="text-transform: capitalize" value="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function() {
    $('#department_id').on("change",function (event) {
     event.preventDefault();
     $('#designation_id').html("");
     var department_id=$(this).val();
            //alert(department_id);
            $.ajax({

                url:APP_URL+'/employee/otherDetails/employee/json/'+department_id,
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

        })
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
});
  
    jQuery(document).on('click','.show_more',function(){
        jQuery('#show_more').show();
        
    });
    
        jQuery('.date-own').datepicker({
            minViewMode: 2,
            todayHighlight: true,
            format: 'yyyy'
        });

jQuery(document).on('click','.personldetails',function(){
     jQuery('#personldetails').show();
     jQuery('.hidee').hide();
     jQuery('#Bankdetails').hide();
 });
jQuery(document).on('click','.Bankdetails',function(){
       jQuery('#Bankdetails').show();
     jQuery('.hidee').hide();
      jQuery('#personldetails').hide();
     

    });
       
        
   

jQuery(function(){
    var obj={
        init:function(){
            $(document).on('click','#myTab a[data-toggle="tab"]', function (e) {
                  //var target = $(e.target).attr("href") // activated tab
                  var target = $(e.currentTarget).attr('href');
                  switch(target){
                    case "#otherinfo":
                                                     
                    break;
                    case "#banks":
                   // alert();
                        obj.employeeBankList();
                    break;
                    
                  }
                  
                });
             $('.numeric').keypress(function (event) {
                var keycode = event.which;
                if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
                    event.preventDefault();
                }
            }); 
            obj.EmployeeOtherDetails();
            obj.EmployeeBankDetails();             
                      
        },

        employeeBankList : function(){
            var portal_id=jQuery('#portal').val();
            var employee_id=jQuery('#employee').val();
             
          Helpers.callAjax(APP_URL+'/employee/otherDetails/'+portal_id+'/'+employee_id+'/show',
            'GET',
            {},
            'html',
            function(type,response){
              switch(type){
                case "success":
                  $("#bank_Holder").html(response);
                  jQuery('.search-table').DataTable();
                break;
              }
            });
          return false;
        },
EmployeeBankDetails:function(){
 jQuery(document).on('submit','#EmployeeBankDetails',function(event){
            jQuery.ajax({
              url:"{{route('employeeBankDetail.store')}}",
              type:"post",
              data: jQuery('#EmployeeBankDetails').serialize(),
              dataType:'json',
              success: function(response){
               if(response.success){
                  if(response.message){
                   ViewHelpers.notify("success",response.message);
                   jQuery('#myModalBank').modal('hide');
                   obj.employeeBankList();

                 }
               }
               else{ 
                if(response.message){
                 ViewHelpers.notify("error",response.message);
                   $('#Bankdetails').hide();
               }
             }
             $('#cost_att').val('');
           },
           error: function(err){

           }
         });
            event.preventDefault();
            return false;  

          });
},
    EmployeeOtherDetails:function(){
          jQuery(document).on('submit','#EmployeeOtherDetails',function(event){

            jQuery.ajax({
              url:"{{route('employeeOther.store')}}",
              type:"post",
              data: jQuery('#EmployeeOtherDetails').serialize(),
              dataType:'json',
              success: function(response){
               if(response.success){
                  if(response.message){
                   ViewHelpers.notify("success",response.message);
                   $('#personldetails').hide();
                   employeeOtherInfoList();

                 }
               }
               else{ 
                if(response.message){
                 ViewHelpers.notify("error",response.message);
                   $('#personldetails').hide();
               }
             }
             $('#cost_att').val('');
           },
           error: function(err){

           }
         });
            event.preventDefault();
            return false;  

          });
        },
      }
      obj.init();
    });







         

</script>
  




</script>
@endsection