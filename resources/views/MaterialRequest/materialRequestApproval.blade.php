@extends('layout.app')

@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-dashboard"></i></h1>
        </div>
        <div>
            <ul class="breadcrumb">


            </ul>
        </div>
    </div>

@endsection
@section('content')
    <div class="row" style="background: white;margin:1px">
        <div class="col-md-12">
            {{--<form action="{{route('indentResorurce.downloadPDF',$project->id)}}" method="post">--}}

            {{--{{csrf_field()}}--}}
            {{--@if(count($indent)> 0)--}}
            {{--@foreach($indent as $list)--}}
            {{--<input type="hidden" name="unique_no" value="{{$list->indent_id}}">--}}
            {{--@endforeach--}}
            {{--@endif--}}
            {{--<button class="btn btn-primary" style="float: right;margin-bottom:2%; margin-top:2%!important;">Download--}}
            {{--PDF--}}
            {{--</button>--}}
            {{--</form>--}}

        </div>


        <?php
        use App\Models\IndentMaster;use App\Models\VishwaIndentVendorsPrice;use App\Models\VishwaPurchaseOrder;use App\Models\WorkFlowMaster;use App\Models\WorkflowPlace;

        $workFlowName = WorkFlowMaster::where('name', 'MRequest Flow')->first();
        $workflowId = \App\Models\WorkflowTransitions::where('workflow_id', $workFlowName->id)->orderBy('id', 'DESC')->first();
        $workflowPlace = \App\Models\WorkflowPlace::where('workflow_id', $workFlowName->id)->orderBy('id', 'DESC')->first();

        $workflow = App\Http\Controllers\Controller::getMReqWorkFlow($vendor_mapping_detail, 'MRequest Flow');


        if ($vendor_mapping_detail->current_status == null) {
            $stage = '';
        } else {
            $stage = $vendor_mapping_detail->toCheckStage($workflow, $vendor_mapping_detail);
        }



        ?>
        <div class="row" style="padding: 0 5px;">
            @if(isset($vendor_mapping_detail))
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <sapn>Indent Details</sapn>
                                <span class="pull-right"> Status : <?php echo ($stage == null) ? "Done" : $stage; ?> </span>
                            </h3>
                            <h3 class="panel-title"></h3>
                        </div>
                        <div class="panel-body">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-12" style="font-size: 15px">
                                            <p><span> Indent Number: {{$vendor_mapping_detail->mreq_no}}</span> <span
                                                        style="float: right;">Created Date: {{date('d-m-Y', strtotime($vendor_mapping_detail->created_at))}}</span>
                                            </p>
                                            <p>
                                                {{--<span> Created By: {{$vendor_mapping_detail->getCreatorDetails->name}}</span>--}}
                                                <span style="float: right;">
                            <a href="#" data-toggle="tooltip" data-placement="left" title="Download PDF">
                              <i class="fa fa-paperclip fa-4x" style="font-size: 27px;"></i>
                            </a>
                          </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 style="font-size: 20px; margin-top: 0px; margin-bottom: 8px;">Indent
                                                Track:</h3>
                                        </div>
                                        <div class="col-md-12" style="font-size: 15px;">
                                            @foreach($indentStatus as $status)
                                                <div class="col-md-6">

                                                    <?php $users = App\User::where('id', $status->changed_by)->first();  ?>
                                                    @if($users!=null)
                                                        @if($users->user_type == "employee")
                                                            <?php $employee = $users->getEmp;  ?>
                                                            <span>{{$employee->first_name}}{{$employee->last_name}}
                                                                ({{$employee->getDesignation->designation}})
                                                                @elseif($users->user_type == "portal")
                                                                    <span>{{$users->name}}{{$users->surname}}
                                                                        (Admin)</span>
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    @if($status->status==0)
                                                        <span style="float: center;color :red">Rejected</span>
                                                    @else
                                                        <span style="float: center;color :green">Approved</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    <span style="float: right;">@date($status->changed_date)</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if( Auth::user()->user_type == "employee")

                                @php
                                    $userStage =Auth::user()->getEmp->getUserStage($stage);
                                @endphp
                            @else
                                @php
                                    $userStage=$stage;
                                @endphp
                            @endif

                            <div class="panel panel-info">

                                <div class="panel-heading">

                                    <div class="row">
                                        @if(Auth::user()->user_type != "employee")

                                            @if ($workflowId->place_from_id != $workflowId->place_to_id)
                                                <div class="col-md-12">
                                                    <h3 style="font-size: 20px; margin-top: 0px; margin-bottom: 8px;">
                                                        Share
                                                        With:</h3>
                                                </div>
                                            @endif
                                        @else
                                            @if($userStage == $stage || Auth::user()->user_type != "employee")

                                                @if ($vendor_mapping_detail->current_status==null)
                                                    <div class="col-md-12">
                                                        <h3 style="font-size: 20px; margin-top: 0px; margin-bottom: 8px;">
                                                            Approval
                                                            And
                                                            Rejection:</h3>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                        <div class="col-md-12" style="font-size: 15px">
                                            <div class="col-md-12" style="margin-bottom: 2px;">


                                                {{--@if($userStage == $stage || Auth::user()->user_type != "employee")--}}

                                                {{--@if ($vendor_mapping_detail->current_status==null)--}}

                                                {{--@if($vendor_mapping_detail->getVendorsPrice()->count()>0)--}}
                                                {{--{!! Form::model($project, ['route' => ['getindentPriceList', $vendor_mapping_detail->project_id], 'method' => 'post' ]) !!}--}}
                                                {{--{{csrf_field()}}--}}
                                                {{--<input type="hidden" name="unique_no"--}}
                                                {{--value="{{$vendor_mapping_detail->indent_id}}">--}}
                                                {{--<button class="btn btn-primary form-control">Link To--}}
                                                {{--View Vendor Quote--}}
                                                {{--</button>--}}
                                                {{--{!! Form::close() !!}--}}
                                                {{--@else--}}
                                                {{--<p><b>Vendor Price Not Updated Till Date</b></p>--}}
                                                {{--@endif--}}

                                                {{--@endif--}}
                                                {{--@endif--}}

                                                @if(($userStage == $stage || Auth::user()->user_type == "portal") && $vendor_mapping_detail->is_active==1 &&  $stage!=null)
                                                    @if ($vendor_mapping_detail->current_status!=null)

                                                        @if($workflowId->trans_name!=$stage)
                                                            <form action="{{route('material.change.status')}}"
                                                                  method="post">
                                                                {{csrf_field()}}
                                                                <input type="hidden" name="request_no"
                                                                       value="{{$vendor_mapping_detail->id}}">
                                                                <textarea rows="5" name="remark"
                                                                          class="form-control"
                                                                          required=""></textarea>
                                                                <button style="float: right;margin-bottom:2%; margin-top:2%!important;"
                                                                        name="button" type="submit" value="Approved"
                                                                        class="btn btn-success">Approved
                                                                </button>
                                                                <button style="float: left;margin-bottom:2%; margin-top:2%!important;"
                                                                        name="button" type="submit"
                                                                        value="Rejection"
                                                                        class="btn btn-primary">
                                                                    Rejection
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif

                                                @elseif($stage!=null && $vendor_mapping_detail->is_active==0)
                                                    @if(Auth::user()->user_type == 'employee')
                                                        <?php
                                                        $userStage = Auth::user()->getEmp->getUserStage(null);
                                                        ?>
                                                        @if($userStage!="")
                                                            <h5 style="color:red;">Note* : Indent Is Rejected So
                                                                plese Re-create
                                                                or Edit
                                                                Indent</h5>
                                                            {!! html_link_to_route('indentResorurce.editIndent', 'Re-Create Indent', [$project->id,$vendor_mapping_detail->indent_id], ['class' => 'btn btn-success','icon' => 'plus']) !!}
                                                        @endif
                                                    @else
                                                        <h5 style="color:red;">Note* : Indent Is Rejected So
                                                            plese Re-create or
                                                            Edit
                                                            Indent</h5>
                                                        {!! html_link_to_route('indentResorurce.editIndent', 'Re-Create Indent', [$project->id,$vendor_mapping_detail->indent_id], ['class' => 'btn btn-success','icon' => 'plus']) !!}
                                                    @endif
                                                @endif

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endif


            <div class="col-md-6">
                <div class="table-responsive" style="width:100%">
                    <table id="data-table"
                           class="table table-striped table-hover table-condensed table-bordered search-table">
                        @if(count($indent)> 0)

                            <thead>
                            <tr class="tab-text-align t-head">
                                <th>Sr.</th>
                                <th>Name of Item</th>
                                <th>Remarks</th>
                                <th>Quantity</th>
                                <th>Material Unit</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;?>
                            @foreach($indent as $list)
                                <tr class="tab-text-align">
                                    <td>{{$i++}}</td>
                                    <td>{{$list->material_name}}</td>
                                    <td>@if($list->remarks ==null)

                                        @else
                                            {{$list->remarks}}

                                        @endif
                                    </td>
                                    <td>{{$list->qty}}</td>
                                    <td>{{$list->unit}}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


@endsection






