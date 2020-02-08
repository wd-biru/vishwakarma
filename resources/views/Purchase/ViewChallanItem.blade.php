@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;View Challan Item :{{$purchase_order_no}}</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('PurchaseOrder.index')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('PurchaseOrder.index')}}">Purchase</a></li>
                <li><a href="#">View Challan Item</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
@include('includes.msg')
@include('includes.validation_messages')
@if($getChallan!=null)
{{--dd($getChallanItem , $item)--}}

<div class="row">
    <div class="col-md-12">
        <div class="content-section">
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
                                    @foreach($chkChallanNumber  as  $challan_no)
                                <th>Challan No: {{$challan_no->challan_no}}</th>
                                    @endforeach
                           
                   
                        </tr>
                    </thead>
                    <tbody><?php $i=1;?>
                         @foreach($getChallan as $list)
                            <tr>

                              
                            <?php  
                                $material_name = App\Models\MaterialItem::where('id',$list->item_id)->first(); 
                              $order = $list->checkQty($list->vendor_id,$list->purchase_order_no,$list->item_id,$list->qty)['orderQty'];
                              $remain =  $list->checkQty($list->vendor_id,$list->purchase_order_no,$list->item_id,$list->qty,$list->challan_no)['challanQty'];
                            ?>
                                <td>{{$i++}}</td>
                                <td>{{$material_name->material_name}}</td>
                                <td>{{$list->unit}}</td>

                                <td>
                                 {{$order}}
                                    </td> 
                                    @foreach($chkChallanNumber  as  $row) 
                                <td>
                                    <?php $chnlqty = $row->getChalanDetail($list->vendor_id,$list->purchase_order_no,$list->item_id,$row->challan_no); 

                                       
                                    ?>
                                    @if($chnlqty !=null || $chnlqty == null)
                                      <?php  $chnlqty = ($chnlqty==false) ? "0" :  $chnlqty->qty; ?>
                                      {{$chnlqty}}
                                    @else
                                         
                                    @endif

                                     
                                </td>   
                                @endforeach
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


