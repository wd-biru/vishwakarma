@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Challan Item :{{$challan_no}}</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href=""><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('getChallanindex')}}">Challan</a></li>
                <li><a href="{{route('ChallanItemGet')}}">Challan Item</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
@include('includes.msg')
@include('includes.validation_messages')
@if($getChallanItem!=null &&  $item != null)
<div class="row">
    <div class="col-md-12">
        <div class="content-section">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading"> 
                            <div class="row">
                                <div class="col-md-12" style="font-size: 15px">
                                    
                                    <p><span><b>Challan Book:</b><span style="float: right;"><b>Dated : @date($item->created_at) </b></span></p>
                                    <p><span><b>{{$item->company_name}}</b></span></p>
                                    <?php $state_name = DB::table('vishwa_states')->where('id',$item->state)->first();?>
                                    <p><span><b>Address:{{$item->address}}({{$state_name->name}}).</b></span></p>
                                    <p><span><b>Mobile No:{{$item->mobile}}</b></span></p>
                                    <p><span><b>Challan No: {{$item->challan_no}}</b></span></p>
                                     <p><span><b>Company's Name: {{$item->portal_name}}</b></span></p>
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
                         @foreach($getChallanItem as $result)

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


