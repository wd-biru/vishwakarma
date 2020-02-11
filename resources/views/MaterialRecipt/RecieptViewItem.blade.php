@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Material Receipt Item</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href=""><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('MaterialRecipt.index',$purchase_order_no)}}">Material Receipt</a></li>
                <li><a href="{{route('MaterialRecipt.getMaterialRecieptItem')}}">Material Receipt Item</a></li>
            </ul>
        </div>
    </div>
@endsection


@section('content')
@include('includes.msg')
@include('includes.validation_messages')

@if($MaterialReciptItem!=null && $EachMaterialReciptItem != null)
<div class="row">
    
    <div class="col-md-12">
        <div class="content-section">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading"> 
                            <div class="row">
                                <div class="col-md-12" style="font-size: 15px">
                                    <p><span><b>INWARD-GOODS / ASSETS:</b></span><span style="float: right;"><b>Dated : {{date("d/m/Y", strtotime($EachMaterialReciptItem->material_reciept_date))}} </b></span></p>
                                    <p><span><b>{{$vendor_data->company_name}}</b></span></p>
                                    <p><span><b>Address: {{$vendor_data->address}}</b><span style="float: right;"><b>State Name:{{$vendor_data->state_name}} </b></span></span></p>
                                    <p><span><b>Mobile No:{{$vendor_data->mobile}}</b></span></p>
                                    <p><span><b> Email: {{$vendor_data->company_mail}}</b></span> <span style="float: right;"><b>M.R. No:{{$EachMaterialReciptItem->mr_no}}</b></span></p>
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
                                 <p><span><b>Name Of Supplier & Address: {{$vendor_data->vendor_com_name}}</b> </span></p>
                                    <p><span><b>Bill / Challan No: {{$vendor_data->challan_no}}</b></span> <span style="float: right;"><b>Form No: {{$EachMaterialReciptItem->form_no}}</b></span></p>
                                    <p><span><b>Gate Entry No:{{$EachMaterialReciptItem->gate_number}}</b></span></p>
                                    <p><span><b> Arrival Time: {{date("g:i a", strtotime($EachMaterialReciptItem->arrival_time))}}</b></span></p>
                                    <p><span><b>Site: {{$vendor_data->project_name}}  ({{$vendor_data->store_name}})</b></span><span style="float: right;"><b>Master Ledger Folio No: {{$EachMaterialReciptItem->master_ledger_folio_no}}</b></span></p>
                                   
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
                         @foreach($MaterialReciptItem as $result)

                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$result->material_name}}</td>
                            <td>{{$result->material_unit}}</td>
                            <td>{{$result->recieve_qty}}</td>
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


