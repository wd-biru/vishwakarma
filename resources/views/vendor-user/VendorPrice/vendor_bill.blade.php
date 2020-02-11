@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Bill</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="#">Vendor Bill</a></li>
                <li><a href="#">Add</a></li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    @include('includes.msg')
    @include('includes.validation_messages')
    <style type="text/css">
        .status {
            width: 15px;
            background: none;
            color: inherit;
            border: none;
            padding: 0;
            font: inherit;
            cursor: pointer;
            outline: inherit;
        }
    </style>

    <form action="{{route('billOrderNumber')}}" method="post">
        {{csrf_field()}}
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">&nbsp;Bill Items</h3>
                    </div>
                    <div class="panel-body">
                        <div class="card col-md-12">

                            <div class="  table-responsive ">
                                <table class="table table-bordered main-table">
                                    <thead>

                                    <tr class="t-head">

                                        <th>Material Name.</th>
                                        <th>Unit.</th>
                                        <th>Quantity.</th>
                                        <th>Price</th>
                                        <th>Amount</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--{{dd($getChallan)}}--}}
                                    <?php $grossPrice = 0;
                                    $grossTax = 0;
                                    $netAmount = 0;
                                    $freight = 0;
                                    $loading = 0;
                                    $kpCharges = 0;
                                    $totalAmount = 0;
                                    ?>
                                    @foreach($getChallan as $list)
                                        <tr>

                                            <?php
                                            $material_name = App\Models\MaterialItem::where('id', $list->item_id)->first();

