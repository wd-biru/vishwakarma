  @extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Generate Bill/ Challan</h1>
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
                        <form  action="{{route('PurchaseOrder.getPurchaseDataNew')}}" method="post">
                             {{ csrf_field() }}
                             <div class="row">
                                <div class="col-md-2">
                                <label>Search Purchase Order</label>
                                <input type="text" class="form-control input-sm" name="search_po" autocomplete="off" placeholder="Enter PO">
                              </div> 
                              <!-- <div class="col-md-2">
                                <label>Search Vendor</label>
                                <input type="text" class="form-control input-sm" name="search_po" autocomplete="off" placeholder="Enter Vendor">
                              </div>  -->
                                
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

<!-- /////////////////////////Purchase Order View ////////////////////////// -->
                                

 <div class="row" id="purchaseData">
  <div  class="col-md-12">
    <div style="margin-top: 10px;background: #fff;padding: 15px;">
      <table class="table display" >
      <thead>
        <tr>
            <th>Sr. No</th>
            <th>Purchase Order No</th>
            <th>PO Date</th>
            <th>Indent Id</th>
            <th>Total Amount</th>
            <th>Action</th>
        </tr>
      </thead>
          <tbody><?php $i=1;?>
            @if($purchaseData!='')
                @foreach($purchaseData as $result)
                    <tr>
                        <td>{{$i++}}</td>
                        
                        <td>{{$result->purchase_order_no}}</td>
                        <td>{{$result->date}}</td>
                        <td>{{$result->indent_id}}</td>
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
                                          <button type="submit" class="btn btn-link">DOWNLOAD PO</button>

                                        </form>
                                      </li>
                                        <li>
                                            <input type="hidden" name="purchase_order_no" value="{{$result->purchase_order_no}}">
                                           <input type="hidden" name="portal_id" value="{{$result->portal_id}}">
                                           <input type="hidden" name="indent_no" value="{{$result->indent_id}}">
                                           <input type="hidden" name="vendor_id" value="{{$result->vendor_id}}">
                                            <button  class="btn btn-link" id="view_challan" data-order="{{$result->purchase_order_no}}" >VIEW CHALLAN</button>
                                          </li>

                                          </form>
                                      </li>
                                        <li><form action="{{route('vendorChallan') }}"  method="post">
                                            {{csrf_field()}} 
                                            <input type="hidden" name="purchase_order_no" value="{{$result->purchase_order_no}}">
                                           <input type="hidden" name="portal_id" value="{{$result->portal_id}}">
                                           <input type="hidden" name="indent_no" value="{{$result->indent_id}}">
                                           <input type="hidden" name="vendor_id" value="{{$result->vendor_id}}">
                                           <button type="submit" class="btn btn-link">CREATE CHALLAN</button>
                                           
                                          </form></li>

                                          </form>
                                      </li>

                                        <!-- <li><form action="{{route('vendorBill') }}"  method="post">
                                            {{csrf_field()}} 
                                            <input type="hidden" name="purchase_order_no" value="{{$result->purchase_order_no}}">
                                           <input type="hidden" name="portal_id" value="{{$result->portal_id}}">
                                           <input type="hidden" name="indent_no" value="{{$result->indent_id}}">
                                           <input type="hidden" name="vendor_id" value="{{$result->vendor_id}}">
                                            <button type="submit" class="btn btn-link">Create Bill</button>
                                          </form></li>

                                          </form> -->
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
             @endif
          </tbody>
    </table>


               </div>
        </div>
</div>  
   
 
<!-- /////////////////////////Challan View ////////////////////////// -->


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
    <?php $i=1;?>
            @if($challanData!='')
                @foreach($challanData as $result)
                    
                        

                       <!--  @if(Auth::user()->user_type=="vendor")
                      
                           <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" id="view_challan_button">Action
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                  

                                        <li><form action="{{route('vendorBill') }}"  method="post">
                                            {{csrf_field()}} 
                                            <input type="hidden" name="purchase_order_no" value="{{$result->purchase_order_no}}">
                                           <input type="hidden" name="portal_id" value="{{$result->portal_id}}">
                                           <input type="hidden" name="indent_no" value="{{$result->date}}">
                                           <input type="hidden" name="vendor_id" value="{{$result->vendor_id}}">
                                            <button type="submit" class=" tn btn-link">CREATE BILL</button>
                                          </form></li>

                                           <li><form action="{{route('vendorChallan') }}"  method="post">
                                            {{csrf_field()}} 
                                            <input type="hidden" name="purchase_order_no" value="{{$result->purchase_order_no}}">
                                           <input type="hidden" name="portal_id" value="{{$result->portal_id}}">
                                           <input type="hidden" name="indent_no" value="{{$result->indent_id}}">
                                           <input type="hidden" name="vendor_id" value="{{$result->vendor_id}}">
                                            <button type="submit" class="btn btn-link">VIEW BILL</button>
                                          </form></li>
 
                                      </li>
                                
                                        
                                    </ul>
                                </div>
                            </td>
                        <td>
                        @else -->
