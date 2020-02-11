@extends('layout.app')


@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>&nbsp;Material Receipt </h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>

            </ul>
        </div>
    </div>

@endsection

@section('content')


    @include('includes.msg')
    @include('includes.validation_messages')


    <form action="{{route('MaterialRecipt.challan_list')}}" method="get">
        <div class="row">
            <div class="col-md-2">
                <label>Projects</label>
                <select class="form-control selectable" name="project" id="project">
                    <option value="0">Please Select</option>
                    @foreach($projects as $list)
                        <option value="{{$list->id}}" @if($list->id==$project_id)selected @endif>{{$list->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>Type</label>
                <select class="form-control selectable" name="challan_bill" id="challan_bill">
                    <option value="0">Please Select</option>
                    <option value="1" @if($dataRequest==1)selected @endif>Gate Entry</option>
                    <option value="2" @if($dataRequest==2)selected @endif>Quality Check</option>

                </select>
            </div>
            <div class="col-md-2">
                <label>From Date</label>
                <input class="datepicker form-control" autocomplete="off" name="from_date" id="to_from_date" placeholder="From Date"
                       value="" style="
    font-size: 14px;" >
            </div>
            <div class="col-md-2">
                <label>To Date</label>
                <input class="datepicker form-control" autocomplete="off" name="to_date" id="to_to_date" placeholder="To Date" value=''
                       style="
    font-size: 14px;">
            </div>
            <div class="col-md-2">

                <button type="submit" class="btn btn-success form-control" style="margin-top:11%;">Submit</button>
            </div>
        </div>
    </form>



    @if(Auth::user()->user_type == 'employee')
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive" style="width:100%">
                    <table id="data-table" class="table table-striped table-bordered ">
                        @if(count($record)!= 0)
                            <thead class="t-head">
                            <tr class="tab-text-align">
                                <th>Sr.</th>
                                <th>Challan No.</th>
                                <th>Purchase Order No.</th>
                                <th>Record From</th>
                                <th>Created By</th>
                                <th>Incoming Time</th>
                                <th>PM Verification</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;?>

                            @if($gateEntry != '')
                                @foreach($gateEntry as $value)
                                    <?php $encodePur=base64_encode($value->purchase_order_no); ?>
                                    <tr class="tab-text-align">
                                        <td>{{$i++}}</td>
                                        <td>{{$value->challan_no}}</td>
                                        <td>{{$value->purchase_order_no}}</td>
                                        <td>Gate Entry</td>
                                        <td><label>{{$value->company_name}}</label></td>

                                        <td> {{date('d-m-Y , H:i:s',strtotime($value->incoming_time))}}</td>
                                        <td></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                        data-toggle="dropdown">Action
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" style="margin-right:5px;">

                                                    <li><a href="{{route('MaterialRecipt.index',[$encodePur])}}" ><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Show Items</a>


                                                </ul>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if($qualityPass != '')
                                @foreach($qualityPass as $value)
                                    <?php $encodePur=base64_encode($value->purchase_order_no); ?>
                                    <tr class="tab-text-align">
                                        <td>{{$i++}}</td>
                                        <td>{{$value->challan_no}}</td>
                                        <td>{{$value->purchase_order_no}}</td>
                                        <td>Quality Check</td>
                                        <td><label>{{$value->company_name}}</label></td>
                                        <td> {{date('d-m-Y',strtotime($value->date))}}</td>
                                        <td></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                        data-toggle="dropdown">Action
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" style="margin-right:5px;">
                                                    <li><a href="{{route('MaterialRecipt.index',[$encodePur])}}" ><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Show Items</a>
                                                    </li>

                                                </ul>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
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
                        @if(count($record)!= 0)
                            <thead class="t-head">
                            <tr class="tab-text-align">
                                <th>Sr.</th>
                                <th>Challan No.</th>
                                <th>Purchase Order No.</th>
                                <th>Record From</th>
                                <th>Created By</th>
                                <th>Incoming Time</th>
                                <th>PM Verification</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;?>

                            @if($gateEntry != '')
                                @foreach($gateEntry as $value)
                                <?php $encodePur=base64_encode($value->purchase_order_no); ?>
                                    <tr class="tab-text-align">
                                        <td>{{$i++}}</td>
                                        <td>{{$value->challan_no}}</td>
                                        <td>{{$value->purchase_order_no}}</td>
                                        <td>Gate Entry</td>
                                        <td><label>{{$value->company_name}}</label></td>

                                        <td> {{date('d-m-Y , H:i:s',strtotime($value->incoming_time))}}</td>
                                        <td></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                        data-toggle="dropdown">Action
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" style="margin-right:5px;">
                                                    <li>
                                                    <li><a href="#"  class="open_pm_verify" data-order="{{$value->purchase_order_no}}"
                                                           ><i class="fa fa-key" aria-hidden="true" ></i>&nbsp;PM Verify</a>
                                                    </li>
                                                        <li><a href="{{route('MaterialRecipt.index',[$encodePur])}}" ><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Show Items</a>
                                                    </li>
                                                    <li>

                                                        {{--{!! Form::model($project, ['route' => ['indentResorurce.getindentdata', $project->id], 'method' => 'post' ]) !!}--}}
                                                        {{--{{csrf_field()}}--}}
                                                        {{--<input type="hidden" name="unique_no" value="{{$value->indent_id}}">--}}
                                                        {{--<button type="submit" class="btn btn-link">View Vendor Price</button>--}}
                                                        {{--{!! Form::close() !!}--}}

                                                    </li>

                                                </ul>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if($qualityPass != '')
                                @foreach($qualityPass as $value)
                                    <?php $encodePur=base64_encode($value->purchase_order_no); ?>
                                    <tr class="tab-text-align">
                                        <td>{{$i++}}</td>
                                        <td>{{$value->challan_no}}</td>
                                        <td>{{$value->purchase_order_no}}</td>
                                        <td>Quality Check</td>
                                        <td><label>{{$value->company_name}}</label></td>
                                        <td> {{date('d-m-Y',strtotime($value->date))}}</td>
                                        <td></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                        data-toggle="dropdown">Action
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" style="margin-right:5px;">
                                                    <li>
                                                        <li><a href="#pm_verify"  data-order="{{$value->purchase_order_no}}"
                                                         class="open_pm_verify" ><i class="fa fa-key" aria-hidden="true" ></i>&nbsp;PM Verify</a>
                                                        </li>
                                                    <li><a href="{{route('MaterialRecipt.index',[$encodePur])}}" ><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Show Items</a>
                                                    </li>
                                                    <li>

                                                        {{--{!! Form::model($project, ['route' => ['indentResorurce.getindentdata', $project->id], 'method' => 'post' ]) !!}--}}
                                                        {{--{{csrf_field()}}--}}
                                                        {{--<input type="hidden" name="unique_no" value="{{$value->indent_id}}">--}}
                                                        {{--<button type="submit" class="btn btn-link">View Vendor Price</button>--}}
                                                        {{--{!! Form::close() !!}--}}

                                                    </li>

                                                </ul>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    @endif




    <!-- Project Manager Verification  -->



        <div class="modal fade" id="pm_verify" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal"
                                aria-label="Close">
                            &times;
                        </button>
                        <h5 class="modal-title" id="exampleModalLongTitle" style="margin-left:33%;">Project Manager Verification</h5>
                    </div>
                    <div class="modal-body">

                        <form action="{{route('MaterialRecipt.pmVerify')}}" method="get">
                        {{--{!! Form::model($project, ['route' => ['indentResorurce.getQuoteStore', $project->id], 'method' => 'post' ]) !!}--}}
                        {{csrf_field()}}
                        {{--<input type="hidden" name="value_id" value="{{$value->id}}">--}}
                        {{--<input type="hidden" name="project_id" value="{{$project->id}}">--}}
                        {{--<input type="hidden" name="indent_id" value="{{$value->indent_id}}">--}}
                        {{--<input type="hidden" name="created_by" value="{{$value->user_name}}">--}}
                        {{--<input type="hidden" name="created_date" value="{{$value->created_at}}">--}}

                        <div class="modal-body">

                            <div class="form-group">
                                <input type="hidden" name="pur_ord_no" value="" id="order_pur_no">
                                <label class="col-md-2 form-control"><strong>Login Id or Email: </strong></label>
                                <input class="col-md-2 form-control" type="text" name="loginName" placeholder="email@email.com">
                            </div>
                            <div class="form-group ">
                                <label class="col-md-2 form-control"><strong>Password</strong></label>
                                <input class="col-md-2 form-control" type="password" name="loginPass" placeholder="xxxxxxxx">
                            </div>

                            <div class="modal-footer">
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <br><br>
                                        <button type="submit" class="btn btn-primary pull-right" style="margin-right:50%;marign-top:1%;">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!--End  Material for Vedor Portal Mapping -->



@endsection
@section('script')

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>--}}
    <script type="text/javascript">
        jQuery('.vendor_id').width('74%').select2({
            tags: true,
            tokenSeparators: [','],
            placeholder: "Share Document With"
        });

        $(document).ready(function () {

            $('#to_from_date').datepicker({
                format: "dd-mm-yyyy"
            });
            //
            $('#to_to_date').datepicker({
                format: 'dd-mm-yyyy'
            });



        });


        $(document).ready(function(){
            $(".open_pm_verify").on("click", function () {

                $('#order_pur_no').val("");
                var dataName = $(this).attr("data-order");
                $('#order_pur_no').val(dataName);
                $('#pm_verify').modal('show');
            });

        });

    </script>




@endsection