//                                            dd($list,$list->vendor_id,$list->purchase_order_no,$list->item_id,);
                                            $order = $list->checkQty($list->vendor_id, $list->purchase_order_no, $list->item_id, $list->orderQty)['orderQty'];
                                            $remain = $list->checkQty($list->vendor_id, $list->purchase_order_no, $list->item_id, $list->orderQty)['remainQty'];


                                            $grossPrice += ($list->qty * $list->price);
                                            $grossTax += (($list->qty * $list->price) * ($list->tax_rate / 100));
                                            $netAmount = $grossPrice + $grossTax;
                                            $freight = $list->freight;
                                            $loading = $list->loading;
                                            $kpCharges = $list->kpcharges;

                                            $totalAmount = $netAmount + $freight + $loading + $kpCharges;
                                            //                                            $netAmount+=($freight+$loading+$kpCharges);

                                            ?>
                                            <input type="hidden"
                                                   name="item_id[]"
                                                   data-project_id="{{$list->project_id}}"
                                                   data-store_id="{{$list->store_id}}"
                                                   data-qty="{{$remain}}"
                                                   data-purchase_no="{{$list->purchase_order_no}}"
                                                   data-portal_id="{{$list->portal_id}}"
                                                   data-indent_id="{{$list->indent_id}}"
                                                   data-material_name="{{$material_name->material_name}}"
                                                   data-unit="{{$list->unit}}" value="{{$list->item_id}}"
                                                   class="item_id">


                                            <td>{{$material_name->material_name}}</td>
                                                <input type="hidden" name="material_name[]"
                                                       id="material_name{{$list->item_id}}" value="{{$material_name->material_name}}">
                                            <td>{{$list->unit}}</td>
                                                <input type="hidden" name="unit[]"
                                                       id="unit{{$list->item_id}}" value="{{$list->unit}}">

                                            <td><input type="hidden" name="dispatch_qty[]"
                                                       id="dispatch_bill_qty_{{$list->item_id}}" value="{{$list->qty}}">
                                                {{$list->qty}}
                                            </td>
                                            <td id="remain_{{$list->item_id}}">
                                                <input type="hidden" name="price_list[]"
                                                       id="price_list{{$list->item_id}}" value="{{$list->price}}">
                                                <input type="hidden" name="freight_charge"
                                                       id="price_list{{$list->item_id}}" value="{{$list->freight}}">
                                                <input type="hidden" name="loading_charge"
                                                       id="loading_charge{{$list->item_id}}" value="{{$list->loading}}">
                                                <input type="hidden" name="kpcharges"
                                                       id="kpcharge{{$list->item_id}}" value="{{$list->kpcharges}}">
                                                <input type="hidden" name="item_amount[]"
                                                       id="price_list{{$list->item_id}}" value="{{($list->price * $list->qty)}}">
                                                {{$list->price}}
                                            </td>
                                            <td>{{$list->price * $list->qty}}</td>
                                                <input type="hidden" name="total_amount[]"
                                                       id="total_amount{{$list->item_id}}" value="{{($list->price * $list->qty)+
                                                       (($list->price * $list->qty) * ($list->tax_rate/100))}}">
                                                <input type="hidden" name="item_tax[]"
                                                       id="item_tax{{$list->item_id}}" value="{{($list->price*$list->qty) * ($list->tax_rate/100)}}">
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row purchase_order">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">&nbsp;Bill Details:</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">


                            <div class="col-md-6">
                                <div class="table-responsive" style="width:100%">
                                    <table id="data-table" class="table table-striped table-hover table-condensed ">

                                        <thead>
                                        <tr class="tab-text-align t-head">

                                            <th>Gross Price</th>
                                            <th>Gross Tax</th>
                                            <th>Net Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody id="">

                                        <td><strong>{{$grossPrice}}</strong></td>
                                        <td><strong>{{$grossTax}}</strong></td>

                                        <td><strong>{{$totalAmount}}</strong></td>
                                        <input type="hidden" name="gross_price" value="{{$grossPrice}}">
                                        <input type="hidden" name="gross_tax" value="{{$grossTax}}">
                                        <input type="hidden" name="net_amount" value="{{$totalAmount}}">
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Company's Name&nbsp;<span
                                                style="color: #f70b0b">*</span></label>
                                    <div class="col-md-12">

                                        <input type="text" class="form-control " name="company_name" id="company_name"
                                               value="{{($company_data->portal_name)}}" readonly>
                                        <input type="hidden" name="portal_id" value="{{$company_data->portal_id}}">
                                        <input type="hidden" name="purchase_order_no" value="{{$purchase_order_no}}">
                                        <input type="hidden" name="challan_no" value="{{$challan_no}}">

                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Company's GSTN :&nbsp;<span
                                                style="color: #f70b0b">*</span></label>
                                    <div class="col-md-12">

                                        <input type="text" class="form-control " name="company_gstn" id="company_gstn"
                                               value="{{($company_data->portal_gstn)}}" readonly>

                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Vendor's GSTN :&nbsp;<span
                                                style="color: #f70b0b">*</span></label>
                                    <div class="col-md-12">

                                        <input type="text" class="form-control " name="vendor_gstn" id="vendor_gstn"
                                               value="{{($company_data->vendor_gstn)}}" readonly>

                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Bill Date&nbsp;<span
                                                style="color: #f70b0b">*</span></label>
                                    <div class="col-md-12">
                                        <fieldset>
                                            <input type="text" class="form-control datepicker" placeholder="Date"
                                                   autocomplete="off" name="bill_date" id="date" required>
                                        </fieldset>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Bill No:&nbsp;<span
                                                style="color: #f70b0b">*</span></label>
                                    <div class="col-md-12">
                                        <input type="number" class="form-control" placeholder="Bill Number"
                                               autocomplete="off" name="bill_no" id="bill_no" required>
                                    </div>
                                </div>

                                <br>


                                <div class="col-md-4">

                                    <button type="submit" class="btn btn-primary" name="action" value="save"
                                            style="margin-top: 15px;">Submit
                                    </button>


                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>




@endsection
@section('script')
    <script>

        $(document).ready(function () {


            jQuery(".datepicker").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'dd-mm-yyyy'
            });

        });
        $(document).on("keyup", ".quantity", function () {
            var id = jQuery(this).data('id');
            var previous = jQuery("#previousQty_" + id).val();
            var current = jQuery(this).val();
            var remain_value = parseInt(previous) - parseInt(current);
            jQuery("#remain_" + id).html(remain_value);
            if (parseInt(previous) < parseInt(current)) {
                alert("Maximum Quantity Value Is :" + previous);
                jQuery(this).val(previous);
                return false;
            }
            if (parseInt(current) <= 0) {
                alert("Quantity Value Should be Greather than 0");
                jQuery(this).val(previous);
                jQuery("#remain_" + id).html(0);
                return false;
            }
        })

    </script>

@endsection

























