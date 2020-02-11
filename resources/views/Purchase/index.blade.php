@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Purchase Order</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href=""><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('PurchaseOrder.index')}}">Purchase</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
    @include('includes.msg')
    @include('includes.validation_messages')

    <div class="row">
        <div class="col-md-12">
            <div class="content-section">
                <form action="{{route('PurchaseOrder.getPurchaseData')}}" method="get">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-2">
                            <label>From Date</label>

                            <input class="datepicker" autocomplete="off" name="from_date" id="to_from_date"
                                   placeholder="From Date" value="" style="
    font-size: 14px;" required>


                        </div>
                        <div class="col-md-2">
                            <label>To Date</label>

                            <input class="datepicker" autocomplete="off" name="to_date" id="to_to_date"
                                   placeholder="To Date" value="" style="
    font-size: 14px;">

                        </div>
                        <div class="col-md-1">
                            <label>&nbsp;</label>
                            <br>
                            <button type="submit" id="go" class="btn btn-primary">Go</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="row" id="purchaseData">
        <div class="col-md-12">
            <div style="margin-top: 10px;background: #fff;padding: 15px;">
                <table class="table  ">
                    <thead>
                    <tr>
                        <th>Sr. No</th>
                        <th>Vendor</th>
                        <th>Purchase Order No</th>
                        <th>Indent Id</th>
                        <th>Created By</th>
                        <th>Total Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody><?php $i = 1;?>

                    @foreach($purchaseData as $result)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$result->company_name}}</td>
                            @if(Auth::user()->user_type=="vendor")

                                <td>
                                    <form action="{{route('vendorChallan') }}" method="post">
                                        {{csrf_field()}}
                                        <input type="hidden" name="purchase_order_no"
                                               value="{{$result->purchase_order_no}}">
                                        <input type="hidden" name="portal_id" value="{{$result->portal_id}}"
                                               id="hidden_portal_id">
                                        <input type="hidden" name="indent_no" value="{{$result->indent_id}}">
                                        <input type="hidden" name="vendor_id" value="{{$result->vendor_id}}">

                                        <button type="submit"
                                                class="btn btn-link">{{$result->purchase_order_no}}</button>
                                    </form>
                                </td>
                            @else
                                <td>
                                    <form action="{{route('getPurchaseItem') }}" method="post">
                                        {{csrf_field()}}
                                        <input type="hidden" name="purchase_order_no"
                                               value="{{$result->purchase_order_no}}">
                                        <input type="hidden" name="indent_no" value="{{$result->indent_id}}">
                                        <input type="hidden" name="vendor_id" value="{{$result->vendor_id}}">

                                        <button type="submit"
                                                class="btn btn-link">{{$result->purchase_order_no}}</button>
                                    </form>
                                </td>
                            @endif
                            <td>{{$result->indent_id}}</td>
                            <td>{{$result->first_name}}&nbsp;{{$result->last_name}}</td>
                            <td>{{number_format($result->total_amount, 2)}}</td>
                            @if(Auth::user()->user_type=="vendor")

                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                                data-toggle="dropdown">Action
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <form action="{{route('PurchaseOrder.ViewAndDownloadPDF')}}"
                                                      method="post">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="purchase_order_no"
                                                           value="{{$result->purchase_order_no}}">
                                                    <input type="hidden" name="portal_id"
                                                           value="{{$result->portal_id}}">
                                                    <input type="hidden" name="indent_no"
                                                           value="{{$result->indent_id}}">
                                                    <input type="hidden" name="voucher_no"
                                                           value="{{$result->voucher_no}}">
                                                    <input type="hidden" name="vendor_id"
                                                           value="{{$result->vendor_id}}">
                                                    <button type="submit" class="btn btn-link">Download PO</button>

                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{route('vendorChallan') }}" method="post">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="purchase_order_no"
                                                           value="{{$result->purchase_order_no}}">
                                                    <input type="hidden" name="portal_id"
                                                           value="{{$result->portal_id}}">
                                                    <input type="hidden" name="indent_no"
                                                           value="{{$result->indent_id}}">
                                                    <input type="hidden" name="vendor_id"
                                                           value="{{$result->vendor_id}}">
                                                    <button type="submit" class="btn btn-link">Create Challan
                                                    </button>
                                                </form>
                                            </li>

                                            <li>
                                                <input type="hidden" name="purchase_order_no"
                                                       value="{{$result->purchase_order_no}}"
                                                       id="purchase_order_no_get">
                                                <input type="hidden" name="portal_id"
                                                       value="{{$result->portal_id}}">
                                                <input type="hidden" name="indent_no"
                                                       value="{{$result->indent_id}}">
                                                <input type="hidden" name="vendor_id"
                                                       value="{{$result->vendor_id}}">
                                                <button class="btn btn-link" id="view_challan">View
                                                    Challan
                                                </button>
                                            </li>


                                        </ul>
                                    </div>
                                </td>
                                <td>
                            @else
                                <td>
                                    <form action="{{route('PurchaseOrder.ViewAndDownloadPDF')}}" method="post">
                                        {{csrf_field()}}
                                        <input type="hidden" name="purchase_order_no"
                                               value="{{$result->purchase_order_no}}">
                                        <input type="hidden" name="portal_id" value="{{$result->portal_id}}">
                                        <input type="hidden" name="indent_no" value="{{$result->indent_id}}">
                                        <input type="hidden" name="voucher_no" value="{{$result->voucher_no}}">
                                        <input type="hidden" name="vendor_id" value="{{$result->vendor_id}}">
                                        <button type="submit" class="btn btn-primary">Download PO</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach

                    </tbody>
                </table>


            </div>
        </div>
    </div>








    <div class="row" id="challanData">
        <div class="col-md-12">
            <div style="margin-top: 10px;background: #fff;padding: 15px;">
                <table class="table display" id="challanViewData">
                    <thead>
                    <tr>
                        <th>Sr. No</th>
                        <th>Challan No</th>
                        <th>Date of Challan</th>
                        <th>Driver Name</th>
                        <th>Driver Mobile</th>
                        <th>Vehicle No</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="appendNewData">

                    </tbody>
                </table>

            </div>
        </div>
    </div>




    <div class="row" id="billData">
        <div class="col-md-12">
            <div style="margin-top: 10px;background: #fff;padding: 15px;">
                <table class="table display">
                    <thead>
                    <tr>
                        <th>Sr. No</th>
                        <th>Bill No</th>
                        <th>Bill Date</th>
                        <th>Amount</th>
                        <th>Tax Amount</th>
                        <th>Total Amount</th>
                    </tr>
                    </thead>
                    <tbody id="appendNewDataForBill">

                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
