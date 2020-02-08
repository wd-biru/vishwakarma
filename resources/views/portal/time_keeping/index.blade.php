@extends('layout.app')
@section('title')
    <div class="page-title">
        <div class="div">
            <h1><i class="fa fa-clock-o"></i> Time Keeping</h1>
        </div>
        <div class="div">
            <ul class="breadcrumb">
                <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="#">Time Keeping</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div> <a href="#"  data-toggle="modal" data-target="#basicModal"><button class="btn btn-primary "><i class="fa fa-plus"></i>&nbsp;Add Time Sheet</button></a>
                </div>
            </div>
        </div>
    </div>
</div>

  <center>@if(Session::has('success'))
            <font style="color:red">{!!session('success')!!}</font>
        @endif</center><br>

    <div class="row">
        <div class="col-md-12">
            <div class="content-section">
            @if(isset($time_sheet_list) && !empty($time_sheet_list))
            <table  class="table table-bordered main-table search-table">
                 <thead>
                    <tr class="btn-primary-th">
                        <th>Sr. No</th>
                        <th>Client Name</th>
                        <th>User name</th>
                        <th>Task Type</th>
                        <th>Comment</th>
                        <th>Start Date</th>
                        <th>Created Date</th>
                        <th>Working Hour</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody><?php $i=1;?>
                    @foreach($time_sheet_list as $sheet_list)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$sheet_list->getClientName->Client_name}}</td>
                            <td>{{Auth::user()->name}}</td>
                            <td>{{$sheet_list->work_type}}</td>
                            <td>{{$sheet_list->comment}}</td>
                            <td>{{Carbon\Carbon::parse($sheet_list->from_date)->format('d/m/Y')}}</td>
                            <td>{{Carbon\Carbon::parse($sheet_list->created_at)->format('d/m/Y')}}</td>
                            <td>{{$sheet_list->hour }} Hour</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" data-toggle="modal" data-id="{{$sheet_list->id}}" data-client_id="{{$sheet_list->client_id}}" data-task_type="{{$sheet_list->task_type}}" data-comment="{{$sheet_list->comment}}" data-from_date="{{Carbon\Carbon::parse($sheet_list->from_date)->format('d/m/Y')}}" data-hour="{{$sheet_list->hour}}"  class="EditTimeSheet" title="Edit"><i class="fa fa-edit"></i>Edit</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                   @endforeach
                </tbody>
            </table>
            @endif
            @if(isset($filter_data) && !empty($filter_data))
            <table  class="table table-bordered main-table search-table">
                <thead>
                    <tr>
                        <th>Client Name</th>
                        <th>User Name</th>
                        <th>Task Type</th>
                        <th>Comment</th>
                        <th>Start Date</th>
                        <th>Working Hour</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($filter_data as $sheet_list)
                        <tr>

                            <td>{{$sheet_list->getClientName->Client_name}}</td>
                            <td>{{Auth::user()->name}}</td>
                            <td>{{$sheet_list->work_type}}</td>
                            <td>{{substr($sheet_list->comment,0,10)}}...<a class="ShowComment"  data-val="{{$sheet_list->comment}}">View More</a></td>
                            <td>{{Carbon\Carbon::parse($sheet_list->from_date)->format('d/m/Y')}}</td>
                            <td>{{$sheet_list->hour }} Hour</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            </div>
        </div>
    </div>
    <div class="modal fade" id="showcommentModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
                    <h4 class="modal-title" id="myModalLabel">View Comment </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="" method="post">
                        <input type="hidden" name="client_id" id="client_id" value="">
                        <input type="hidden" name="instra_year_comment" id="instra_year_comment" value="">
                        <input type="hidden" name="instra_month_comment" id="instra_month_comment" value="">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea rows="4" class="form-control" id="commentshow" name="comment" required readonly></textarea>
                            </div>
                        </div>
                    </form>
                    <div id="comment-vat" style="max-height:330px; overflow-y: scroll; overflow-x: hidden;"></div>
                </div>
            </div>
        </div>
    </div>

