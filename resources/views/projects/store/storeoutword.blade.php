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
@include('includes.msg')
@include('includes.validation_messages')
@include('projects.partials.nav-store-tabs')
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

       <?php $store_name = DB::table('vishwa_project_store')->where('id','=',$store)->first(); ?>  
      <div class="col-md-2">
          <label class="control-label " for="Invoice No.">Store:</label>
          @if(Auth::user()->user_type == 'employee') 
          <input type="text"  readonly="" class="form-control">
                  @else  <input type="text" value="{{$store_name->store_name}}"  readonly="" class="form-control">
                  @endif
         
      </div>

    
      <div class="col-md-2">
          <label class="control-label " for="Invoice Date">Transition Date:</label>
          <input type="text" name="transition_date" id="inwarddate" placeholder="Transition Date" class="form-control"  required>  
      </div>
            <div class="col-md-2">
          <label class="control-label">Tower:</label>
           <select class="form-control selectable" id="tower">
                    <option  value="">Please Select</option>
                      @if(isset($VishwaProjectTower))
                        @foreach($VishwaProjectTower as $list)
                        <option  value="{{$list->id}}">{{$list->tower_name}}</option>
                        @endforeach
                      @endif
                </select>
      </div>
    <div class="col-md-2">
        <label class="control-label " for="Invoice No.">Material Group:</label>
                <select   id="getMaterialList" class="form-control selectable">
                    <option  value="">Please Select</option>
                      @foreach($material_item as $list)
                      <option  value="{{$list->id}}">{{$list->group_name}}</option>
                      @endforeach
                </select>
             
            
      </div>
        
      <div class="col-md-2">
        <label class="control-label " for="Invoice No.">Material Item:</label>
        <select   id="Items" class="form-control  ">
                       
                </select>
             
            
      </div>
      <div class="col-md-1">
         <label class="control-label " for="Invoice No.">QTY :</label>
         <input type="number" min="1"  placeholder="QTY" title="Numbers only" name="Quantity" id="Quantity" class="form-control"> 
         
      </div>
      <div class="col-md-1">
        <a href="#" class="btn btn-primary" data-toggle="modal" id="itemcalculate" title="Add" style="
    margin-top: 22px;
    
"><i class="fa fa-plus-square-o" style="padding-left: 15px;"></i></a>
          
         
      </div>

      <p id="_status" style="color: red;text-align:center"></p>
  </div>
</div>
 
 
<br>
<br>
   
<div class="row">
<div class="col-md-12 " style="margin-bottom: 50px">
      <table class="table table-striped " id="myTable">
          <thead class="btn-primary">
              <th>Item Name</th><th>Qty</th><th>Action</th>
          </thead>
          <tbody id="selectItem" class="items-det">
                
          </tbody>

          <tfoot id="Total-Qty">
          </tfoot>

        
      </table>

 <button type="button"  class="btn btn-primary pull-right" id="store-inv-itm">Submit</button>
      </div>
</div>
@endsection

@section('script')


    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script> 

      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
     
    
                  <script type="text/javascript"> 

                     

                
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

                   var transition_date=$("#inwarddate").val();

                  
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
                 if(transition_date==''){
                
                  $('#alert_msg_item p:nth-child(1)').text('Select Transition Date');
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

                  if(transition_date!='' && invoiceno!='' && invoicedate!=''){
                  if(selected_item.length > 0){

                   var group_id=$("#getMaterialList").val();
                   var tower_id=$("#tower").val();



                  $.ajax({

                    type: "GET",
                    url: "{{route('storeoutwardstock',[$project->id,base64_encode($store)])}}",
                    data: { 
                       
                       
                        Item_Id: Item_Id,
                        Item_Qty: Item_Qty,
                        group_id: group_id,
                        tower_id: tower_id,
                        transition_date:transition_date,
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

                        $("#tower").val('0');
                        $("#getMaterialList").val('0');
                        $("#Items").val('0');

                      $('#alert_msg_item p:nth-child(1)').text(result);
                        $("#alert_msg_item").css("display", "block");
                           //ViewHelpers.notify("success","Saved Succesfully");
                        
                       
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


     $(document).ready(function() {
            $('#getMaterialList').on('change', function () {
                var group_id = $(this).val();
                $.ajax({
                    url: "{{route('getItemsmaterialforoutward',[$project->id ,base64_encode($store)])}}",
                    type: 'get',
                    data: {"group_id": group_id,},
                        
                    datatype: 'html',
                    success: function (data) {                 
                        var opt='';
                        jQuery.each(data, function(index,value)
                        {     
                        opt+='<option value="'+value.id+'">'+value.material_name+' ('+value.availableQty+')</option>';
                        });

                        jQuery('#Items').html(opt);

                    }
                });
            });
        });











    </script>
@endsection