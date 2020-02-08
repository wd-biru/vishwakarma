@extends('layout.app')
@section('title')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<style type="text/css">

#for_button {
display: block;
width: 115px;
height: 25px;
background: #4E9CAF;
padding: 10px;
text-align: center;
border-radius: 5px;
color: white;
font-weight: bold;
}



/* Absolute Center Spinner */
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: visible;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.1);
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 1500ms infinite linear;
  -moz-animation: spinner 1500ms infinite linear;
  -ms-animation: spinner 1500ms infinite linear;
  -o-animation: spinner 1500ms infinite linear;
  animation: spinner 1500ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
  box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

</style>
<div class="page-title">
    <div class="div">
        <h1><i class="fa fa-envelope"></i> E-Mail Setting</h1>
    </div>
    <div class="div">
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
            <li><a href="#">E-Mail</a></li>
        </ul>
    </div>
</div>
@endsection
@section('content')
@include('includes.msg')


@if(isset($no_sync))
<div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>No Mailchimp Sync Yet</strong>
</div>
@endif
@if(isset($not_found))
<div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>List Empty OR All Emails Are Unsubscribed </strong>
</div>
@endif




  <div id="api" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm" >
<div class="modal-content" style="
    width: 601px;
    margin-left: -137px;
">
           <form action="{{route('email.subscriber')}}" id="sub" method="post" >
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" style="padding-left: 130px;">x</button>
                    <h4>Email Subscription</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <input type="hidden" id="portal" name="portal" value="">
                    <input type="hidden" id="list_name" name="list_name" value="">
                    <label>API Key</label>
                    <input class="form-control" type="text" name="api" id="apikey" value="">
                    <br>
                    <div style="display: none" id="list_view">
                     <label>Lists</label>
   <select class="form-control" id="list" name="list">

</select>
                </div>
            </div>
                <div class="modal-footer">
     <button class="btn btn-primary" data-token="{{ csrf_token()}}" style="" type="button" value="" id="subscribe"><i class="fa fa-check"></i> Verify</button>
     <button style="display: none" class="btn btn-primary" data-token="{{ csrf_token()}}" type="submit" value="" id="submit"><i class="fa fa-check"></i> Submit</button>
                </div>
           </form>
        </div>

        </div>
</div>
<div style="">
<div class="loading" style="left: 50%;display: none" >Loading&#8230;</div>
</div>



<div class="row">
    <div class="col-md-12">
        <div class="content-section">
            <form action="{{route('email.store')}}" method="post">
                {{csrf_field()}}
                <div class="table-responsive">
                    <table  class="table table-bordered main-table search-table">
                      <!--   <div><input type="checkbox" id="select_all" on='click' ><label>Select All</label></div> -->
                        <!-- <div><input type="checkbox" id="select_all_alternate" name="alternate" value="true" ><label>Select Alternate Email</label></div> -->
                        <thead>
                            <tr class="btn-primary">
                                <th>Name</th>
                                <th>API</th>
                                <th>Email</th>
                                <th>Total Sync Contact</th>
                                <th>Company Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($portals as $portal)
                            <tr>
                                <td><!-- <input type="checkbox" class="add" value="{{$portal->id}}" name="client_id[]"> -->&nbsp;&nbsp;<a class="test" data-api="{{$portal->api}}" data-portal_id="{{$portal->id}}">{{ucfirst($portal->name)}} {{ucfirst($portal->surname)}}</td></a>
        @if($portal->api!=null)
        <td>
          <input disabled="disabled" value=" *******{{substr($portal->api, 18,23)}}" type="text" class="form-control" style="height: 20px;width:184px;">
          <a><i style="margin-left: 10px;"class="fa fa-edit update_api" data-portal_api="{{$portal->api}}" data-portal_id_update="{{$portal->id}}"></i></a>
          &nbsp;  <a class="apidelete" href="{{route('email.deleteAPI',$portal->id)}}">
              <i style="margin-left: 10px;"class="fa fa-trash"></i></a></td>
         @else
         <td>No API Inserted</td>
         @endif

                                <td>{{$portal->getUser->email}}</td>
                                <td style="text-align: center;">{{$portal->total_sync_contact}}/{{$portal->no_of_email}}</td>
                                <td>{{$portal->company_mail}}</td>
      <td><a style="width: 156px; height: 35px;" class="btn btn-primary view" href="{{route('edit-subscriber',$portal->id)}}">Manage Subscribers</a>

      </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>







  <div class="modal fade" id="myEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <form method="post" action="">
                                <div class="modal-header">
                                    {{ csrf_field() }}
                                    <button class="close" data-dismiss="modal" style="padding-left: 130px;">x</button>
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                             <legend>Email</legend>
                                                <fieldset><br>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-2">Subject&nbsp;<span style="color: #f70b0b">*</span></label>
                                                        <div class="col-md-10">
                                                        <strong><input class="form-control" type="text" name="subject"  placeholder="Enter  Subject" style="text-transform: capitalize" ></strong>
                                                    </div>
                                                    </div> <br>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-2">Composed&nbsp;<span style="color: #f70b0b">*</span></label>
                                                        <div class="col-md-10">
                                                        <textarea class="form-control" placeholder="enter sms" name="composed_email" style="height: 200px;"></textarea>
                                                    </div>
                                                    </div><br>
                                                </fieldset><br>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit" id="submit_btn" class="btn btn-primary pull-right">Send</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                           </form>
                        </div>
                    </div>
                </div>
            </form>

