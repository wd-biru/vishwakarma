@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-money" aria-hidden="true"></i></i>&nbsp; Billing Cycle Config</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('portal.billingCycle')}}">Billing Cycle Config</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')

@include('includes.msg')
@include('includes.validation_messages')
<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-plus"></i> Add Billing Cycle</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                       {{--<button class="btn btn-primary pull-right" id="MasterBillingCycle"></button>--}}
                        <a href="" class="btn btn-primary pull-right" data-toggle="modal" data-target="#MasterBillingCycleModel">Load From Master</a>
                    </div>
                    <div class="col-md-4">
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#myBillingCycleModel">Create New Bill Cycle</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Start Create New Bill Cycle Model-->
<div class="modal fade" id="myBillingCycleModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal" aria-label="Close">
                 &times;
                </button>
                <h5 class="modal-title" id="exampleModalLongTitle">Add Billing Cycle :</h5>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{route('billingCycle.store')}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="email">Billing Cycle <span style="color: red">*</span></label>
                                </div>
                                <div class="col-md-8" style="margin-bottom: 15px;">
                                    <input type="text" name="billing_cycle" class="form-control" placeholder="Enter Billing Cycle" required="">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Create New Bill Cycle Model-->


<!--Start Load From Master Model-->
<div class="modal fade" id="MasterBillingCycleModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal" aria-label="Close">
                 &times;
                </button>
                <h5 class="modal-title" id="exampleModalLongTitle">Add Billing Cycle :</h5>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{route('billingCycle.update')}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-body" id="storeBillCycle">

                        <div class="row">
                           @foreach($billingCycle as $bill)
                               <?php
                            $billCycleExist=\App\Models\VishwaMasterBillingCycle::where('portal_id',$portal_id)
                                    ->where('billing_cycle',$bill->billing_cycle)
                                ->first();



                               ?>

                            <div class="form-group">
                                <div class="col-md-2">
                                    <input type="checkbox" name="bill_id[]" value="{{$bill->id}}" @if(($billCycleExist!=null)&&($bill->billing_cycle)==($billCycleExist->billing_cycle)) checked  @endif>
                                    </div>
                                <div class="col-md-10">
                                    <input type="text" name="billing_cycle[]" readonly class="form-control" value="{{$bill->billing_cycle}}">
                                    </div>
                                </div>
                               @endforeach
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--End Load From Master Model-->

@endsection

@section('script')
    

@endsection



