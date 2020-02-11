@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Material Receipt</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href=""><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="">Material Receipt</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
    @if(Session::has('error_message'))
        <p class="alert alert-danger" style="font-size: 16px;">{{ Session::get('error_message') }}</p>
    @endif
    @if(Session::has('success_message'))
        <p class="alert alert-success" id="msg" style="font-size: 16px;">{{ Session::get('success_message') }}</p>
    @endif
    @if(Session::has('message'))
        <p class="alert alert-info" style="font-size: 16px;">{{ Session::get('message') }}</p>
    @endif
    @include('includes.validation_messages')

    {{--<div class="row">--}}
    {{--<div  class="col-md-12">--}}
    {{--<div class="content-section">              --}}
    {{--<form  action="{{route('MaterialRecipt.getChallanItem')}}" method="post">--}}
    {{--{{ csrf_field() }}--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-2">--}}
    {{--<label>Projects</label>--}}
    {{--<select class="form-control selectable" name="project" id="project">--}}
    {{--<option value="0">Please Select</option>--}}
    {{--@foreach($projects as $list)--}}
    {{--<option value="{{$list->id}}">{{$list->name}}</option>--}}
    {{--@endforeach--}}
    {{--</select>--}}
    {{--</div>--}}
    {{--<div class="col-md-2">--}}
    {{--<label>Store</label>--}}
    {{--<select class="form-control" name="stores" id="stores">--}}
    {{--<option value="0">Please Select</option>--}}
    {{--</select>--}}
    {{--</div>--}}
    {{--<div class="col-md-2">--}}
    {{--<label>Vendor</label>--}}
    {{--<select class="form-control" name="vendor" id="vendor">--}}
    {{--<option value="0">Please Select</option>--}}

    {{--</select>--}}
    {{--</div>--}}
    {{--<div class="col-md-2">--}}
    {{--<label>Challan</label>--}}
    {{--<select class="form-control" name="Challan" id="challan_no">--}}
    {{--<option value="0">Please Select</option>--}}

    {{--</select>--}}
    {{--</div>--}}
    {{--<div class="col-md-2">--}}
    {{--<label>Gate/Qc</label>--}}
    {{--<select class="form-control" name="Challan" id="challan_no">--}}
    {{--<option value="0">Please Select</option>--}}

    {{--</select>--}}
    {{--</div>--}}
    {{--<div class="col-md-1">--}}
    {{--<label>&nbsp;</label>--}}
    {{--<br>--}}
    {{--<button type="submit" id="go" class="btn btn-primary">Go</button>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    <label class="label label-success lb-lg" style="margin-left: 38%;padding: 8px 16px 8px;">Project Manager
        Verification</label>
    @if($challan_item!=null)
        <div class="row" id="table_div">

            <div class="col-md-12">


                <div class="content-section" style="margin-top: 2%;">
                    <form class="form-horizontal" action="{{route('MaterialRecipt.verifyByProjectManager')}}"
                          method="post" id="form_data">
                        <table class="table table-bordered table-hover col-md-12">
                            <thead>
                            <tr>
                                <th class="col-md-2">Material Name</th>
                                <th class="col-sm-1">Qty</th>
                                <th class="col-md-1">Recieved Quantity</th>
                                <th class="col-md-1">Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($challan_item->count()>0)
                                @foreach($challan_item as $value)

                                    <tr>


                                        <?php

                                        $mr_reciept = DB::table('vishwa_store_inventory_qty')->get()->max('mr_no');

                                        if ($mr_reciept == null) {
                                            $mr_reciept = 1;
                                        } else {
                                            $mr_reciept = $mr_reciept + 1;
                                        }
                                        //dd($challan_item);
                                        ?>
                                        <input type="hidden" class="form-control" name="po"
                                               value="{{$value->purchase_order_no}}">
                                        <input type="hidden" class="form-control" name="mr_reciept"
                                               value="{{$mr_reciept}}">
                                        <input type="hidden" class="form-control" name="vendor_for_pdf"
                                               value="{{$value->vendor_id}}">
                                        <input type="hidden" class="form-control" name="challan_for_pdf"
                                               value="{{$value->challan_no}}">
                                        <input type="hidden" class="form-control" name="project_id[]"
                                               value="{{$value->project_id}}">
                                        <input type="hidden" class="form-control" name="challan_no[]"
                                               value="{{$value->challan_no}}">
                                        <input type="hidden" class="form-control" name="store_id[]"
                                               value="{{$value->store_id}}">
                                        {{csrf_field()}}

                                        <td><input type="hidden" class="form-control" name="item[]"
                                                   value="{{$value->item_id}}">{{$value->material_name}}</td>
                                        <td>{{$value->qty}}</td>
                                        <td><input type="number" class="form-control" name="quantity[]"
                                                   style="width: 241px;" min="0" max="{{$value->qty}}" required=""
                                                   value="{{$value->recieve_qty}}" disabled></td>
                                        <td><input type="text" class="form-control" name="Remarks[]"
                                                   value="{{$value->remarks}}" disabled></td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="col-md-2">
                                    <label>Material Reciept Date</label>
                                    <input type="text" class="form-control datetimepicker" autocomplete="off"
                                           id="mr_date" name="mr_date" required=""
                                           @if($challan_item_first_data != null)
                                           value="{{$challan_item_first_data->material_reciept_date}}" @else value="" @endif disabled><br>
                                </div>

                                <div class="col-md-2">
                                    <label>Form No</label>
                                    <input type="text" autocomplete="off" class="form-control" name="form_no"
                                           @if($challan_item_first_data != null)
                                           value="{{$challan_item_first_data->form_no}}" @else value="" @endif disabled><br>
                                </div>


                                <div class="col-md-2">
                                    <label>Arrival Time</label>
                                    <input class="form-control" type="time" name="arrival_time"
                                           @if($challan_item_first_data != null)
                                           value="{{$challan_item_first_data->arrival_time}}" @else value="" @endif disabled><br>
                                </div>


                                <div class="col-md-2">
                                    <label>Gate Number</label>
                                    <input type="text" class="form-control" autocomplete="off" name="gate_entry"
                                           @if($challan_item_first_data != null)
                                           value="{{$challan_item_first_data->gate_number}}" @else value="" @endif disabled>
                                </div>

                                <div class="col-md-2">
                                    <label>Master Ledger Folio No</label>
                                    <input type="text" class="form-control" autocomplete="off"
                                           name="master_ledger_folio_no"
                                           @if($challan_item_first_data != null)
                                           value="{{$challan_item_first_data->master_ledger_folio_no}}" @else value="" @endif disabled>
                                </div>
                                <br>


                                <button type="submit" class="btn btn-primary" id="form_submit" style="float: right;">
                                    Verified
                                </button>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>

    @endif


@endsection
@section('script')


    <script>

        jQuery('.datetimepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            endDate: new Date(),
            format: 'dd/mm/yyyy'
        });

        $('.display').DataTable({});


        $(document).ready(function () {
            $("#form_submit").click(function () {

                if ($('#mr_date').val() == "") {
                    alert('Please Fill Material Recipt Date')
                    return false;
                }

                $("#table_div").hide();


            });
        });


        //***********************************************for getting Store*********************************//


        jQuery(document).on('change', '#project ', function () {
            var project_id = $(this).val();

            $.ajax({
                type: "get",
                url: "{{route('MaterialRecipt.getStore')}}",
                data: {
                    project_id: project_id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {


                    var opt = '';
                    jQuery.each(data, function (index, value) {
                        opt += '<option value="' + value.id + '">' + value.store_name + '</option>';
                    });

                    jQuery('#stores').html(opt);

                    //******************for vendor  ***************//

                    var project_id = $('#project').val();
                    var store_id = $('#stores').val();

                    $.ajax({
                        type: "get",
                        url: "{{route('MaterialRecipt.getvendor')}}",
                        data: {
                            project_id: project_id,
                            store_id: store_id,
                            "_token": "{{ csrf_token() }}"


                        },
                        success: function (data) {

                            var opt = '';
                            jQuery.each(data, function (index, value) {
                                opt += '<option value="' + value.vendor_id + '">' + value.company_name + '</option>';
                            });

                            jQuery('#vendor').html(opt);


                            //******************for challan  ***************//

                            var project_id = $('#project').val();
                            var store_id = $('#stores').val();
                            var vendor_id = $('#vendor').val();

                            $.ajax({
                                type: "get",
                                url: "{{route('MaterialRecipt.getChallan')}}",
                                data: {
                                    project_id: project_id,
                                    store_id: store_id,
                                    vendor_id: vendor_id,
                                    "_token": "{{ csrf_token() }}"


                                },
                                success: function (data) {

                                    $("#go").attr("disabled", true);


                                    var opt = '';
                                    jQuery.each(data, function (index, value) {

                                        if (value.challan_no != value.challan_inv) {

                                            $("#go").attr("disabled", false);
                                            opt += '<option value="' + value.challan_no + '">' + value.challan_no + '</option>';

                                        }


                                    });


                                    jQuery('#challan_no').html(opt);


                                },
                                error: function (result) {
                                    alert('Error in challan');
                                }

                            });


                            //******************end chalaln***************//


                        },
                        error: function (result) {
                            alert('Error in vendor');
                        }

                    });


                    //******************end vendor***************//


                },
                error: function (result) {
                    alert('Error in getting Store Details');
                }

            });

        });


        //***********************************************End getting Store*********************************//


        jQuery(document).on('change', '#stores ', function () {
            var project_id = $('#project').val();
            var store_id = $('#stores').val();

            $.ajax({
                type: "get",
                url: "{{route('MaterialRecipt.getvendor')}}",
                data: {
                    project_id: project_id,
                    store_id: store_id,
                    "_token": "{{ csrf_token() }}"


                },
                success: function (data) {


                    var opt = '';
                    jQuery.each(data, function (index, value) {
                        opt += '<option value="' + value.vendor_id + '">' + value.company_name + '</option>';
                    });

                    jQuery('#vendor').html(opt);


                    //******************for challan  ***************//

                    var project_id = $('#project').val();
                    var store_id = $('#stores').val();
                    var vendor_id = $('#vendor').val();

                    $.ajax({
                        type: "get",
                        url: "{{route('MaterialRecipt.getChallan')}}",
                        data: {
                            project_id: project_id,
                            store_id: store_id,
                            vendor_id: vendor_id,
                            "_token": "{{ csrf_token() }}"


                        },
                        success: function (data) {
                            console.log(data);
                            $("#go").attr("disabled", true);

                            var opt = '';
                            jQuery.each(data, function (index, value) {

                                if (value.challan_no != value.challan_inv) {
                                    $("#go").attr("disabled", false);
                                    opt += '<option value="' + value.challan_no + '">' + value.challan_no + '</option>';
                                }


                            });


                            jQuery('#challan_no').html(opt);


                        },
                        error: function (result) {
                            alert('Error in challan');
                        }

                    });


                    //******************end chalaln***************//


                },
                error: function (result) {
                    alert('Error in vendor');
                }

            });


        });


        jQuery(document).on('change', '#vendor ', function () {
            var project_id = $('#project').val();
            var store_id = $('#stores').val();
            var vendor_id = $('#vendor').val();

            $.ajax({
                type: "get",
                url: "{{route('MaterialRecipt.getChallan')}}",
                data: {
                    project_id: project_id,
                    store_id: store_id,
                    vendor_id: vendor_id,
                    "_token": "{{ csrf_token() }}"


                },
                success: function (data) {
                    console.log(data);
                    $("#go").attr("disabled", true);

                    var opt = '';
                    jQuery.each(data, function (index, value) {

                        if (value.challan_no != value.challan_inv) {
                            $("#go").attr("disabled", false);
                            opt += '<option value="' + value.challan_no + '">' + value.challan_no + '</option>';
                        }


                    });


                    jQuery('#challan_no').html(opt);


                },
                error: function (result) {
                    alert('Error in challan');
                }

            });


        });


        setTimeout(function () {
            $('#msg').fadeOut('fast');
        }, 3000);


    </script>

@endsection

 