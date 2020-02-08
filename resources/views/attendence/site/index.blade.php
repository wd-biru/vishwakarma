@extends('layout.app')
@section('title')
<div class="page-title">
  <div>
    <h1><i class="  fa fa-gavel"></i>&nbsp;Site Attendance</h1>
  </div>
   <center>
        <div> 
            <p style="font-size: 15px">Today Date:<b>{{date('d/m/Y')}}</b></p>
        </div>
    </center>
  <div>
    <ul class="breadcrumb">
      <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
      <li><a href="#">Attendance</a></li>
      <li><a href="#">Site Attendance List</a></li>
    </ul>
  </div>
</div>
@endsection
@section('content')
@if(isset($authority) && $authority==false)
<div class="row">
    <div class="col-md-12"> 
            <p class="alert alert-danger"  style="font-size: 16px;">{{ $msg }}</p> 
    </div>
</div> 
@endif


<?php
 $filter_project_id=0;
  $dateFilter=date('d/m/Y'); 
    if(isset($_GET['dateFilter'])){
      $dateFilter=$_GET['dateFilter'];
    }
     
   if(isset($_GET['project_id'])){
    $filter_project_id = $_GET['project_id'];
   }  
  ?>
<div class="row">
 
     <div class="col-md-12 "> 
        <form method="get" action="{{route('attendence-site')}}">
            <div class="col-md-3"> 
            <label >Project <span style="color:red"> *</span></label>
            <select class="form-control" name="project_id" id="projectList">
                <label >Projects <span style="color:red"> *</span></label>
                <option value="ALL">All</option>
                @foreach($project_filter_data as $p)
                    <option @if(isset($_GET['project_id']) && ($filter_project_id== $p->id)) selected @endif value="{{$p->id}}">{{$p->name}}</option>
                @endforeach
            </select>
        </div>
            <div class="col-md-3"> 
            <label >Date <span style="color:red"> *</span></label>

            <input class=" form-control dateofbirth" name="dateFilter" value="{{$dateFilter}}" placeholder="Select Date" autocomplete="off">

</div>
<div class="col-md-2" style="    margin-top: 24px;"> 

            <button class="btn btn-primary" type="submit" >Submit</button>
        </div>
            
        </form>
     </div>
    <div class="col-md-12">
        
        <div class="content-section"> 
            <div class="  table-responsive ">
                <table class="table table-bordered main-table search-table " >
                    <thead>
                        <tr class="t-head">
                            <th>Sr. No.</th>
                            <th>Employee</th> 
                            <th>Projects</th> 
                            <th>Punch In</th>
                            <th>Punch Out</th>
                            <th>Working Hours</th>                            
                            <th>Approved By</th>
                            <th>Approve Working Hours</th>
                            <th>Approve Status</th>
                            <th>Location</th> 
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody><?php $i=1;?>
                    @if(isset($attend_site_list) && $attend_site_list->count()>0)
                        @foreach($attend_site_list as $list)
                        <?php 
                            $approve_by = DB::table('vishwa_employee_profile')->where('id',$list->approve_by)->first();
                        ?>
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$list->first_name}}&nbsp;{{$list->last_name}}</td> 
                            <td>{{$list->project_name}}</td> 
                            <td>{{date('d/m/Y H:i:s',strtotime($list->punch_in))}}</td>
                            <td>@if($list->punch_out!=null){{date('d/m/Y H:i:s',strtotime($list->punch_out))}}@else Punch Missed @endif</td>
                            
                            <?php  $diff_cal_hour=0; $working_hours=0;
                                if($list->punch_out!=null) { 
                                    $diff_cal_hour = abs(strtotime($list->punch_in) - strtotime($list->punch_out)); 
                                }

                                if($list->working_hours!=null) { 
                                    $working_hours = $list->working_hours*60*60; 
                                }

                               
                                    
                            ?>
                            <td>{{number_format($diff_cal_hour/(60*60),2,",",".")}}</td>
                            <td>@if($approve_by!=null){{$approve_by->first_name}}&nbsp;{{$approve_by->last_name}}@endif</td>
                            <td>{{$working_hours/(60*60)}}</td>

                            <td>
                                @if($list->approve_by==null) 
                                    <img src="{{my_asset('images/deactivate.png')}}">
                                @else
                                    <img src="{{ my_asset('images/activate.png') }}">
                                @endif 
                            </td>
                            <td>
                                <a href="" class="location" 
                                data-punch_in_lat='{{$list->punch_in_lat}}' data-punch_in_lang='{{$list->punch_in_lng}}'
                                data-punch_in_lat='{{$list->punch_out_lat}}' data-punch_in_lang='{{$list->punch_out_lng}}'>
                                Location</a>
                            </td>                              
                            <td>
                                @if(trim($list->designation) == "PROJECT MANAGER" && ucfirst(trim($list->designation)) == ucfirst("PROJECT MANAGER") && $list->approve_by==null)
                                <select name="working_hour" data-update_id="{{$list->id}}" class="approval">
                                    <option value="" >--Select Hour--</option>
                                    <option value="8" >Full Day</option>
                                    <option value="7" >7 Hour</option>
                                    <option value="6" >6 Hour</option>
                                    <option value="5" >5 Hour</option>
                                    <option value="4" >Half Day</option>
                                    <option value="3" >3 Hour</option>
                                    <option value="2" >2 Hour</option>
                                    <option value="1" >1 Hour</option> 
                                </select>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>


