@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Service Management</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('portal')}}">Users list</a></li>
                <li><a href="#">{{$viewInfo->company_name}}</a></li>
            </ul>
        </div>
    </div>
@endsection
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
@section('content')




<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-edit"></i> Edit Info</h3></div>
            <div class="panel-body">
            @include('includes.msg')
            @include('includes.validation_messages')
                <div class="tabshorizontal">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-info"></i>  <span>Portal Info</span></a></li>
                        <li role="presentation" ><a href="#Menu" aria-controls="Menu" role="tab" data-toggle="tab"><i class="fa fa-envelope-o"></i>  <span>Menu Permission</span></a></li>
                        <!-- <li role="presentation"  class="active" ><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"><i class="fa fa-cog"></i>  <span>Fees</span></a></li>
                        <li role="presentation"  class="active" ><a href="#extra" aria-controls="settings" role="tab" data-toggle="tab"><i class="fa fa-plus-square-o"></i>  <span>Services</span></a></li> -->
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active " id="home">
                            <div class="row">
                                <form  class="form-horizontal" action="{{route('portalInfoUpdate')}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <fieldset><br>
                                             <legend>Portal</legend>
                                                    <input type="hidden" name="update_id" id="oprate_id" value="{{$viewInfo->id}}">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                                        <div class="col-md-8">
                                                        <input class="form-control" type="text" name="name"  placeholder="Enter  name" style="text-transform: capitalize" value="{{$viewInfo->name}}">
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Sur Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                                        <div class="col-md-8">
                                                        <input class="form-control" type="text" name="surname" value="{{$viewInfo->surname}}" placeholder=" ">
                                                    </div>
                                                    </div>

                                                   <div class="form-group">
                                                        <label class="control-label col-md-4">Mobile&nbsp;<span style="color: #f70b0b">*</span></label>
                                                        <div class="col-md-8">
                                                        <input class="form-control groupOfTexbox" type="number" value="{{$viewInfo->mobile}}" name="mobile" id="mobile" placeholder="9931815443" ><span style="color:green" id="mobile_status"></span>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Mobile Other</label>
                                                        <div class="col-md-8">
                                                        <input class="form-control groupOfTexbox" type="number" value="{{$viewInfo->other_mobile}}" name="other_mobile" id="Other_Mobiles"  placeholder="9965285943">
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
                                                        <label class="control-label col-md-4">Address&nbsp;<span style="color: #f70b0b">*</span></label>
                                                        <div class="col-md-8">
                                                        <textarea class="form-control" name="address">{{$viewInfo->address}}</textarea>
                                                    </div>
                                                    </div>
                                                </fieldset>

                                                <fieldset><br>
                                                    <legend>Login Details</legend>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Email&nbsp;<span style="color: #f70b0b">*</span></label>
                                                        <div class="col-md-8">
                                                        <input autocomplete="new-password" class="form-control" type="text" value="" name="email" id="email" placeholder="xxxxx@xxx.com" >
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Password</label>
                                                        <div class="col-md-8" >
                                                        <input autocomplete="new-password" class="form-control" id="hidepass"  type="password" class="effect-2" name="password" placeholder="Password">
                                                    </div>
                                                    </div>
                                                    <div class="form-group" style="
    margin-left: 173px;
    margin-top: -12px;
">
                                                    <input type="checkbox" onclick="myFunction()">Show Password
                                                </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                 <fieldset>
                                                    <legend>Company</legend><br>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Company Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                                        <div class="col-md-8">
                                                        <input class="form-control" type="text" name="company_name" id="company_name" placeholder="Enter full name" style="text-transform: capitalize" value="{{$viewInfo->company_name}}">
                                                    </div>
                                                    </div>
                                                         <div class="form-group">
        <label class=" col-md-3" style="margin-left: 39px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Logo&nbsp;</label>
        <div class="col-md-8">
        <div class="comlogo"  style="width: 250px; height:194px; margin: 0 auto;"><img  id="output" style="height: 168px; width: 100%; " src="{{getPortalImageUrl($viewInfo->logo_img)}} " alt="" title="your Logo" class=" img-thumbnail" required></div>

        <input class="" id="image" type="file" name="logo_img" placeholder="Enter logo_img">
        </div>
        </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Contact Person&nbsp;<span style="color: #f70b0b">*</span></label>
                                                        <div class="col-md-8">
                                                        <input class="form-control" type="text" name="contact_person" id="contact_person"  value="{{$viewInfo->contact_person}}" placeholder="person name">
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Company Email&nbsp;<span style="color: #f70b0b">*</span></label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" type="email" name="company_mail" id="company_mail" value="{{$viewInfo->company_mail}}"  placeholder="xxxxxxxx@xxx.com">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Company Phone&nbsp;<span style="color: #f70b0b">*</span></label>
                                                        <div class="col-md-8">
                                                            <input class="form-control" type="text" name="company_mobile" id="company_mobile" value="{{$viewInfo->company_mobile}}"  placeholder="  enter contact number">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Company Address&nbsp;<span style="color: #f70b0b">*</span></label>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control" name="company_address"  placeholder="enter company address">{{$viewInfo->company_address}}</textarea>
                                                        </div>
                                                    </div>
                                                </fieldset><br>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit"  class="btn btn-primary pull-right"><i class="fa fa-check"></i> Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

        <div role="tabpanel" class="tab-pane" id="Menu">
         <?php $i=0; $j=0;$k=0;$l=0?>
        @foreach($menus as $menu)
        @if($menu->parent_id == 0)

