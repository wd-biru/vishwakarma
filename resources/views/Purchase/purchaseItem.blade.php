@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Purchase Item :{{$purchase_order_no}}</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('PurchaseOrder.index')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('PurchaseOrder.index')}}">Purchase</a></li>
                <li><a href="#">Purchase Item</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')

@include('includes.msg')
@include('includes.validation_messages')
@if($items!=null && $getChallanItem!=null)
{{--dd($getChallanItem)--}}


<div class="row">
    
    <div class="col-md-12">
        <div class="content-section">

            <div class="col-md-12" style="margin-bottom: 2px;"> 
               @if(count($getChallanItem)> 0)
                <form action="{{route('PurchaseOrder.getChallanQuantity')}}"  method="post">
                    {{csrf_field()}}
                        @foreach($getChallanItem as $list)
                            <input type="hidden" name="indent_id" value="{{$list->indent_id}}">
                            <input type="hidden" name="project_id" value="{{$list->project_id}}">
                            <input type="hidden" name="vendor_id" value="{{$list->vendor_id}}">
                            <input type="hidden" name="purchase_order_no" value="{{$list->purchase_order_no}}">

                        @endforeach
                        <button class="btn btn-primary" style="float: right;margin-bottom:2%; margin-top:2%!important;">View Challan Item</button>
                </form>

                @else

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12">
                                    <p><b>Vendor Not Challan Created Till Date</b></p>
                                </div>
                            </div>
                        </div>
                    </div>          
                @endif
                    
               
            </div> 

            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading"> 
                            <div class="row">
                                <div class="col-md-12" style="font-size: 15px">
                                    <p><span><b>Invoice To:</b></span><span style="float: right;"><b>Dated : {{date("d/m/Y", strtotime($supplier_data->date))}}</b></span></p>
                                    <p><span><b>{{$invoice_to_data->company_name}}</b></span></p>
                                    <p><span><b>GSTIN/UIN: {{$invoice_to_data->gstn_uin}}</b></span></p>
                                    <p><span><b> State Name:{{$invoice_to_data->company_address}}</b></span> <span style="float: right;"><b>Code: {{$invoice_to_data->gstcode}}</b></span></p>
                                    <p><span><b> Email: {{$invoice_to_data->company_mail}}</b></span> <span style="float: right;"><b>CIN: {{$invoice_to_data->cin}}</b></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-12" style="font-size: 15px"> 
                                 <p><span><b>Supplier's Ref / Order No : {{$purchase_order_no}}</b> </span></p>
                                    <p><span><b>{{$supplier_data->company_name}}</b></span></p>
                                    <p><span><b>Address: {{$supplier_data->address}}</b></span> <span style="float: right;"><b>City: {{$supplier_data->cityname}}</b></span></p>
                                    <p><span><b>State Name:{{$supplier_data->statename}}</b></span> <span style="float: right;"><b>Code: {{$supplier_data->gstcode}}</b></span></p>
                                    <p><span><b> Email: {{$supplier_data->email}}</b></span> <span style="float: right;"><b>Pin:  {{$supplier_data->pincode}}</b></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="  table-responsive ">
                <table class="table table-bordered main-table search-table " >
                    <thead>
                        <tr class="t-head">
                    
                                <th>Sr. No</th>
                                <th>Material Name.</th>
                                <th>Unit.</th>
                                <th>Quantity.</th>
                   
                        </tr>
                    </thead>
                    <tbody><?php $i=1;?>
                         @foreach($items as $result)

                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$result->material_name}}</td>
                            <td>{{$result->material_unit}}</td>
                            <td>{{$result->qty}}</td>
                        </tr>  
                        @endforeach
                    </tbody>
                    
                </table>
            </div>

        </div>
    </div>
</div>
@endif  
 
@endsection
@section('script')
 



@endsection