<div id="map" class="modal fade" role="dialog">
  <div class="modal-dialog" style="    margin-left: 262px;">
    <!-- Modal content-->
    <div class="modal-content" style="    width: 750px;    height: 450px;">
      <div class="modal-header">
        <button type="button" class="close_button" data-dismiss="modal"> 
        <i class="fa fa-times" aria-hidden="true"></i>
      </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12" >
           <div id="googleMap" style="width:100%;height:225px;"></div>
        </div>          
      </div>
      <div class="modal-footer">
      
      </div>
    </div>

  </div>
</div>
 
@endsection
@section('script')

 {{--<script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDF3oKVLu5fapO49hD-OmA6WRldQoiJl4Q&callback=initMap">
  </script>--}}
 <script> 
  

    jQuery(".dateofbirth").datepicker({
        format: 'dd/mm/yyyy',
        startDate:'-100y',
        autoclose: true,
        todayHighlight: true,
        // endDate: "-18y",
    });

    // jQuery(document).on('click','.location',function(){
    //     debugger
    //
    //     var lat = jQuery(this).data('punch_in_lat');
    //     var lang = jQuery(this).data('punch_in_lng');
    //     function initMap() {
    //       // The location of Uluru
    //       var uluru = {lat: parseFloat(lat), lng: parseFloat(lang)};
    //       // The map, centered at Uluru
    //       var map = new google.maps.Map(
    //           document.getElementById('googleMap'), {zoom: 4, center: uluru});
    //       // The marker, positioned at Uluru
    //       var marker = new google.maps.Marker({position: uluru, map: map});
    //     }
    //     jQuery('#map').modal('show');
    // });

    jQuery(document).on('change','.approval',function(){ 
        var working_hour = jQuery(this).val(); 
        if(!working_hour){
            return false;
        }
        var update_id = jQuery(this).data('update_id'); 
        var check = confirm('Are you confirm to approved '+working_hour+' Hour ?')
        if(check==false){
            return false;
        }
        jQuery.ajax({
            url:"{{route('approvedAttendence')}}",
            type:"get",
            data: {working_hour:working_hour,update_id:update_id},
            dataType:'html',
            success: function(response){ 
                if(response=='ok'){  
                    window.location.reload(); 
                }
                else{  
                    ViewHelpers.notify("error","Not Approved,please Contact to Admin."); 
                } 
            },
            error: function(err){

            }
        });
    });
</script>
@endsection