<!--## ADD LOG WORK MODAL-->
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
                <h4 class="modal-title" id="myModalLabel">Log Work</h4>
            </div>
            <div class="modal-body tabshorizontal ">
                <form action="{{route('saveTimeSheet')}}" method="post">
                    {{csrf_field()}}
                    <fieldset>
                        <legend>Entry Information</legend>
                        <div class="form-group">
                            <label class="control-label col-md-4">Client</label>
                            <div class="col-md-8">
                                <select class="form-control" name="client_id" required>
                                    @foreach($client_list as $list)
                                        <option value="{{$list->id}}">{{$list->Client_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <label class="control-label col-md-4">Type</label>
                            <div class="col-md-8">
                                <select class="form-control" name="task_type" required>
                                    @foreach($work_type as $list)
                                        <option value="{{$list->id}}">{{$list->work_type}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <fieldset>
                                <legend>Description</legend>
                                <textarea class="form-control" rows="4" name="comment" required></textarea>
                            </fieldset>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <legend>Date</legend>
                                    <input type="text" class="form-control DisableFutureDatepicker" name="from_date" required>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <legend>Working Hour</legend>
                                    <input type="text" class="form-control floating" name="hour" minlength="0" maxlength="9" required>
                                </fieldset>
                            </div>
                        </div>
                    </fieldset>
                    <div class="modal-footer">
                        <input type="submit" value="Submit" class="btn btn-primary pull-right">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--## UPDATE LOG WORK MODAL-->
<div class="modal fade" id="edit_time_sheet_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
                <h4 class="modal-title" id="myModalLabel">Update Log Work</h4>
            </div>
            <div class="modal-body tabshorizontal ">
                <form action="{{route('editTimeSheet')}}" method="post">
                    <input type="hidden" name="update_id" id="update_id">
                    {{csrf_field()}}
                    <fieldset>
                        <legend>Entry Information</legend>
                        <div class="form-group">
                            <label class="control-label col-md-4">Client:</label>
                            <div class="col-md-8">
                                <select class="form-control" name="client_id" id="client_id" required>
                                   @foreach($client_list as $list)
                                        <option value="{{$list->id}}">{{$list->Client_name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <label class="control-label col-md-4">Type:</label>
                            <div class="col-md-8">
                                <select class="form-control" name="task_type" id="edit_task_type" required>
                                     @foreach($work_type as $list)
                                        <option value="{{$list->id}}">{{$list->work_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <fieldset>
                                <legend>Description</legend>
                                <textarea class="form-control" rows="4" name="comment" id="edit_comment" required></textarea>
                            </fieldset>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <legend>Date</legend>
                                    <input type="text" class="form-control DisableFutureDatepicker" name="from_date" id="edit_from_date" required>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <legend>Working Hour:</legend>
                                    <input type="text" class="form-control floating " name="hour" id="edit_hour" required>
                                </fieldset>
                            </div>
                        </div>
                    </fieldset>
                    <div class="modal-footer">
                        <input type="submit" value="Update" class="btn btn-primary pull-right">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script type="text/javascript">

        jQuery(function(){
            var vil={
                init:function(){

                    vil.date();
                    vil.select();
                    vil.showModal();
                    vil.tillDate();
                    vil.showCommentFun();
                    $(".floating").keydown(function (event) {


                        if (event.shiftKey == true) {
                            event.preventDefault();
                        }

                        if ((event.keyCode >= 48 && event.keyCode <= 57) ||
                            (event.keyCode >= 96 && event.keyCode <= 105) ||
                            event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                            event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

                        } else {
                            event.preventDefault();
                        }

                        if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                            event.preventDefault();
                        //if a decimal has been added, disable the "."-button

                    });
                    console.log('hello');
                },

                date:function(){
                    jQuery(".datepicker").datepicker({
                        autoclose: true,
                        todayHighlight: true,
                        format: 'dd/mm/yyyy'
                    });

                },
                tillDate:function(){
                    jQuery(".DisableFutureDatepicker").datepicker({
                        format: 'dd/mm/yyyy',
                        autoclose: true,
                        todayHighlight: true,
                        endDate: "today",
                    });
                },
                select:function(){
                    jQuery('.tags').select2({
                        tags: true,
                        tokenSeparators: [','],
                        placeholder: "Add Task Type"
                    });
                },
                showCommentFun:function(){

                        jQuery('.ShowComment').on('click',function(){
                        jQuery('#commentshow').val(jQuery(this).data('val'));
                         $('#showcommentModel').modal('show');

                    });
                },
                showModal:function(){
                        jQuery('.EditTimeSheet').on('click',function(){
                        jQuery('#update_id').val(jQuery(this).data('id'));
                        jQuery('#client_id').val(jQuery(this).data('client_id'));
                        jQuery('#edit_task_type').val(jQuery(this).data('task_type'));
                        jQuery('#edit_comment').val(jQuery(this).data('comment'));
                        jQuery('#edit_from_date').val(jQuery(this).data('from_date'));
                        jQuery('#edit_hour').val(jQuery(this).data('hour'));
                        jQuery('#edit_time_sheet_model').modal('show');
                    });
                },
            }
            vil.init();
        });
    </script>
@endsection
