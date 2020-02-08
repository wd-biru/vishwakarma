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
      <div  class="col-md-12">
        <div class="content-section">              
                        <form  action="{{route('PurchaseOrder.getPurchaseData')}}" method="post">
                             {{ csrf_field() }}
                             <div class="row">
                                <div class="col-md-2">
                                <label>From Date</label>
                                <input type="text" class="datetimepicker form-control" name="from_date" autocomplete="off" required>
                              </div> 
                              <div class="col-md-2">
                                <label>To Date</label>
                                <input type="text" class="datetimepicker form-control" name="to_date" autocomplete="off" required>
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


@if($purchaseData!=null)
 <div class="row" id="purchaseData">
  <div  class="col-md-12">
    <div style="margin-top: 10px;background: #fff;padding: 15px;">
      <table class="table display" >
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
          <tbody><?php $i=1;?>
                @foreach($purchaseData as $result)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$result->company_name}}</td>
                        @if(Auth::user()->user_type=="vendor")
                      
                           <td><form action="{{route('vendorChallan') }}"  method="post">
                            {{csrf_field()}} 
                           <input type="hidden" name="purchase_order_no" value="{{$result->purchase_order_no}}">
                           <input type="hidden" name="portal_id" value="{{$result->portal_id}}">
                           <input type="hidden" name="indent_no" value="{{$result->indent_id}}">
                           <input type="hidden" name="vendor_id" value="{{$result->vendor_id}}">
                           
                            <button type="submit" class="btn btn-link">{{$result->purchase_order_no}}</button>
                          </form></td>
                        @else
                          <td><form action="{{route('getPurchaseItem') }}"  method="post">
                            {{csrf_field()}} 
                           <input type="hidden" name="purchase_order_no" value="{{$result->purchase_order_no}}">
                           <input type="hidden" name="indent_no" value="{{$result->indent_id}}">
                           <input type="hidden" name="vendor_id" value="{{$result->vendor_id}}">
                           
                            <button type="submit" class="btn btn-link">{{$result->purchase_order_no}}</button>
                          </form></td>
                        @endif
                        <td>{{$result->indent_id}}</td>
                        <td>{{$result->first_name}}&nbsp;{{$result->last_name}}</td>
                        <td>{{number_format($result->total_amount, 2)}}</td>
                        @if(Auth::user()->user_type=="vendor")
                      
                           <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                      <li>
                                          <form action="{{route('PurchaseOrder.ViewAndDownloadPDF')}}"  method="post">
                                         {{csrf_field()}} 
                                         <input type="hidden" name="purchase_order_no" value="{{$result->purchase_order_no}}">
                                         <input type="hidden" name="portal_id" value="{{$result->portal_id}}">
                                         <input type="hidden" name="indent_no" value="{{$result->indent_id}}">
                                         <input type="hidden" name="voucher_no" value="{{$result->voucher_no}}">
                                         <input type="hidden" name="vendor_id" value="{{$result->vendor_id}}">
                                             <button type="submit" class="btn btn-link">Download PO</button>

                                        </form>
                                      </li>
                                        <li><form action="{{route('vendorChallan') }}"  method="post">
                                            {{csrf_field()}} 
                                            <input type="hidden" name="purchase_order_no" value="{{$result->purchase_order_no}}">
                                           <input type="hidden" name="portal_id" value="{{$result->portal_id}}">
                                           <input type="hidden" name="indent_no" value="{{$result->indent_id}}">
                                           <input type="hidden" name="vendor_id" value="{{$result->vendor_id}}">
                                            <button type="submit" class="btn btn-link">Create Challan</button>
                                          </form></li>

                                          </form>
                                      </li>

                                        <li>
                                           <input type="hidden" name="purchase_order_no" value="{{$result->purchase_order_no}}" id="purchase_order_no_get">
                                           <input type="hidden" name="portal_id" value="{{$result->portal_id}}">
                                           <input type="hidden" name="indent_no" value="{{$result->indent_id}}">
                                           <input type="hidden" name="vendor_id" value="{{$result->vendor_id}}">
                                            <button type="submit" class="btn btn-link" id="view_challan">View Challan</button>
                                        </li>

                                          </form>
                                      </li>
                                
                                        
                                    </ul>
                                </div>
                            </td>
                        <td>
                        @else
                          <td><form action="{{route('PurchaseOrder.ViewAndDownloadPDF')}}"  method="post">
                                         {{csrf_field()}} 
                             <input type="hidden" name="purchase_order_no" value="{{$result->purchase_order_no}}">
                             <input type="hidden" name="portal_id" value="{{$result->portal_id}}">
                             <input type="hidden" name="indent_no" value="{{$result->indent_id}}">
                             <input type="hidden" name="voucher_no" value="{{$result->voucher_no}}">
                             <input type="hidden" name="vendor_id" value="{{$result->vendor_id}}">
                             <button type="submit" class="btn btn-primary">Download PO</button>
                           </form></td>
                        @endif
                    </tr>
              @endforeach
             
          </tbody>
    </table>


               </div>
        </div>