@section('script')

    <script type="text/javascript">

        $(document).ready(function () {

            $('#challanData').hide();
            $('#billData').hide();

        });


        $('#view_challan').click(function () {

            var tableNewDiv = '';
            var orderNo = $('#purchase_order_no_get').val()
            var j = 1
            var billBasedUrl = "<?php echo route('PurchaseOrder.index') . '/vendorBill'; ?>"
            var billPdf = "{{route('billPdf')}}"


            jQuery.ajax({

                url: "{{route('getChallanBased')}}",
                type: "get",
                data: {
                    'order_no': orderNo,

                },
                dataType: 'json',
                success: function (data) {
                    $('#appendNewData tr').remove();

                    for (var i = 0; i < data.length; i++) {

                        var challan_encode = btoa(data[i].challan_no)
                        var purchase_order_decode = btoa(data[i].purchase_order_no)


                        tableNewDiv += '<tr>' +
                            '<td>' + (j) + '</td>' +
                            '<td>' + data[i].challan_no + '</td>' +
                            '<td>' + data[i].date + '</td>' +
                            '<td>' + data[i].driver_name + '</td>' +
                            '<td>' + data[i].dmobile_no + '</td>' +
                            '<td>' + data[i].tracker_no + '</td>' +
                            '<td class="dropdown">' + ((data[i].bill_status == "GENERATED") ? '<button class="btn btn-primary dropdown-toggle" type="button"\n' +
                                '                                                    data-toggle="dropdown">Action\n' +
                                '                                                <span class="caret"></span>\n' +
                                '                                            </button>\n' +
                                '                                            <ul class="dropdown-menu"><li><a  class="btn btn-info" data-order-id="'+purchase_order_decode+'" data-challan="' + challan_encode + '" onclick="view_bill_detail(this)" >View Bill</a></li>' +
                                '<li><a  href="' + billPdf + '" class="btn btn-danger"  >Download Bill</a></li> </ul>' :
                                '<a href="' + billBasedUrl + '/' + challan_encode + '/' + purchase_order_decode + '"   class="btn btn-danger"  >Create Bill</a>') + '</td' +
                            // ? '<button  class="btn btn-danger" onclick="view_bill_detail('+data[i].challan_no+')" >View Bill</button>' :
                            // '<button  class="btn btn-danger" onclick="view_bill_detail('+data[i].challan_no+')" >Create Bill</button>' +'</td'+
                            // '<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action' +
                            // '<span class="caret"></span>' +
                            // '</button>' +
                            // '<ul class="dropdown-menu">' +
                            // '<li>' +


                            // '</li>' +
                            '</tr>';

                        j = j + 1

                    }


                    $('#appendNewData').html(tableNewDiv);
                    $('#challanData').show();
                }

            });
        });


        function view_bill_detail(challan) {

            var tableNewDiv = '';
            var orderNo = $('#purchase_order_no_get').val()

            var challan_encode = $(challan).attr('data-challan')
            var order_encode = $(challan).attr('data-order-id')


            console.log(challan_encode,order_encode)

            jQuery.ajax({

                url: "{{route('getBillBased')}}",
                type: "get",
                data: {
                    'order_no': order_encode,
                    'challan_no': challan_encode,

                },
                dataType: 'json',
                success: function (data) {
                    var j = 1;
                    $('#appendNewDataForBill tr').remove();

                    for (var i = 0; i < data.length; i++) {
                        tableNewDiv += '<tr>' +
                            '<td>' + (j++) + '</td>' +
                            '<td>' + data[i].bill_no + '</td>' +
                            '<td>' + data[i].bill_date + '</td>' +
                            '<td>' + data[i].bill_amt + '</td>' +
                            '<td>' + data[i].gst_amt + '</td>' +
                            '<td>' + data[i].total_amount + '</td>' +

                            '</tr>';
                    }

                    $('#appendNewDataForBill').append(tableNewDiv);

                    $('#billData').show();
                }

            });
        }


        $(document).ready(function () {

            $('#to_from_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
            });
            //
            $('#to_to_date').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
            });
        });

        $('.display').DataTable({});


    </script>

@endsection


