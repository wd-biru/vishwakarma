 @extends('layout.project')

@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;Store</h1>
    </div>
    <div>
        <ul class="breadcrumb"> 
            <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
            <li>{{ link_to_route('projects.index',trans('project.projects'), ['status_id' => request('status_id', $project->status_id)]) }}</li>
            <li>{{ $project->present()->projectLink }}</li>
            <li><a href="">Project Store Stock Maintence</a></li>
            
        </ul>
    </div>
</div>

@endsection

@section('content-project')
@include('projects.partials.nav-store-tabs')
@include('includes.msg')
@include('includes.validation_messages')
<style type="text/css">
    .status{
        width: 15px;
        background: none;
        color: inherit;
        border: none;
        padding: 0;
        font: inherit;
        cursor: pointer;
        outline: inherit;
    }

    .form-horizontal .form-group {
    margin: 8px 0px !important;

}
    .fa-plus-square-o:before {
        font-size: 14px;
        content: "\f196";
        margin-left: 0px;
        position: relative;
        left: -8px;
    }
    a#itemcalculate {
        padding: 6px;
        margin-top: -8px;
        height: 32px;
}
</style>

<div class="row" style="padding-top: 50px;">
  <div class="col-md-12">
      <div  id="alert_msg_item" style="display:none;" class="alert alert-success">
    
        <p style="text-align: center;"></p>
    
      </div>
  </div>
</div>
<div class="row">
    <div class="col-md-12">
    
      <div class="col-md-4">
          <label class="control-label " for="Invoice Date">Invoice Date :</label>
          <input type="text" name="invoicedate" id="invoicedate" class="form-control"  required>  
      </div>
      <div class="col-md-4">
            <label class="control-label " for="Invoice No.">Invoice No. :</label>
            <input type="text" name="invoiceno"  id="invoiceno" class="form-control" required> 
      </div>
 

      <div class="col-md-4">
          <label class="control-label" for="Invoice Date">Inward Date :</label>
          <input type="text" name="inwarddate" id="inwarddate" class="form-control"  required>
      </div>

      <p id="_status" style="color: red;text-align:center"></p>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="col-md-12">
          <table class="">
            <input type="hidden" id="primaryId" name="primaryId" value="">

              <tr>
                <td style="padding:10px;padding-left: 0px">Store</td>
                <td style="padding:10px">Material Group</td>
                <td style="padding:10px">Item</td>
                <td style="padding:10px">Qty.</td>
              </tr>

              <tr>
                <td style="padding:10px;padding-left: 0px;padding-top: 2px;"><input type="text" @if(Auth::user()->user_type == 'employee') 
                  @else  value="{{$store_detail->store_name}}"
                  @endif class="form-control" disabled></td> 
                <td style="padding:10px;padding-top: 2px;">
                  <select style="width: 200px" id="getMaterialList" name="group_id"  class="form-control selectable">

                        <option value="">Select Material Group</option>
                        @foreach($inwards_inventory_material_group as $val_item)
                        <option  value="{{$val_item->id}}">{{$val_item->group_name}}</option>
                        @endforeach
                  </select>
              </td>
              <td style="padding:10px;padding-top: 2px;">
                <select style="width: 200px" id="Items" class="form-control">
                      
                      <option value=""></option>
                    
                </select>
              </td>
              <td style="padding:10px;padding-top: 2px;"><input type="number" min="1" style="width: 100px" title="Numbers only" name="Quantity" id="Quantity" class="form-control"></td>
              <td style="padding-top: -2px;"><a href="#" class="btn btn-primary" data-toggle="modal" id="itemcalculate" title="Add"><i class="fa fa-plus-square-o" style="padding-left: 15px;    padding-top: 3px;"></i></a>  
              </td>
            </tr>
          </table>
    </div>  
  </div>  
</div>  

    <div class="row">
      <div class="col-md-12">
      <table class="table table-striped " id="myTable">
           <thead class="btn-primary">
              <th>Item Name</th><th>Qty</th><th>Action</th>
          </thead>
          <tbody id="selectItem" class="items-det">
                
          </tbody>

          <tfoot id="Total-Qty">
          </tfoot>
      </table>
       
        <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}"/>
        <button type="Submit"  class="btn btn-primary pull-right"  id="store-inv-itm" style="margin-bottom: 15px;">Submit</button> 
        <br>
        

 
      