</div>  
 
@endif  
 




@if($challanData!=null)
<div class="row" id="challanData">
  <div  class="col-md-12">
    <div style="margin-top: 10px;background: #fff;padding: 15px;">
      <table class="table display" >
      <thead>
        <tr>
            <th>Sr. No</th>
            <th>Challan No</th>
            <th>Date of Challan</th>
            <th>Driver Name</th>
            <th>Driver Mobile</th>
            <th>Vehicle No</th>
        </tr>
      </thead>
          <tbody id="appendNewData">
           
          </tbody>
    </table>
@endif
    </div>
  </div>
</div>  









@if($billData!=null)
 <div class="row" id="billData">
  <div  class="col-md-12">
    <div style="margin-top: 10px;background: #fff;padding: 15px;">
      <table class="table display" >
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
    @endif

@endsection
@section('script')
 








<script>

$(document).ready(function(){

$('#challanData').hide();
});

$('#view_challan').click(function(){


var tableNewDiv=''; 
var orderNo=$('#purchase_order_no_get').val()
var statusFlag=0;

jQuery.ajax({

          url:"{{route('getChallanBased')}}",
          type:"get",
          data: {
            'order_no':orderNo,
            'flag':statusFlag,
          },
          dataType:'json',
          success: function(data)
          {

   <?php $incre=1;  ?>           
      

      for(var i=0; i<data.length;i++)
      {
          tableNewDiv+='<tr>'+
                            '<td>'+(++i)+'</td>'+
                            '<td>'+data[i].challan_no+'</td>'+
                            '<td>'+data[i].date+'</td>'+
                            '<td>'+data[i].driver_name+'</td>'+
                            '<td>'+data[i].dmobile_no+'</td>'+
                            '<td>'+data[i].tracker_no+'</td>'+
                            '<td><div class="dropdown">'+
                                    '<button class="btn btn-primary dropdown-toggle" type="button"'+ '   data-toggle="dropdown">Action'+
                                         '<span class="caret"></span>'+
                                    '</button>'+
                                    '<ul class="dropdown-menu">'+
                                       '<li>'+
                                           '<input type="hidden" name="purchase_order_no"'+ 'value="{{$result->purchase_order_no}}" id="purchase_order_no_get"'+ 'id="purchase_order_no_get">'+
                                           '<input type="hidden" name="portal_id"'+ 'value="{{$result->portal_id}}">'+
                                           '<input type="hidden" name="bill_no"'+ 'value="{{$result->bill_no}}">'+
                                           '<input type="hidden" name="bill_date"'+ 'value="{{$result->bill_date}}">'+
                                           '<input type="hidden" name="bill_amt"'+ 'value="{{$result->bill_amt}}">'+
                                            '<input type="hidden" name="gst_amt"'+ 'value="{{$result->gst_amt}}">'+
                                            '<input type="hidden" name="total_amount"'+ 'value="{{$result->total_amount}}">'+
                                            '<button type="submit" class="btn btn-link"'+ 'id="view_bill">View Bill</button>'
                                        '</li>'+
                                        /*'<li>'+
                                           '<input type="hidden" name="purchase_order_no"'+ 'value="{{$result->purchase_order_no}}"'+ 'id="purchase_order_no_get">'+
                                           '<input type="hidden" name="portal_id"'+ 'value="{{$result->portal_id}}">'+
                                           '<input type="hidden" name="indent_no"'+ 'value="{{$result->indent_id}}">'+
                                           '<input type="hidden" name="vendor_id"'+ 'value="{{$result->vendor_id}}">'+
                                            '<button type="submit" class="btn btn-link"'+ 'id="view_bill">View Bill</button>'
                                        '</li>'*/
                                  '</tr>';
                       
      }


$('#appendNewData').append(tableNewDiv);

$('#challanData').show();
}
  
});
});








