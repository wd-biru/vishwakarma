@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Indent Price</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="#">Indent Price</a></li>
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



    <div class="row">
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">&nbsp;Indent</h3>
                </div>
                <div class="panel-body">
                    <div class="card col-md-12">
                        <form action="#" method="POST" id="form">
                            {{ csrf_field() }}
                            <div class="  table-responsive ">
                                <table class="table table-bordered main-table search-table ">
                                    <thead>
                                    <tr class="t-head">
                                        <th>Indent No.</th>
                                        <th>Company Name</th>
                                        <th>Created Date</th>


                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(count($indentVendor)>0)
                                        @foreach($indentVendor as $list)
                                            <tr>

                                                <td class="table-text link-color">
                                                    @if($list->getVendorIndent!=null)
                                                        <a href="{{ route('vendorIndentPrice', ['id' => $list->getVendorIndent->indent_id]) }}"
                                                           class="link-color">{{$list->getVendorIndent->indent_id}}</a>
                                                    @endif
                                                </td>

                                                <td>{{ucfirst($list->portal_name)}}</td>
                                                <td>{{date('d-m-Y', strtotime($list->created_date))}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    @else
                                        <tr>
                                            <td>
                                                <center>No Data To Displayed</center>
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        @if(isset($vendor_item_price))

            @if(($group_type->group_type_id==2) )

                <div class="col-md-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">&nbsp;Indent :{{$id}} Price</h3>
                            <h4 class="pull left"><b style="color: red">Note:*</b> Red Box : L1 & Green Box : L2</h4>
                        </div>
                        <div class="panel-body">

                            <div class="card col-md-12">
                                <form action="{{route('storeIndentyPrice')}}" id="form1" method="POST">
                                    {{ csrf_field() }}

                                    <div class="  table-responsive ">
                                        <table class="table table-bordered main-table">
                                            <thead>
                                            <tr class="t-head">
                                                <th>Sr. No.</th>
                                                <th>Material Name.</th>
                                                <th>Unit.</th>
                                                <th>Quantity.</th>
                                                <th>Price Without Tax</th>
                                                <th>GST</th>
                                                <th>Total Amount</th>
                                            </tr>
                                            </thead>
                                            <tbody><?php $i = 1;?>
                                            <input type="hidden" name="group_type_id"
                                                   value="{{$group_type->group_type_id}}">


                                            @foreach($vendor_item_price as $list)
                                                <tr>

                                                    <input type="hidden" name="updated_id[]" value="{{$list->id}}">
                                                    <td>{{$i++}}</td>
                                                    <input type="hidden" name="indent_id[]"
                                                           value="{{$list->indent_id}}">
                                                    <?php   $item_name = DB::table('vishwa_materials_item')->where('id', $list->item_id)->first();?>
                                                    <td><input type="hidden" name="item_id[]"
                                                               value="{{$list->item_id}}">{{$item_name->material_name}}
                                                    </td>
                                                    <td><input type="hidden" name="unit[]"
                                                               value="{{$list->unit}}">{{$list->unit}}</td>
                                                    <td><input type="hidden" name="qty[]" class="qty"
                                                               value="{{$list->qty}}">{{$list->qty}}</td>

                                                    <td>
                                                        <input class="form-control price priceMax priceMax_{{$list->item_id}}"
                                                               type="number" step="any" autocomplete="off"
                                                               name="price[]"
                                                               data-qty="{{$list->qty}}" data-id="{{$list->item_id}}"
                                                               data-indent_id="{{$list->indent_id}}"
                                                               id="forcolor{{$list->item_id}}"
                                                               data-vendor_id="{{Auth::user()->getVendor->id}}"
                                                               class="form-control price"
                                                               @if($getIndentPrice->count()>0)
                                                               @foreach($getIndentPrice as $val)
                                                               @if($val->item_id == $list->item_id)  value="{{$val->price}}"
                                                               @endif
                                                               @endforeach
                                                               @endif placeholder="Price" required>
                                                    </td>

                                                    <td><input class="form-control" type="number" autocomplete="off"
                                                               step="any"
                                                               name="tax_rate[]" class="form-control price"
                                                               @if($getIndentPrice->count()>0)
                                                               @foreach($getIndentPrice as $val)
                                                               @if($val->item_id == $list->item_id)  value="{{$val->tax_rate}}"
                                                        @endif
                                                        @endforeach
                                                        @endif" placeholder="Tax Rate" required>
                                                    </td>

                                                    <td><input id="total{{$list->item_id}}"
                                                               class="form-control total_all"
                                                               type="text" name="total[]" readonly=""
                                                               @if($getIndentPrice->count()>0)
                                                               @foreach($getIndentPrice as $val)
                                                               @if($val->item_id == $list->item_id)  value="{{$val->total}}"
                                                        @endif
                                                        @endforeach
                                                        @endif">
                                                    </td>

                                            @endforeach

                                            </tbody>
                                        </table>

                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Remarks:&nbsp;<span
                                                        style="color: #f70b0b">*</span></label>
                                            <div class="col-md-12">
                                                <input class="form-control" type="text" name="remarks"
                                                       @if($getIndentPrice->count()>0)
                                                       @foreach($getIndentPrice as $val)
                                                       @if($val->item_id == $list->item_id)  value="{{$val->remarks}}"
                                                        @endif
                                                        @endforeach
                                                        @endif>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Freight:&nbsp;<span
                                                        style="color: #f70b0b">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" required name="freight"
                                                       id="freight"
                                                       required
                                                       @if($getIndentPrice->count()>0)
                                                       @foreach($getIndentPrice as $val)
                                                       value="{{$val->freight}}"
                                                        @endforeach
                                                        @endif>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Loading/Unloading:&nbsp;<span
                                                        style="color: #f70b0b">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="loading" id="loading"
                                                       required
                                                       @if($getIndentPrice->count()>0)
                                                       @foreach($getIndentPrice as $val)
                                                       value="{{$val->loading}}"
                                                        @endforeach
                                                        @endif>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Kata Parchi Charges:&nbsp;<span
                                                        style="color: #f70b0b">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="kpcharges" id="kpcharges"
                                                       required
                                                       @if($getIndentPrice->count()>0)
                                                       @foreach($getIndentPrice as $val)
                                                       value="{{$val->kpcharges}}"
                                                        @endforeach
                                                        @endif >
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>

                                    <div class="row">

                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary" style="margin-top: 15px;">
                                                Submit
                                            </button>
                                        </div>
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4">
                                            {{-- <div class="col-md-3"><label style="margin-top: 6px;">Total: &nbsp; </label></div>
                                            <div class="col-md-9">
                                                 <input type="text"  name="amount"  class="form-control" id="amount" value="">
                                              </div>--}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            @else
                <div class="col-md-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">&nbsp;Indent :{{$id}} Price</h3>
                            <h4 class="pull left"><b style="color: red">Note:*</b> Red Box : L1 & Green Box : L2</h4>
                        </div>
                        <div class="panel-body">

                            <div class="card col-md-12">
                                <form action="{{route('rentableQuotes')}}" id="form1" method="POST">
                                    {{ csrf_field() }}

                                    <div class="  table-responsive ">
                                        <table class="table table-bordered main-table">
                                            <thead>
                                            <tr class="t-head">
                                                <th>Sr. No.</th>
                                                <th>Material Name.</th>
                                                <th>Unit.</th>
                                                <th>Quantity.</th>
                                                <th>Per Day Price</th>
                                                <th>Recovery Price</th>

                                            </tr>
                                            </thead>
                                            <tbody><?php $i = 1;?>



                                            @foreach($vendor_item_price as $list)
                                                <tr>

                                                    <input type="hidden" name="updated_id[]" value="{{$list->id}}">
                                                    <td>{{$i++}}</td>
                                                    <input type="hidden" name="indent_id[]"
                                                           value="{{$list->indent_id}}">
                                                    <?php   $item_name = DB::table('vishwa_materials_item')->where('id', $list->item_id)->first();?>
                                                    <td><input type="hidden" name="item_id[]"
                                                               value="{{$list->item_id}}">{{$item_name->material_name}}
                                                    </td>
                                                    <td><input type="hidden" name="unit[]"
                                                               value="{{$list->unit}}">{{$list->unit}}</td>
                                                    <td><input type="hidden" name="qty[]" class="qty"
                                                               value="{{$list->qty}}">{{$list->qty}}</td>

                                                    <td>
                                                        <input class="form-control price priceMax priceMax_{{$list->item_id}}"
                                                               type="number" step="any" autocomplete="off"
                                                               name="per_day_price[]"
                                                               data-qty="{{$list->qty}}" data-id="{{$list->item_id}}"
                                                               data-indent_id="{{$list->indent_id}}"
                                                               id="forcolor{{$list->item_id}}"
                                                               data-vendor_id="{{Auth::user()->getVendor->id}}"
                                                               class="form-control price"
                                                               @if($getIndentNonPrice->count()>0)
                                                               @foreach($getIndentNonPrice as $val)
                                                               @if($val->item_id == $list->item_id)  value="{{$val->per_day_price}}"
                                                               @endif
                                                               @endforeach
                                                               @endif placeholder="Price" required>
                                                    </td>

                                                    <td><input class="form-control" type="number" autocomplete="off"
                                                               step="any"
                                                               name="recovery_price[]" class="form-control price"
                                                               @if($getIndentNonPrice->count()>0)
                                                               @foreach($getIndentNonPrice as $val)
                                                               @if($val->item_id == $list->item_id)  value="{{$val->recovery_price}}"
                                                               @endif
                                                               @endforeach
                                                               @endif placeholder="Tax Rate" required>
                                                    </td>

                                                {{--<td><input id="total{{$list->item_id}}"--}}
                                                {{--class="form-control total_all"--}}
                                                {{--type="text" name="total[]" readonly=""--}}
                                                {{--@if($getIndentNonPrice->count()>0)--}}
                                                {{--@foreach($getIndentNonPrice as $val)--}}
                                                {{--@if($val->item_id == $list->item_id)  value="{{$val->total}}"--}}
                                                {{--@endif--}}
                                                {{--@endforeach--}}
                                                {{--@endif>--}}
                                                {{--</td>--}}
                                                {{--<td><input class="form-control" type="text" name="remarks[]"--}}
                                                {{--@if($getIndentNonPrice->count()>0)--}}
                                                {{--@foreach($getIndentNonPrice as $val)--}}
                                                {{--@if($val->item_id == $list->item_id)  value="{{$val->remarks}}"--}}
                                                {{--@endif--}}
                                                {{--@endforeach--}}
                                                {{--@endif>--}}
                                                {{--</td>--}}
                                            @endforeach

                                            </tbody>
                                        </table>

                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Remarks:&nbsp;<span
                                                        style="color: #f70b0b">*</span></label>
                                            <div class="col-md-12">
                                                <input class="form-control" type="text" name="remarks"
                                                       @if($getIndentNonPrice->count()>0)
                                                       @foreach($getIndentNonPrice as $val)
                                                       @if($val->item_id == $list->item_id)  value="{{$val->remarks}}"
                                                        @endif
                                                        @endforeach
                                                        @endif>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Freight:&nbsp;<span
                                                        style="color: #f70b0b">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" required name="freight"
                                                       id="freight"
                                                       required
                                                       @if($getIndentNonPrice->count()>0)
                                                       @foreach($getIndentNonPrice as $val)
                                                       value="{{$val->freight}}"
                                                        @endforeach
                                                        @endif>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Loading/Unloading:&nbsp;<span
                                                        style="color: #f70b0b">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="loading" id="loading"
                                                       required
                                                       @if($getIndentNonPrice->count()>0)
                                                       @foreach($getIndentNonPrice as $val)
                                                       value="{{$val->loading}}"
                                                        @endforeach
                                                        @endif>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Kata Parchi Charges:&nbsp;<span
                                                        style="color: #f70b0b">*</span></label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="kpcharges" id="kpcharges"
                                                       required
                                                       @if($getIndentNonPrice->count()>0)
                                                       @foreach($getIndentNonPrice as $val)
                                                       value="{{$val->kpcharges}}"
                                                        @endforeach
                                                        @endif >
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>

                                    <div class="row">

                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary" style="margin-top: 15px;">
                                                Submit
                                            </button>
                                        </div>
                                        <div class="col-md-4">
                                            <a class="btn btn-primary" href="{{ route('createContract',$id) }}"
                                               style="margin-top: 15px;">
                                                Create Contract
                                            </a></div>
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4">
                                            {{-- <div class="col-md-3"><label style="margin-top: 6px;">Total: &nbsp; </label></div>
                                            <div class="col-md-9">
                                                 <input type="text"  name="amount"  class="form-control" id="amount" value="">
                                              </div>--}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
    </div>
    @endif
@endsection
@section('script')

    <script>


        $(".price").bind("keyup change", function (e) {

            var total = 0;
            var id = $(this).data("id");
            var qty = $(this).data("qty");
            var price = $(this).val();
            var parqty = parseInt(qty);
            var parprice = parseInt(price);
            var mulamt = parqty * parprice;
            $('#total' + id).val(mulamt);


            // var amount = 0;
            // $('.total_all').each(function(){
            //       if(jQuery.trim(jQuery(this).val())!='')
            //          amount=parseFloat(jQuery(this).val())+amount;
            //    });

            //     $('#amount').val(amount);


        });


        $(document).on("keyup", ".priceMax", function (e) {

            var item_id = $(this).data("id");
            var vendor_id = $(this).data("vendor_id");
            var indent_id = $(this).data("indent_id");
            var price = $(this).val();

            $.ajax({
                url: "{{route('getEachVendorPrice')}}",
                type: 'get',
                data: {
                    "item_id": item_id,
                    "vendor_id": vendor_id,
                    "price": price,
                    "indent_id": indent_id
                },
                success: function (data) {

                    if (data.lowest != "") {
                        $('.priceMax_' + item_id).css('border-color', data.LowColor);
                    }


                }

            });


        });


    </script>

@endsection