<div id="rtets">




  @if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>{{ $message }}</strong>
</div>
@endif


  @if(isset($sub_list))
   <div class="panel-group" id="accordion_sub" role="tablist" aria-multiselectable="true">

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Added Subscriber List
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">




<table class="table">
  <thead>
    <tr>
      <th scope="col">Email</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
     @foreach($sub_list as $result)
    <tr>
        <td>{{$result}}</td>
      <td>Subscribed</td>
    </tr>
      @endforeach
  </tbody>
</table>
</div>
</div>
</div>
</div>
 @endif


                                <!-- Mailchimp detail edit -->

<div id="update_api" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm" >
<div class="modal-content" style="
    width: 601px;
    margin-left: -137px;
">
           <form action="" id="" method="" >
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" style="padding-left: 130px;">x</button>
                    <h4>Update Mailchimp Details</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <input type="hidden" id="portal" name="portal" value="">
                    <label>API Key</label>
                    <input class="form-control" type="text" name="api" id="api_update" value="">
                    <br>


            </div>
                <div class="modal-footer">

     <button class="btn btn-primary" data-token="{{ csrf_token()}}" type="button"  value="" id="updateapi"><i class="fa fa-check"></i> Update</button>
                </div>
           </form>
        </div>

        </div>
</div>


<!--  @if(isset($mailchimp_detail))
 <div class="panel-group" id="accordion_unub" role="tablist" aria-multiselectable="true">
<div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Mailchimp Details
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                   <div class="panel-body">




<form class="form-inline" action="/action_page.php">
  <div class="form-group">
    <label for="email">API</label>
  </div>
  <div class="form-group">
<input style="margin-left: 23px;width: 326px;" type="text" class="form-control" id="" value="{{$mailchimp_detail->api}}" style="width: 326px;
">
  </div>
  <button style="
    margin-left: 73px;
" type="submit" class="btn btn-primary mb-1">Update</button>
</form>




</div>
</div>
</div>
@endif
</div>

 -->



























                              <!-- Mailchimp detail edit -->




















 @if(isset($unsub_list))
 <div class="panel-group" id="accordion_unub" role="tablist" aria-multiselectable="true">
<div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                         Already Exist Members List
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                   <div class="panel-body">




<table class="table">
  <thead>
    <tr>
      <th scope="col">Email</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
     @foreach($unsub_list as $result)
    <tr>
        <td>{{$result}}</td>
        <td>Member Exist</td>
    </tr>
      @endforeach
  </tbody>
</table>
</div>
            </div>
        </div>
        @endif
      </div>


@if(isset($data))
<div class="panel-group" id="" role="tablist" aria-multiselectable="true">
<div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                         Emails List
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                   <div class="panel-body">






<table class="table table-hover" id="subscriber_list_response">
  <thead  class="thead-dark">
    <tr>
      <th scope="col">Sr.</th>
      <th scope="col">Email</th>
      <th scope="col">API</th>
      <th scope="col">List</th>
      <th scope="col">Status</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>


<?php $i=1; ?>
   @foreach($data['emails'] as $key => $result)
    <tr>



        <td>{{$i++}}</td>
        <td>{{$result}}</td>
        <td>{{$data['api']}}</td>
        <td>{{$data['list']}}</td>

        @if($data['status'][$key]=='unsubscribed')
        <td style="color: red;">{{$data['status'][$key]}}</td>
        @else
         <td>{{$data['status'][$key]}}</td>
            @endif




<td>
@if($data['status'][$key]!='unsubscribed')
<a class="view" href="{{route('email.unsubscribe',['list' => $data['list'] ,'portal' => $data['portal'],'api' => $data['api'],'email' => $result])}}"><i  style="font-size: 14px;" class="fa fa-minus-circle" aria-hidden="true"></i>
</a>
 @else
<a class="view" href="{{route('email.subscribe',['list' => $data['list'] ,'portal' => $data['portal'],'api' => $data['api'],'email' => $result])}}"><i  style="font-size: 14px;" class="fa fa-plus-circle" aria-hidden="true"></i>
</a>
@endif

<a class="delete" href="{{route('email.delete', ['list' => $data['list'] ,'portal' => $data['portal'],'api' => $data['api'],'email' => $result])}}"><i style="font-size: 14px; margin-left: 8px;" class="fa fa-trash" aria-hidden="true"></i></a>



</td>
         </tr>



      @endforeach
  </tbody>
</table>
</div>
            </div>
        </div>
        @endif
      </div>







