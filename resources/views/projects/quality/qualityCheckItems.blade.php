@extends('layout.app')


@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>&nbsp;{{ trans('project.qc')}} </h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li>{{ link_to_route('projects.index',trans('project.projects'), ['status_id' => request('status_id', $project->status_id)]) }}</li>
                <li>{{ $project->present()->projectLink }}</li>
                {{--<li class="active">{{ isset($title) ? $title :  trans('project.details') }}</li>--}}
            </ul>
        </div>
    </div>

@endsection




@section('content')


    @include('includes.msg')
    @include('includes.validation_messages')


    {{--<form action="{{route('qualityCheck.index',$project->id)}}" method="get">--}}
    {{--<input  class="datepicker" name="from_date" id="to_from_date" placeholder="From Date" value="@date($from_Date)" style="--}}
    {{--font-size: 14px;" required>--}}
    {{--<input  class="datepicker" name="to_date" id="to_to_date" placeholder="To Date" value="@date($to_Date)" style="--}}
    {{--font-size: 14px;">--}}

    {{--<button type="submit" class="btn btn-success">Submit</button>--}}

    {{--</form>--}}



    @if(Auth::user()->user_type == 'employee')
        <?php
        $userStage = Auth::user()->getEmp->getUserStage(null);
        ?>
        @if($userStage!="")
            @if($vendorItem->isEmpty())
                Indent list is empty.So,{{ link_to_route('indentResorurce.addindent', 'Add Indent', [$project->id]) }}.
            @endif
        @endif
    @else
        @if($vendorItem->isEmpty())
            Indent list is empty.So,{{ link_to_route('indentResorurce.addindent', 'Add Indent', [$project->id]) }}.
        @endif
    @endif



    {{--{{dd($vendorItem)}}--}}
    <form action="{{route('qualityCheck.store',$project->id)}}" method="post">
        {{csrf_field()}}
        @if(Auth::user()->user_type == 'employee')
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive" style="width:100%">
                        <table id="data-table" class="well table-hover table-striped table-bordered search-table">
                            @if(count($vendorItem)!= 0)
                                <thead class="t-head">
                                <tr class="tab-text-align">
                                    <th>Sr.</th>
                                    <th>Challan No.</th>
                                    <th>Purchase Order No.</th>
                                    <th>qty</th>
                                    <th>unit</th>
                                    <th>As Per Vendor</th>
                                    <th>As Per System</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>
                                @foreach($vendorItem as $value)

                                    <tr class="tab-text-align">
                                        <td>{{$i++}}</td>
                                        <td>
                                            {!! Form::model($project, ['route' => ['indentResorurce.getindentdata', $project->id], 'method' => 'post' ]) !!}
                                            {{csrf_field()}}
                                            <input type="hidden" name="unique_no" value="{{$value->indent_id}}">
                                            <button type="submit" class="btn btn-link">{{$value->indent_id}}</button>
                                            {!! Form::close() !!}</td>
                                        <td>
                                            @if($value->is_active==1)
                                                <img src="{{ my_asset('images/activate.png') }}">
                                            @else
                                                <img src="{{my_asset('images/deactivate.png')}}">
                                            @endif
                                        </td>
                                        <td>
                                            <label>{{$value->user_name}}</label>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            {{date('d-m-Y', strtotime($value->created_at))}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive" style="width:100%">

                        <table id="data-table" class="table table-striped table-bordered ">
                            @if(count($vendorItem)!= 0)
                                <thead class="t-head">
                                <tr class="tab-text-align">
                                    <th style="text-align:center;">Sr.</th>
                                    <th style="text-align:center;">Item Name</th>
                                    <th style="text-align:center;">Unit</th>
                                    <th style="text-align:center;">Qty</th>
                                    <th style="text-align:center;">As Per Vendor</th>
                                    <th style="text-align:center;">As Per System</th>
                                    {{--<th style="text-align:center;">Status</th>--}}
                                    <th style="text-align:center;">Remarks</th>
                                    <th style="text-align:center;">Challan\Bill</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>


                                @foreach($vendorItem as $value)

                                    <input type="hidden" name="emp_id" value="{{$emp_id}}">
                                    <input type="hidden" name="portal_id" value="{{$value->portal_id}}">
                                    <input type="hidden" name="project_id" value="{{$value->project_id}}">
                                    <input type="hidden" name="store_id" value="{{$value->store_id}}">
                                    <input type="hidden" name="indent_id" value="{{$value->indent_id}}">
                                    <input type="hidden" name="vendor_id" value="{{$value->vendor_id}}">
                                    <input type="hidden" name="item_id[]" value="{{$value->item_id}}">
                                    <input type="hidden" name="unit[]" value="{{$value->unit}}">
                                    <input type="hidden" name="qty[]" value="{{$value->qty}}">
                                    <input type="hidden" name="qc_date" value="{{\Carbon\Carbon::now()}}">
                                    <input type="hidden" name="challan_no" value="{{$challan_no}}">
                                    <input type="hidden" name="purchase_order_no" value="{{$value->purchase_order_no}}">
                                    <input type="hidden" name="driver_name" value="{{$gateEntryChallan->driver_name}}">
                                    <input type="hidden" name="driver_mobile" value="{{$gateEntryChallan->driver_mobile}}">

                                    <tr class="tab-text-align">
                                        <td style="text-align:center;">{{$i++}}</td>
                                        <td style="text-align:center;">{{$value->material_name}}</td>
                                        <td style="text-align:center;">{{$value->unit}}</td>
                                        <td style="text-align:center;">{{$value->qty}} </td>
                                        <td style="text-align:center;"><input type="text" name="as_per_vendor[]"
                                                                              id="as_per_vendor_id" @if($flag==0) value="{{$value->qty}}" readonly @else value="" @endif></td>
                                        <td style="text-align:center;"><input type="text" name="as_per_system[]"
                                                                             @foreach($qcCheckedEntry as $qc)
                                                                             @if($qc->item_id==$value->item_id)
                                                                             value="{{$qc->as_per_system}}" readonly
                                                                              @endif
                                                                              @endforeach
                                                                              id="as_per_system_id"></td>
                                        {{--<td style="text-align:center;"><input type="checkbox" name="qc_status" value=""--}}
                                                                              {{--id="qc_status_c"></td>--}}
                                        <td style="text-align:center;"><textarea name="qc_remarks[]"
                                                                                 @foreach($qcCheckedEntry as $qc)
                                                                                 @if($qc->item_id==$value->item_id)
                                                                                 value="{{$qc->remarks}}" readonly
                                                                                 @endif
                                                                                 @endforeach
                                                                                 id="qcheck_remarks"></textarea></td>
                                       <td style="text-align:center;"> <select name="challan_bill" disabled>
                                            <option value="challan">Challan</option>
                                            <option value="challan">Bill</option>
                                        </select>
                                       </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            @endif
                        </table>

                        @if(($qcCheckedEntry->isNotEmpty()))
                            <input type="submit" class="btn btn-info" style="margin-left:43%;" value="Checked" disabled>
                            @else

                        <input type="submit" class="btn btn-info" style="margin-left:43%;">
                            @endif

                    </div>
                </div>
            </div>
        @endif

    </form>




    <!-- Material for Vendor Portal Mapping -->


    {{--@foreach($record as $value)--}}
    {{--<div class="modal fade" id="modalGetQuoto_{{$value->id}}" tabindex="-1" role="dialog"--}}
    {{--aria-labelledby="exampleModalLongTitle" aria-hidden="true">--}}
    {{--<div class="modal-dialog" role="document">--}}
    {{--<div class="modal-content">--}}
    {{--<div class="modal-header">--}}
    {{--<button type="button" class="close" style="padding-left: 130px" data-dismiss="modal"--}}
    {{--aria-label="Close">--}}
    {{--&times;--}}
    {{--</button>--}}
    {{--<h5 class="modal-title" id="exampleModalLongTitle">Vendor List</h5>--}}
    {{--</div>--}}
    {{--<div class="modal-body">--}}

    {{--{!! Form::model($project, ['route' => ['indentResorurce.getQuoteStore', $project->id], 'method' => 'post' ]) !!}--}}
    {{--{{csrf_field()}}--}}
    {{--<input type="hidden" name="value_id" value="{{$value->id}}">--}}
    {{--<input type="hidden" name="project_id" value="{{$project->id}}">--}}
    {{--<input type="hidden" name="indent_id" value="{{$value->indent_id}}">--}}
    {{--<input type="hidden" name="created_by" value="{{$value->user_name}}">--}}
    {{--<input type="hidden" name="created_date" value="{{$value->created_at}}">--}}

    {{--<div class="modal-body">--}}


    {{--<div class="table-responsive">--}}
    {{--<table id="example" class="table table-striped table-bordered dataTable no-footer example"--}}
    {{--cellspacing="0" width="100%" role="grid" aria-describedby="example_info"--}}
    {{--style="width: 100%;">--}}
    {{--<thead>--}}
    {{--<tr>--}}
    {{--<th>Vendor List</th>--}}

    {{--</tr>--}}
    {{--</thead>--}}
    {{--<tbody>--}}
    {{--<tr>--}}
    {{--<td>--}}
    {{--<select class="form-control vendor_id" required="" name="vendor_id[]" multiple>--}}
    {{--@if(isset($vendor_reg))--}}
    {{--@foreach ($vendor_reg as $list)--}}
    {{--<option @if(isset($vendor_reg))--}}
    {{--@foreach ($VishwaVendorIndent as $val) @if($val->vendor_id == $list->id && $value->indent_id == $val->indent_id ) selected="selected"--}}
    {{--@endif--}}

    {{--@endforeach--}}
    {{--@endif value="{{$list->id}}">{{ $list->company_name}}</option>--}}
    {{--@endforeach--}}
    {{--@endif--}}
    {{--</select>--}}
    {{--</td>--}}
    {{--</tr>--}}
    {{--</tbody>--}}
    {{--</table>--}}
    {{--</div>--}}
    {{--<div class="modal-footer">--}}
    {{--<div class="form-group">--}}
    {{--<div class="col-sm-offset-3 col-sm-9">--}}
    {{--<button type="submit" class="btn btn-primary pull-right">Submit</button>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--{!! Form::close() !!}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--@endforeach--}}
    <!--End  Material for Vedor Portal Mapping -->



@endsection
@section('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script type="text/javascript">
        jQuery('.vendor_id').width('74%').select2({
            tags: true,
            tokenSeparators: [','],
            placeholder: "Share Document With"
        });

        $(function () {
            $("#to_from_date").datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                }
            );


            $("#to_to_date").datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
            });
        });

        jQuery('#qc_status_c').change(function () {
            if (jQuery('#qc_status_c').is(':checked')) {
                jQuery('#qc_status_c').val('check');
            }
            else {
                jQuery('#qc_status_c').val('uncheck');
            }
        });

    </script>




@endsection



 
 