<!-- 
                          <td><form action="{{route('PurchaseOrder.ViewAndDownloadPDF')}}"  method="post">
                                         {{csrf_field()}} 
                             <input type="hidden" name="purchase_order_no" value="{{$result->purchase_order_no}}">
                             <input type="hidden" name="portal_id" value="{{$result->portal_id}}">
                             <input type="hidden" name="indent_no" value="{{$result->date}}">
                             <input type="hidden" name="voucher_no" value="{{$result->voucher_no}}">
                             <input type="hidden" name="vendor_id" value="{{$result->vendor_id}}">
                             <button type="submit" class="btn btn-primary">Download PO</button>
                           </form></td> -->
                        @endif
                    </tr>
              @endforeach
             @endif 

               </div>
        </div>
</div>  
 

 
  

<!-- /////////////////////////Bill View ////////////////////////// -->


<div class="row" id="billData">
  <div  class="col-md-12">
    <div style="margin-top: 10px;background: #fff;padding: 15px;">
      <table class="table display" >
      <thead>
        <tr>
            <th>Sr. No</th>
            
            <th>Bill No</th>
            <th>Bill Date</th>
            <th>Bill Amt.</th>
            <th>Tax</th>
            <th>Net Amt.</th>
        </tr>
      </thead>
          <tbody  id="appendTableviewOfBill"> <?php $i=1;?>
            @if($billData!='')
                @foreach($billData as $result)
                    
                        
                       <!--  @if(Auth::user()->user_type=="vendor")
                      
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
                                          <button type="submit" class="btn btn-link">Download Bill</button>

                                    
                                        
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
                    </tr> -->
              @endforeach
             @endif 
          </tbody>
    </table>


               </div>
        </div>
</div> 


@endsection	

@section('script')
 

<script>


$(document).ready(function(){

$('#challanData').hide();
$('#billData').hide();

});

/*<!-- /////////////////////////Script for viewing Challan ////////////////////////// -->*/

$('#view_challan').click(function(){



var tableNewDiv=''; 
var orderNo=$(this).attr('data-order')

jQuery.ajax({

          url:"{{route('getChallanBased')}}",
          type:"get",
          data: {
            "order_no":orderNo,
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
                            '<td><button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> Action <span class="caret"></span></button> <ul class="dropdown-menu"> <li> <button type="submit" class=" tn btn-link">CREATE BILL</button></li> <li> <button type="submit" class=" tn btn-link" id="view_bill" data-order="{{$result->purchase_order_no}}">VIEW BILL</button></li>' +
                       '</tr>';
                       
      }


$('#appendNewData').append(tableNewDiv);

$('#challanData').show();


/*<!-- /////////////////////////Script for viewing Bill ////////////////////////// -->*/

          //     ViewHelpers.notify("success","Resource Allocated");
          //   // window.location.reload();
          //   }
          //   else
          //   {
          //     ViewHelpers.notify("error",'Already Exist');
          //   }
          // },
          // error: function(err){
          //     //alert(err) ;
          // }
      }
    });


});


$('#view_bill').click(function(){

var tableNewDiv=''; 
var orderNo=$(this).attr('data-order')

jQuery.ajax({

          url:"{{route('getChallanBased')}}",
          type:"get",
          data: {
            "order_no":orderNo,
          },
          dataType:'json',
          success: function(data)
          {


   
   <?php $incre=1;  ?>           
      

      for(var i=0; i<data.length;i++)
      {
          tableNewDiv+='<tr>'+
                            '<td>abc</td>'+
                            '<td>'+data[i].bill_no+'</td>'+
                            '<td>'+data[i].bill_amt+'</td>'+
                            '<td>'+data[i].gst_amt+'</td>'+
                            '<td>'+data[i].total_amount+'</td>'+
                        '</tr>';
      }
$('#appendTableviewOfBill').append(tableNewDiv);
$('#billData').show();
}
});
});

function myFunction() {
  var x = document.getElementById("purchaseData");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}



  

    jQuery('.datetimepicker').datepicker({
      autoclose: true, 
      todayHighlight: true,
      endDate: new Date(),   
      format: 'dd/mm/yyyy'
  });

  $('.display').DataTable({});








</script>

@endsection
 