$(document).ready(function(){
$('#view_bill').hide();
});

$('#view_bill').click(function(){

var tableNewDiv=''; 
var orderNo=$('#purchase_order_no_get').val()
var statusFlag=1;
jQuery.ajax({

          url:"{{route('getChallanBased')}}",
          type:"get",
          data: {
            'order_no':orderNo,
            'flag':statusFlag,
          },
          dataType:'json',
          success: function(data)
          {
          <?php $incre=1;  ?>           
      

      for(var i=0; i<data.length;i++)
      {
          tableNewDiv+='<tr>'+
                            '<td>'+(++i)+'</td>'+
                            '<td>'+data[i].bill_no+'</td>'+
                            '<td>'+data[i].bill_date+'</td>'+
                            '<td>'+data[i].bill_amt+'</td>'+
                            '<td>'+data[i].gst_amt+'</td>'+
                            '<td>'+data[i].total_amount+'</td>'+
                            /*'<td><div class="dropdown">'+
                                    '<button class="btn btn-primary dropdown-toggle" type="button"'+ '   data-toggle="dropdown">Action'+
                                         '<span class="caret"></span>'+
                                    '</button>'+
                                    '<ul class="dropdown-menu">'+
                                       '<li>'+
                                           '<input type="hidden" name="purchase_order_no"'+ 'value="{{$result->purchase_order_no}}" id="purchase_order_no_get"'+ 'id="purchase_order_no_get">'+
                                           '<input type="hidden" name="portal_id"'+ 'value="{{$result->portal_id}}">'+
                                           '<input type="hidden" name="bill_no"'+ 'value="{{$result->bill_no}}">'+
                                           '<input type="hidden" name="bill_date"'+ 'value="{{$result->bill_date}}">'+
                                           '<input type="hidden" name="bill_amt"'+ 'value="{{$result->bill_amt}}">'+
                                            '<input type="hidden" name="gst_amt"'+ 'value="{{$result->gst_amt}}">'+
                                            '<input type="hidden" name="total_amount"'+ 'value="{{$result->total_amount}}">'+
                                            '<button type="submit" class="btn btn-link"'+ 'id="view_bill">View Bill</button>'
                                        '</li>'+*/
                                        /*'<li>'+
                                           '<input type="hidden" name="purchase_order_no"'+ 'value="{{$result->purchase_order_no}}"'+ 'id="purchase_order_no_get">'+
                                           '<input type="hidden" name="portal_id"'+ 'value="{{$result->portal_id}}">'+
                                           '<input type="hidden" name="indent_no"'+ 'value="{{$result->indent_id}}">'+
                                           '<input type="hidden" name="vendor_id"'+ 'value="{{$result->vendor_id}}">'+
                                            '<button type="submit" class="btn btn-link"'+ 'id="view_bill">View Bill</button>'
                                        '</li>'*/
                                  '</tr>';
                       
      }


$('#appendNewDataForBill').append(tableNewDiv);

$('#billData').show();
}
  
});
});













    jQuery('.datetimepicker').datepicker({
      autoclose: true, 
      todayHighlight: true,
      endDate: new Date(),   
      format: 'dd/mm/yyyy'
  });

  $('.display').DataTable({});









</script>

@endsection


