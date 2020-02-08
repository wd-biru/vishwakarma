@extends('layout.app')
@section('title')
<div class="page-title">
  <div>
    <h1><i class="  fa fa-gavel"></i>&nbsp;Office Attendance</h1>
  </div>
  <div>

    <ul class="breadcrumb">
      <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
      <li><a href="#">Attendance</a></li>
      <li><a href="#">Office Attendance List</a></li>
    </ul>
  </div>
</div>
@endsection
@section('content')

<div class="row">
    <?php
 $filter_depart_id=0;
  $dateFilter=date('d/m/Y'); 
    if(isset($_GET['dateFilter'])){
      $dateFilter=$_GET['dateFilter'];
    }
     
   if(isset($_GET['department_id'])){
    $filter_project_id = $_GET['department_id'];
   }  
  ?>
    <div class="col-md-12">
        @include ('includes.msg')
        @include ('includes.validation_messages')
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="content-section">
            <div class="  table-responsive ">
                 <form method="get" action="{{route('attendence-office')}}">
            <div class="col-md-3"> 
            <label>Deaprtment <span style="color:red"> *</span></label>
            <select class="form-control" name="department_id" id="departmentList">
                <label >Department <span style="color:red"> *</span></label>
                <option value="ALL">All</option>
                @foreach($department_filter_data as $p)
                    <option @if(isset($_GET['department_id']) && ($filter_depart_id== $p->id)) selected @endif value="{{$p->id}}">{{$p->department_name}}</option>
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
                <table class="table table-bordered main-table search-table " >
                    <thead>
                        <tr class="t-head">
                            <th>Sr. No.</th>
                            <th>Employee</th>
                            <th>Department</th>
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
                        @foreach($attend_all_list as $list)
                        <?php
                            $check_projectemp = DB::table('vishwa_employee_project_mapping')->where('employee_id',$list->employee_id)->get();
                            $approve_by = DB::table('vishwa_employee_profile')->where('id',$list->approve_by)->first();
                        ?>
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$list->first_name}}&nbsp;{{$list->last_name}}</td>
                            <td>{{$list->department_name}}</td>
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
                                @if(count($check_projectemp)==0)
                                    @if($list->approve_by==null)
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
                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- BANK MODAL -->
<div id="googleMap" style="position: initial;    overflow: hidden;"></div>
<div class="modal fade" id="map" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </div>
                <h4 class="modal-title" id="myModalLabel">Loaction<span style="color:red"> *</span></h4>
            </div>
             
            <div class="modal-body">
                
            </div>
                     
        </div>
    </div>
</div>
 
@endsection
@section('script')
    <script>
        if(typeof window.history.pushState == 'function') {
            window.history.pushState({}, "Hide", "http://localhost/Vishwa/employee/Attendence/Office");
        }

    jQuery(".dateofbirth").datepicker({
        format: 'dd/mm/yyyy',
        startDate:'-100y',
        autoclose: true,
        todayHighlight: true,
        // endDate: "-18y",
    });

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