</div>

</div>



@endsection

@section('script')

<script type="text/javascript">
    function buttonevent(){
        if (true) {
            jQuery('.btn_email').attr('disabled',false);
        }else{
            jQuery('.btn_email').attr('disabled',true);
        }
    }

    jQuery(document).on('click','#select_all',function(){
        if(this.checked){
            jQuery('.add').each(function(){
                this.checked = true;
                buttonevent(true);

            });

        }else{
            jQuery('.add').each(function(){
                this.checked = false;
                jQuery('.btn_email').attr('disabled',true);
            });
        }
    });

    jQuery('.add').on('click',function(){
        jQuery('.btn_email').attr('disabled',false);
        if(jQuery('.add:checked').length == jQuery('.add').length){
            jQuery('#select_all').prop('checked',true);
            this.checked = true;
            jQuery('.btn_email').attr('disabled',false);
        }
        else{
            jQuery('#select_all').prop('checked',false);
            jQuery('.btn_email').attr('disabled',false);

        }
    });

       jQuery(document).on('click','#select_all_alternate',function(){

        if(this.checked){
            jQuery('.add_alternate').each(function(){
                this.checked = true;

            });

        }else{
             jQuery('.add_alternate').each(function(){
                this.checked = false;
            });
        }
    });


       // $('#subscribe').on('click',function(){


       //                  var list = $('#list').val();
       //                  var api = $('#apikey').val();


       //                  if(list === '')
       //                  {
       //                      alert('Please Enter list ID');
       //                      return false;
       //                  }
       //                  else if(api === '')
       //                  {
       //                      alert('Please Enter API Key');

       //                      return false;
       //                  }
       //                  else
       //                  {

       //                  }

       //                  $("#sub").submit();

       //              });

    jQuery('.add_alternate').on('click',function(){

        if(jQuery('.add_alternate:checked').length == jQuery('.add_alternate').length){
            jQuery('#select_all_alternate').prop('checked',true);
        }else{
            jQuery('#select_all_alternate').prop('checked',false);
        }
    });





$(document).ready(function(){
$( ".test" ).click(function() {

    $("#portal").val($(this).data('portal_id'));
    $("#apikey").val($(this).data('api'));
$('#api').modal({
show: true
});
});
});



$('#api').on('hidden.bs.modal', function () {
 location.reload();
})




$("#submit").click(function() {
$("#api").hide();
$(".loading").removeAttr("style");
});







$("#close_sub").click(function() {
  $("#accordion_sub").accordion("destroy");
  });


$("#close_unsub").click(function() {
  $("#accordion_unub").accordion("destroy");
  });





//for getting mail list


$('#subscribe').click(function() {
    var token = $(this).data('token');

    var api = $('#apikey').val();




    $.ajax({
    url: "{{route('email.list')}}",
      type: 'post',
      data: { api: api, _token: '{{csrf_token()}}' },
      dataType: 'json',
      success:function(data) {
        //console.log(data);
      $("#subscribe").hide();
      $("#submit").removeAttr("style");


      var list = $('#list');
      $("#list_view").removeAttr("style")

       var list_item='';
          $(data).each(function() {
            for (var i =0; i <data.id.length; i++) {
             list_item+='<option value='+data.id[i]+' name='+data.name[i]+' >'+data.name[i]+'</option>';
            }
            });


  $("#list").html(list_item);

          $("#subscribe").attr("type","submit");
      },
      error: function(data) {
        alert("wrong API");
      }
    });
  });




  $(".delete").click(function(){
    if (confirm("Do you want to delete"))
    {

$(".loading").removeAttr("style");


    }
    else
    {
      return false;
    }
  });



   $(".apidelete").click(function(){
    if (!confirm("Do you want to delete"))
    {
      return false;
    }
  });



                                // For API update

$('.update_api').click(function() {
    var token = $(this).data('token');

    var id = $(this).data('portal_id_update');
    var api = $(this).data('portal_api');


    $('#update_api').modal({
            show: true
            });
    $('#api_update').val(api);
    $('#portal').val(id);
     });


$('#updateapi').click(function() {
    var token = $(this).data('token');
    var api = $('#api_update').val();
    var portal = $('#portal').val();
    $.ajax({
      url: "{{route('email.updateapi')}}",
      type: 'post',
      data: { api: api, portal_id:portal, _token: '{{csrf_token()}}' },
      dataType: 'json',
      success:function(response) {

        alert('Update success');
 location.reload();

    },

      error: function(response) {
      alert('Something Went wrong');
 location.reload();
      }
    });
  });

















///API masked here
// var api_str=$('.api_str').text();
// var slice_api = api_str.slice(0, 10);
// var res = slice_api.replace(slice_api, "**************"+api_str);
// $('.api_str').text(res);
$(".view").click(function() {
$(".loading").removeAttr("style");
});



$('#subscriber_list_response').dataTable( {
    "language": {
      "emptyTable": "No data available"
    }
} );
</script>
@endsection
