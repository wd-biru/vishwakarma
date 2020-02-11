@extends('layout.project')


@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>&nbsp;{{ trans('project.jobs')}} </h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li>{{ link_to_route('projects.index',trans('project.projects'), ['status_id' => request('status_id', $project->status_id)]) }}</li>
                <li>{{ $project->present()->projectLink }}</li>
                <li class="active">{{ isset($title) ? $title :  trans('project.details') }}</li>
            </ul>
        </div>
    </div>

@endsection

@section('content-project')


    @include('includes.msg')
    @include('includes.validation_messages')




@section('action-buttons')
    @if(Auth::user()->user_type == 'employee')
        <?php
        $userStage = Auth::user()->getEmp->getUserStage(null);
        ?>
        @if($userStage!="")
            {!! html_link_to_route('indentResorurce.addindent', 'Add Indent', [$project->id], ['class' => 'btn btn-success','icon' => 'plus']) !!}
        @endif
    @else
        {!! html_link_to_route('indentResorurce.addindent', 'Add Indent', [$project->id], ['class' => 'btn btn-success','icon' => 'plus']) !!}
    @endif
@endsection

@if(Auth::user()->user_type == 'employee')
    <?php
    $userStage = Auth::user()->getEmp->getUserStage(null);
    ?>
    @if($userStage!="")
        @if($record->isEmpty())
            Indent list is empty.So,{{ link_to_route('indentResorurce.addindent', 'Add Indent', [$project->id]) }}.
        @endif
    @endif
@else
    @if($record->isEmpty())
        Indent list is empty.So,{{ link_to_route('indentResorurce.addindent', 'Add Indent', [$project->id]) }}.
    @endif
@endif






@if(Auth::user()->user_type == 'employee')
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive" style="width:100%">
                <table id="data-table" class="table table-striped table-bordered search-table">
                    @if(count($record)!= 0)
                        <thead class="t-head">
                        <tr class="tab-text-align">
                            <th>Sr.</th>
                            <th>Indent No.</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;?>
                        @foreach($record as $value)

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
                <table id="data-table" class="table table-striped table-bordered search-table">
                    @if(count($record)!= 0)
                        <thead class="t-head">
                        <tr class="tab-text-align">
                            <th>Sr.</th>
                            <th>Indent No.</th>
                            <th>Created By</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;?>
                        @foreach($record as $value)

                            <?php

                            $indentExist = \App\Models\VishwaPurchaseOrder::where('indent_id', $value->indent_id)
                                ->first();

                            ?>
                            <tr class="tab-text-align">
                                <td>{{$i++}}</td>
                                <td>

                                    @if($indentExist!=null)
                                        <form method="post" action="{{route('getPurchaseItem')}}">
                                            {{csrf_field()}}
                                            <input type="hidden" name="vendor_id" value="{{$indentExist->vendor_id}}">
                                            <input type="hidden" name="indent_no" value="{{$indentExist->indent_id}}">
                                            <input type="hidden" name="purchase_order_no" value="{{$indentExist->purchase_order_no}}">
                                            <button type="submit" class="btn btn-link">{{$value->indent_id}}</button>
                                        </form>
                                    @else
                                        {!! Form::model($project, ['route' => ['getindentPriceList', $project->id], 'method' => 'post' ]) !!}
                                        {{csrf_field()}}
                                        <input type="hidden" name="unique_no" value="{{$value->indent_id}}">
                                        <button type="submit" class="btn btn-link">{{$value->indent_id}}</button>
                                        {!! Form::close() !!}
                                    @endif
                                </td>
                                <td>
                                    <label>{{$value->user_name}}</label>
                                </td>
                                <td>
                                    {{date('d-m-Y', strtotime($value->created_at))}}
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                                data-toggle="dropdown">Action
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" style="margin-right:5px;">
                                            @if($value->current_status == null)
                                                <li><a href="#" data-toggle="modal"
                                                       data-indent-id="{{$value->indent_id}}"
                                                       data-target="#modalGetQuoto_{{$value->id}}"><i class="fa fa-eye"
                                                                                                      aria-hidden="true"></i>&nbsp;Get
                                                        Quote</a></li>
                                            @endif

                                            <li>
                                                {!! Form::model($project, ['route' => ['indentResorurce.getindentdata', $project->id], 'method' => 'post' ]) !!}
                                                {{csrf_field()}}
                                                <input type="hidden" name="unique_no" value="{{$value->indent_id}}">
                                                <button type="submit" class="btn btn-link">View Vendor Price</button>
                                                {!! Form::close() !!}
                                            </li>

                                        </ul>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
    </div>
@endif




<!-- Material for Vendor Portal Mapping -->


@foreach($record as $value)
    <div class="modal fade" id="modalGetQuoto_{{$value->id}}" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal"
                            aria-label="Close">
                        &times;
                    </button>
                    <h5 class="modal-title" id="exampleModalLongTitle">Vendor List</h5>
                </div>
                <div class="modal-body">

                    {!! Form::model($project, ['route' => ['indentResorurce.getQuoteStore', $project->id], 'method' => 'post' ]) !!}
                    {{csrf_field()}}
                    <input type="hidden" name="value_id" value="{{$value->id}}">
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <input type="hidden" name="indent_id" value="{{$value->indent_id}}">
                    <input type="hidden" name="created_by" value="{{$value->user_name}}">
                    <input type="hidden" name="created_date" value="{{$value->created_at}}">

                    <div class="modal-body">


                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered dataTable no-footer example"
                                   cellspacing="0" width="100%" role="grid" aria-describedby="example_info"
                                   style="width: 100%;">
                                <thead>
                                <tr>
                                    <th>Vendor List</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>

                                        <?php
                                        $supplier_item_reg = DB::table('vishwa_indent_items')
                                            ->join('vishwa_materials_item', 'vishwa_indent_items.item_id', 'vishwa_materials_item.id')
                                            ->where('indent_id', $value->indent_id)
                                            ->first();


                                        ?>


                                        <select class="form-control vendor_id" required="" name="vendor_id[]" multiple>
                                            @if(isset($vendor_reg))
                                                @foreach ($vendor_reg as $list)

                                                    <?php
                                                    $supplier_match = explode(',', $list->supplier_of);

                                                    ?>
                                                    @foreach ($supplier_match as $match)

                                                        @if($match == $supplier_item_reg->group_id)
                                                            <option @if(isset($vendor_reg))
                                                                    @foreach ($VishwaVendorIndent as $val)
                                                                    @if($val->vendor_id == $list->id && $value->indent_id == $val->indent_id ) selected="selected"
                                                                    @endif

                                                                    @endforeach
                                                                    @endif value="{{$list->id}}">{{ $list->company_name}}</option>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endforeach
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

    </script>




@endsection



 
 