</div>
    </div> 
@endsection

@section('script')


    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script> 

      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
     
    
        <script type="text/javascript"> 





       



          $(document).ready(function() {
            $('#getMaterialList').on('change', function () {
                var group_id = $(this).val();
                $.ajax({
                    url: "{{route('getItems',[$project->id ,base64_encode($store)])}}",
                    type: 'GET',
                    data: {"group_id": group_id},
                    datatype: 'html',
                    success: function (data) {                 
                        var opt='';
                        jQuery.each(data, function(index,value)
                        {     
                        opt+='<option value="'+value.id+'">'+value.material_name+'</option>';
                        });

                        jQuery('#Items').html(opt);

                    }
                });
            });
        });


                    
             jQuery(document).on('keyup',"#invoiceno",function () {
             var inv_no = jQuery(this).val();

             console.log(inv_no);
             if(inv_no){
                 jQuery.get('{{route("storeInventoryInvoiveCheck",[$project->id ,base64_encode($store)])}}',{
                     inv_no:inv_no, 
                    // '_token': jQuery('meta[name="csrf-token"]').attr('content'),
                 },function(response){
                     if(response=="true")
                     {
                         jQuery('#_status').html("This Invoice Already Exist!!");
                         jQuery('#store-inv-itm').prop('disabled', true);
                         return true;
                     }
                     else
                     {
                         jQuery('#_status').html("");
                         jQuery('#store-inv-itm').prop('disabled', false);
                         return false;
                     }
                 });
             }
             else
             {
                 jQuery('#_status').html("");
                 return false;
             }
          });

                  function matchStart (term, text) {
                      if (text.toUpperCase().indexOf(term.toUpperCase()) == 0) {
                          return true;
                               }
                          return false;
                        }
                  
                  /*$.fn.select2.amd.require(['select2/compat/matcher'], function (oldMatcher) {
                    $("select").select2({
                      matcher: oldMatcher(matchStart)
                    })
                  });*/
                
                  $("#Quantity").keypress(function (e) {
                 //if the letter is not digit then display error and don't type anything
                 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    //display error message
                    $("#errmsg").html("Digits Only").show().fadeOut("slow");
                           return false;
                }
                  if (this.value.length == 0 && e.which == 48 ){
                  return false;
               }
               });


                    var tot_qty_item=[];
                    var selected_item=[];
                    var sum=0;
             jQuery(function(){
                         var vil={
                       init:function(){
                         vil.countItem();
                         },
                                 
                       countItem:function(){

                        jQuery('#itemcalculate').on('click',function(){
                          var Quantity=$("#Quantity").val();
                          
                            var primaryId= $("#primaryId").val();
                            var ItemsId=$("#Items").val();
                            var ItemsName=$('#Items option:selected').html();
                            
                          
                         if(Quantity!=''){
                                    
                            var checkExistItem=jQuery.inArray( ItemsId,selected_item);
                            if(checkExistItem===Number(-1)){
                            selected_item.push(ItemsId);
                            var selected_item_append='<tr id="'+ItemsId+'"  ><td class="itm-detail">'+ItemsName+'</td><td>'+Quantity+'</td><td><a id="'+ItemsId+'" data-itemqty="'+Quantity+'" class="btn btn-danger class-btn-delete" role="button"><i class="fa fa-trash"></i></a></td></tr>';
                            $('#selectItem').append(selected_item_append);
                                  sum=Number(sum)+Number(Quantity);
                            var Total_Qty='<tr><td>Total Qty</td><td>'+sum+'</td></tr>';
                            $('#Total-Qty').html(Total_Qty);
                           }else{
                            $('#alert_msg_item p:nth-child(1)').text('item already exists');
                            $("#alert_msg_item").css("display", "block");
                             setTimeout(function() {
                        $('#alert_msg_item').css('display','none');
                    }, 3000);
                          }
                       
                           }else{
                            
                            $('#alert_msg_item p:nth-child(1)').text('Please Enter Quantity');
                            $("#alert_msg_item").css("display", "block");
                             setTimeout(function() {
                        $('#alert_msg_item').css('display','none');
                    }, 3000);
                          }
                         
                           
                          

                          });
                        
                       },
                    
                 }
                 vil.init();
                   });


              jQuery(document).on('click','.class-btn-delete',function(){
                          var con=confirm("Are you sure you want to delete?");
                          var itemqty=jQuery(this).data('itemqty');
                          var id=$(this).attr('id');
                          if(con==true){
                            $("#"+id).remove();
                          var index = selected_item.indexOf(id);
                          if (index > -1) {
                          selected_item.splice(index, 1);
                                          }
                                          sum=Number(sum)-Number(itemqty);
                              var Total_Qty='<tr><td>Total Qty</td><td>'+sum+'</td></tr>';
                          $('#Total-Qty').html(Total_Qty);

                          }
                           
                  });
              jQuery("#inwarddate").datepicker({ 
                autoclose: true, 
                todayHighlight: true,
                endDate: new Date(),
                defaultDate:'dd/mm/yyy',
                format: 'dd/mm/yyyy',
                  });

              jQuery("#invoicedate").datepicker({ 
                autoclose: true, 
                todayHighlight: true,
                endDate: new Date(),
                defaultDate:'dd/mm/yyy',
                format: 'dd/mm/yyyy',
                  });

                $("#store-inv-itm").click(function(e) {


                 
                   var Item_Id=[];
                   var Item_Qty=[];
                   var store_id=jQuery(this).data('store_id');
                   // console.log(store_id);
                   //var store=$("#store").val(store_id);
                  
                   var group_id=$("#getMaterialList").val();
                   var Inward_date=$("#inwarddate").val();
                   var invoiceno=$("#invoiceno").val();
                   var invoicedate=$("#invoicedate").val();
                   var primaryId=$("#primaryId").val();
                   
                   $('.items-det tr').each(function() {
                    var v=$(this).attr('id');
                    Item_Id.push(v);
                    });
                  $('.items-det td:nth-child(2)').each(function() {
                    var v=$(this).html();
                    Item_Qty.push(v);
                    });
                 if(Inward_date==''){
                
                  $('#alert_msg_item p:nth-child(1)').text('Select Inward_date');
                            $("#alert_msg_item").css("display", "block");
                             setTimeout(function() {
                        $('#alert_msg_item').css('display','none');
                    }, 3000);
                  }else if(invoiceno==''){
                      $('#alert_msg_item p:nth-child(1)').text('Enter invoiceno');
                            $("#alert_msg_item").css("display", "block");
                             setTimeout(function() {
                        $('#alert_msg_item').css('display','none');
                    }, 3000);
                    
                }
                  else if(invoicedate==''){
                   
                    $('#alert_msg_item p:nth-child(1)').text('Select invoicedate');
                    $("#alert_msg_item").css("display", "block");
                     setTimeout(function() {
                        $('#alert_msg_item').css('display','none');
                    }, 3000);
                  }

                  if(Inward_date!='' && invoiceno!='' && invoicedate!=''){
                  if(selected_item.length > 0){

                  $.ajax({
                    type: "POST",
                    url: "{{route('storeInwordStock',[$project->id ,base64_encode($store)])}}",
                    data: { 
                        primaryId: primaryId, 
                        group_id:group_id,
                        store_id:store_id,
                        Inward_date:Inward_date,
                        invoiceno: invoiceno,
                        invoicedate: invoicedate,
                        Item_Id: Item_Id,
                        Item_Qty: Item_Qty,
                        _token: $("#csrf-token").val() 
                    },
                    success: function(result) {
                     

                        Item_Id=[];
                        Item_Qty=[];
                        tot_qty_item=[];
                        selected_item=[];
                        sum=0;
                        checkExistItem=[];
                        
                        $("#inwarddate").val('');
                        $("#invoiceno").val('');
                        $("#invoicedate").val('');
                        
                        $(".items-det").html('');
                        $("#Total-Qty").html('');
                        $("#Quantity").val('');

                        $('#alert_msg_item p:nth-child(1)').text(result);
                        $("#alert_msg_item").css("display", "block");
                           ViewHelpers.notify("success","Saved Succesfully");
                        
                       
                    },
                    error: function(result) {
                          ViewHelpers.notify("error","SomthingWent Wrong");
                    }
                  
                });
                   }else{
                   
                    $('#alert_msg_item p:nth-child(1)').text('atleast one item select');
                    $("#alert_msg_item").css("display", "block");
                    setTimeout(function() {
                        $('#alert_msg_item').css('display','none');
                    }, 3000);
                  }
                 }
                  e.preventDefault();
              });
    </script>
@endsection