<div class="row">
        <div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" id="collapseOne{{$k++}}" data-parent="#accordion{{$l++}}" href="#collapse{{$j++}}">
       {{$menu->menu_name}}</a>
      </h4>
    </div>
    <div id="collapse{{$i++}}" class="panel-collapse collapse">
      <div class="panel-body" >

          <li class="treeview "><input type="checkbox" class="menu_opration  main_menu_{{$menu->id}}" name="menus_id[]"
        data-id='{{$menu->id}}' value="{{$menu->id}}" @foreach($portals_menu as $per)
        @if($per->menu_id == $menu->id) checked @endif @endforeach ><span>{{$menu->menu_name}}</span>
        <ul class="treeview-menu">
        @foreach($menus as $child)
        @if($menu->id == $child->parent_id)
        <li class="treeview "><input type="checkbox" class="menu_opration main_menu_{{$child->id}}" data-id='{{$child->id}}' name="menus_id[]" value="{{$child->id}}" @foreach($portals_menu as $per)
        @if($per->menu_id == $child->id) checked @endif @endforeach ><span>{{$child->menu_name}}</span></li>
        <ul class="treeview-menu">
        @foreach($menus as $sub_child)
        @if($child->id == $sub_child->parent_id )
        <li><input type="checkbox" name="menus_id[]" data-id='{{$sub_child->id}}' class="menu_opration main_menu_{{$sub_child->id}}" value="{{$sub_child->id}}" @foreach($portals_menu as $per)
        @if($per->menu_id == $sub_child->id) checked @endif @endforeach ><span>{{$sub_child->menu_name}}</span></li>
        @endif
        @endforeach
        </ul>
        @endif
        @endforeach
        <hr>
        </ul>
        </li>



      </div>
    </div>
  </div>


</div>
</div>

        @endif

        @endforeach
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

  $(document).ready(function() {
        $('.groupOfTexbox').keypress(function (event) {
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


jQuery(function(){
    var obj={
        init:function(){
            $(document).on('click','#myTab a[data-toggle="tab"]', function (e) {
                  //var target = $(e.target).attr("href") // activated tab
                  var target = $(e.currentTarget).attr('href');
                  switch(target){
                    case "#home":
                    break;

                    case "#Menu":
                        // obj.Menu();
                    break;
                  }

                });
            obj.menuPermission();
        },
        menuPermission:function(){
          jQuery(document).on('click','.menu_opration',function(event){
            var portal_id = jQuery('#oprate_id').val();
            var menu_id = jQuery(this).data('id');


            jQuery.ajax({
              url:"{{route('portal.menu.store')}}",
              type:"get",
              data: {portal_id:portal_id,menu_id:menu_id},
              dataType:'json',
              success: function(response){
               if(response.success){
                    jQuery('.main_menu_'+menu_id).prop("checked",true);
                  if(response.message){
                   ViewHelpers.notify("success",response.message);
                 }
                 else{
                   ViewHelpers.notify("error",response.message);
                   }
               }
               else{
                if(response.message){
                    jQuery('.main_menu_'+menu_id).prop("checked",false);
                 ViewHelpers.notify("error",response.message);
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


function myFunction() {
  var x = document.getElementById("hidepass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}



$(document).ready(function(){

    $('#email').attr('autocomplete','off');
    $('#hidepass').val('');
    });


// $(document).ready(function() {
//         $("a").click(function() {
//             var yourClass = $("#test").prop("class");
//             alert(yourClass);
//           // $("a.active").removeClass("active");
//           // $(this).addClass("active");
//         });
//       });

</script>
@endsection
