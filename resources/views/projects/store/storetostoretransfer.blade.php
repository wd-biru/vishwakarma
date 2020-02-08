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
            <li><a href="">Project Store outward</a></li>
            
        </ul>
    </div>
</div>

@endsection
@section('content-project')
@include('includes.msg')
@include('includes.validation_messages')
@include('projects.partials.nav-store-tabs')
<style type="text/css">
  
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
    margin-top: -53px;
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
    <div class="col-md-12" >
     <div class="col-md-2">
        <label for="request_date">Transition Date:</label>
        <input class="datepicker1 form-control" placeholder="Transition Date" name="transition_date" id="transition_date" type="text" />
    </div>
          <div class="col-md-2" style="margin-left: -20px;">
            <input type="hidden" id="primaryId" name="primaryId" value="{{$getprimaryid->id}}">
            <label for="shift"><a data-toggle="modal" data-target="#From-Godown" class="From">From Store:</a></label>
              <select  id="Primary" class="form-control">                
                   
                  </select> 
          </div>
           <div class="col-md-2" style="margin-left: -20px;">
            <label for="shift"><a data-toggle="modal" data-target="#To-Godown" class="To">To Store</a></label>
               <select  id="Secondary" class="form-control">
                  
                  </select> 
          </div>
            <div class="col-md-3" style="margin-left: -20px;">
              <label for="shift">Material Group</label>
          <select style="width: 200px" id="getMaterialList" name="group_id"  class="form-control">

                        
           </select>
         </div>


           <div class="col-md-2" style="margin-left: -20px;">
            <label for="shift">Item</label>
              
                  <select  id="Items" class="form-control  ">
                   
                  </select>
          </div>
           <div class="col-md-1 " style="margin-left: -20px;">
            <label for="shift">Qty.</label>
            <input type="number" min="1"  name="Quantity" id="Quantity"    class="form-control ">

             <a href="#" data-toggle="modal" id="itemcalculate" title="Add" style="margin-top: -53px;    margin-left: 72px;" class="btn btn-primary  td-button">
                  <i class="fa fa-plus-square-o" style="padding-left: 15px;    padding-top: 3px;"></i>
                </a>
          </div>
           
          </div>
        </div>
  
   
      
      
 
   
    <div class="row">
    <div class="col-md-12 " style="margin-top: 5px" >
      <div class="table-responsive card" >
        <table class="table table-bordered " id="myTable" >
            <thead class="btn-primary">
              <th>Item Name</th><th>Qty</th><th>Action</th>
            </thead>
            <tbody id="selectItem" class="items-det">
                
            </tbody>
            <tfoot id="Total-Qty">
            </tfoot>

        </table>
        <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
        <button type="button"  class="btn btn-primary pull-right" id="store-inv-itm">Submit</button>
      </div>
    </div>
  </div>
 
 


  <div class="row" style="margin-bottom: 40px ">

   <div  class="col-md-12">
      <h4 style="display: none;" id="Alter_Self">View/Alter Self Stock </h4>
   
<div   class="col-md-12 card" id="appenthtml" >
      
</div>
</div> 
  </div>

  


 
            <div class="modal fade  " id="From-Godown" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
                    <h4 class="modal-title" >From Store</h4>
                  </div>
                  <div class="modal-body">  <div class="table-responsive" style="height:300px;overflow: auto">
        <table class="table table-striped ">
            <thead>
              <th>Item Name</th><th>Qty</th>
            </thead>
            <tbody id="fromgodown" class="items-det">
                
            </tbody>
          

        </table>
       
      </div></div></div></div></div>

                  <div class="modal fade  " id="To-Godown" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
                    <h4 class="modal-title" >To Store</h4>
                  </div>
                  <div class="modal-body"><div class="table-responsive" style="height:300px;overflow: auto">
        <table class="table table-striped ">
            <thead>
              <th>Item Name</th><th>Qty</th>
            </thead>
            <tbody id="togodown" class="items-det">
                
            </tbody>
          

        </table>
       
      </div></div></div></div></div>


        <div class="modal fade" id="Mymodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h4 class="modal-title">Update Qty</h4>                                                             
      </div> 
      <div class="modal-body">
         <input type="hidden" class="form-control" id="qty-id">
         <input type="hidden" class="form-control" id="sendgodownid">
        <div class="form-group">
    <label for="email">Qty:</label>
    <input type="text" class="form-control" id="qty-list"  required>
  </div>
      </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="upqty" >Submit</button>                               
      </div>
    </div>                                                                       
  </div>                                          
</div>
    <div class="modal fade" id="MymodalDelEdit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h4 class="modal-title"></h4>                                                             
      </div> 
      <div class="modal-body">
         <input type="hidden" class="form-control" id="qty-id">
         <input type="hidden" class="form-control" id="sendgodownid">
        <p id="messagegodown"></p>
      </div>   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>                               
      </div>
    </div>                                                                       
  </div>                                          
</div>
 
@endsection
@section('script')
  <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script> 
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datejs/1.0/date.min.js"></script>
      <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> 
      <script type="text/javascript"> 
      function matchStart (term, text) {
          if (text.toUpperCase().indexOf(term.toUpperCase()) == 0) {
              return true;
                   }
              return false;
            }
 
      // $.fn.select2.amd.require(['select2/compat/matcher'], function (oldMatcher) {
      //   $("#Items").select2({
      //     matcher: oldMatcher(matchStart)
      //   })
      // });
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
            vil.getstore();
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



              
            getstore:function(){

           


                  $.ajax({
                    type: "get",
                    url: "{{route('getstore',[$project->id,base64_encode($store)])}}",
                    data: { 
                         
                    },
                    success: function(result) {
                                   var from ='<option value="0">Please Select</option>';
                                   var to='<option value="0">Please Select</option>';
                                    jQuery.each(result,function(i,v){

            
                                      from+='<option value="'+v.id+'">'+v.store_name+'  ('+v.name+')</option>';
                                  });
                                 $('#Primary').html(from);
                                  jQuery.each(result,function(j,k){
                                      if($('#Primary').val()!=k.id)
                                     {
                                      to+='<option value="'+k.id+'">'+k.store_name+'  ('+k.name+')</option>';
                                     }
                                  });
                                $('#Secondary').html(to);

                             var from_store =  $('#Primary').val();

                             $.ajax({
                          type: "get",
                          url: "{{route('getMaterialItemAndGroup',[$project->id,base64_encode($store)])}}",
                          data: { 

                             store_id:from_store
                          },
                          success: function(result) {

                                      
                                     var material_group='<option value="0">Please Select</option>';
                                        jQuery.each(result,function(i,v){
                                           
                                           material_group+='<option value="'+v.id+'">'+v. group_name+'</option>';
                                        });
                           $('#getMaterialList').html(material_group);        
                          },      
                           error: function(result) {
                              alert('error in getting group id');
                          }
                        
                      });  

 
                    },      
                     error: function(result) {
                        alert('error');
                    }
                  
                }); 
        }
    }

     vil.init();
       });




                  $('#Primary').on('change', function() {


                       var from_store =  $('#Primary').val();


                            $.ajax({
                          type: "get",
                          url: "{{route('getstore',[$project->id,base64_encode($store)])}}",
                          data: { 

                             store_id:from_store
                          },
                          success: function(result) {
                                   var to='';
   
                                  jQuery.each(result,function(j,k){
                                      if($('#Primary').val()!=k.id)
                                     {
                                      to+='<option value="'+k.id+'">'+k.store_name+'  ('+k.name+')</option>';
                                     }
                                  });
                                       $('#Secondary').html(to);  


                     $.ajax({
                          type: "get",
                          url: "{{route('getMaterialItemAndGroup',[$project->id,base64_encode($store)])}}",
                          data: { 

                             store_id:from_store
                          },
                          success: function(result) {
                           // console.log(result);
                           var material_group='<option value="0">Please Select</option>';
                                        jQuery.each(result,function(i,v){
                                           
                                           material_group+='<option value="'+v.id+'">'+v.group_name+'</option>';
                                        });
                           $('#getMaterialList').html(material_group); 
                            $('#Items').html('');        
                          },      
                           error: function(result) {
                              alert('error in getting group id');
                          }
                        
                      });  
                          },      
                           error: function(result) {
                              alert('error in getting group id');
                          }
                        
                      });

 
                    });
                  
              
         

                $("#store-inv-itm").click(function(e) {
                 
                   var Item_Id=[];
                   var Item_Qty=[];


                   var from_store=$("#Primary").val();
                   var to_store=$("#Secondary").val();
                  var transition_date =  $("#transition_date").val();


                   
                   $('.items-det tr').each(function() {
                    var v=$(this).attr('id');
                    Item_Id.push(v);
                    });
                  $('.items-det td:nth-child(2)').each(function() {
                    var v=$(this).html();
                    Item_Qty.push(v);
                    });
                 if(transition_date==''){


                
                  $('#alert_msg_item p:nth-child(1)').text('Select Transition date');
                            $("#alert_msg_item").css("display", "block");
                             setTimeout(function() {
                        $('#alert_msg_item').css('display','none');
                    }, 3000);
                             return false;

                  }else if(Item_Qty==''){
                      $('#alert_msg_item p:nth-child(1)').text('Enter Quantity');
                            $("#alert_msg_item").css("display", "block");
                             setTimeout(function() {
                        $('#alert_msg_item').css('display','none');
                    }, 3000);
                    
                }
                  else if(Item_Id==''){
                   
                    $('#alert_msg_item p:nth-child(1)').text('Select invoicedate');
                    $("#alert_msg_item").css("display", "block");
                     setTimeout(function() {
                        $('#alert_msg_item').css('display','none');
                    }, 3000);
                  }

                  if(from_store!='' && to_store!='' && Item_Id!=''){
                  if(selected_item.length > 0){

                     var transition_date = $('#transition_date').val();
                     var group_id = $('#getMaterialList').val();

                     
                  $.ajax({

                    type: "GET",
                    url: "{{route('checkItemInPrigodown',[$project->id,base64_encode($store)])}}",
                    data: { 
                       
                       
                        Item_Id: Item_Id,
                        Item_Qty: Item_Qty,
                        from_store:from_store,
                        to_store:to_store,
                        group_id:group_id,
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
                        $('#Primary').val('0');
                        $('#Secondary').val('0');
                        $('#getMaterialList').val('0');
                        $('#Items').val('0');
                        
                        

                        $('#alert_msg_item p:nth-child(1)').text(result);
                        $("#alert_msg_item").css("display", "block");
                         setTimeout(function() {
                        $('#alert_msg_item').css('display','none');
                    }, 3000);
                        
                       
                    },
                    error: function(result) {
                        alert('error');
                    }
                  
                });
                   }else{
                   
                    $('#alert_msg_item p:nth-child(1)').text('Atleast one item select');
                    $("#alert_msg_item").css("display", "block");
                    setTimeout(function() {
                        $('#alert_msg_item').css('display','none');
                    }, 3000);
                  }
                 }
                  e.preventDefault();
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
              if(sum==0){
              $( "#Primary" ).prop( "disabled", false );
              $( "#Secondary" ).prop( "disabled", false );

            }
              }
               
      });





  $('#getMaterialList').on('change', function() {

                  $('#Items').html('');  
                   var material_group_id =  $('#getMaterialList').val();
                   var store =  $('#Primary').val();
                           
                      $.ajax({
                          type: "get",
                          url: "{{route('getItemsforstoretostore',[$project->id,base64_encode($store)])}}",
                          data: { 

                             group_id:material_group_id,
                             store_id:store,
                          },
                          success: function(result) {

                            console.log(result);
                           
                                         var Items='Plsease Select';
                                        jQuery.each(result,function(i,v){
                                           
                                           Items+='<option value="'+v.id+'">'+v.material_name+'  ('+v.availableQty+')</option>';
                                        });
                           $('#Items').html(Items);        
                          },      
                           error: function(result) {
                              alert('error in item id');
                          }
                        
                      });  


       });


 


    jQuery(document).on('click','.From',function(){ 
      var store_id=$("#Primary").val();     
            $.ajax({
        type: "get",
        url: "{{route('getgodownItem',[$project->id,base64_encode($store)])}}",
        data: { 
            godownId: store_id 
            
           
          
        },
        success: function(result) {
        

          if(result.data.length > 0){
          var godown_item='';
          for(var i=0;i < result.data.length;i++){
            godown_item+='<tr><td>'+result.data[i].material_name+'</td><td>'+result.data[i].Quantity+'</td></tr>';

          }
          $("#fromgodown").html(godown_item);
        }else{
          $("#fromgodown").html('<tr colspan="2"><td>Record Not Found</td></tr>');
        }
        },      
         error: function(result) {
            alert('error');
        }
      
    });     
      });









      jQuery(document).on('click','.To',function(){
      
              var SecondaryId=$("#Secondary").val();
           
             $.ajax({
        type: "get",
        url: "{{route('getgodownItem',[$project->id,base64_encode($store)])}}",
        data: { 
             
           
            godownId:SecondaryId
            
          
        },
        success: function(result) {
          if(result.data.length > 0){
          var godown_item='';
          for(var i=0;i < result.data.length;i++){
            godown_item+='<tr><td>'+result.data[i].Item_Name+'</td><td>'+result.data[i].Quantity+'</td></tr>';

          }
          $("#togodown").html(godown_item);
        }
          else{
          $("#togodown").html('<tr colspan="2"><td>Record Not Found</td></tr>');
        }

        },      
         error: function(result) {
            alert('error');
        }
      
    });     
      }); 

  

   
 
if($("#Secondary").val()){

    $('#appenthtml').show();

 
    
    var godownshift=$(".godownshift").val();
      var id=$("#Secondary").val();
      var Primary=$("#Primary").val();
      var godownname=$("#Secondary option:selected").text();
      $('#Alter_Self').css('display','none');
       $.ajax({
        type: "get",
        url: "{{route('getgodownItemlist',[$project->id,base64_encode($store)])}}",
        data: { 
             
           
            godownId:id,
            Primary:Primary,
            godownshifts:godownshift
            
          
        },
        success: function(result) {
         
          if(result.data.length > 0){
           var godown_items='';
          for(var i=0;i < result.data.length;i++){
           if(result.data[i].qty!=0){
            if(result.data[i].sumqty==null){
          
            godown_items+=' <tr id="'+result.data[i].id+'"><td>'+result.data[i].name+'</td><td>'+godownname+'</td><td>'+result.data[i].Item_Name+'</td><td>'+result.data[i].qty+'</td><td>'+new Date(result.data[i].transaction_date).toString('dd-MM-yyyy')+'</td><td><div class="btn-group"><button type="button" class="btn btn-danger">Action</button><button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button><ul class="dropdown-menu" role="menu"><li><a onclick="appenddata('+result.data[i].id+','+result.data[i].qty+','+result.data[i].send_godown_id+');" >Edit</a></li><li><a id="'+result.data[i].id+'" data-itemqty="" class="class-btn-delete-list">Delete</a></li></ul></div></td></tr>';
          }else{
            godown_items+=' <tr id="'+result.data[i].id+'"><td>'+result.data[i].name+'</td><td>'+godownname+'</td><td>'+result.data[i].Item_Name+'</td><td>'+result.data[i].qty+'</td><td>'+new Date(result.data[i].transaction_date).toString('dd-MM-yyyy')+'</td><td><div class="btn-group"><button type="button" class="btn btn-danger">Action</button><button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button><ul class="dropdown-menu" role="menu"></ul></div></td></tr>';
          }
          }
            

          }

          var html=tranferhtmldatatable();
          
          $("#appenthtml").html(html);
           $("#godownlistning").append(godown_items);
          $('#godownedit').DataTable( );
       $('#Alter_Self').css('display','block');
        }else{
          /*$("#godownlistning").html('<tr class="odd"><td valign="top" colspan="5" class="dataTables_empty">No data available in table</td></tr>');*/
          var html=tranferhtmldatatable();
          $("#appenthtml").html(html);
           $('#godownedit').DataTable( );
           $('#Alter_Self').css('display','block');
          }
       

        },      
         error: function(result) {
            alert('error');
        }
      
    }); 


  
  }else{
    $('#appenthtml').hide();
  }






     jQuery(document).on('click','.class-btn-delete-list',function(){
              var con=confirm("Are you sure you want to delete?");
             
              var id=$(this).attr('id');
             var godownid=$( "#Secondary" ).val();

             var shift=$('.godownshift').val();
              if(con==true){
               
                $(this).closest("tr").remove();
                 $.ajax({
        type: "get",
        url: "{{route('godownItemdeletelist',[$project->id,base64_encode($store)])}}",
        data: { 
             
           
            invId:id,
            shift:shift,
            godownid:godownid
          
        },
        success: function(result) {
          if(result.success){
        $('#messagegodown').html('<span style="color:red">Delete Successfully</span>');
$('#MymodalDelEdit').modal('show');
            $('#godownlistning tr#'+result.data+'').remove();
          }
         if($("#Secondary").val()){
        
    $('#appenthtml').show();

          var id=$("#Secondary").val();
          var Primary=$("#Primary").val();
          var godownshift=$(".godownshift").val();
      var godownname=$("#Secondary option:selected").text();
      $('#Alter_Self').css('display','none');
       $.ajax({
        type: "get",
        url: "{{route('getgodownItemlist',[$project->id,base64_encode($store)])}}",
        data: { 
             
           
            godownId:id,
            Primary:Primary,
            godownshifts:godownshift
          
        },
        success: function(result) {
          if(result.data.length > 0){
           var godown_itemss='';
          for(var i=0;i < result.data.length;i++){
           if(result.data[i].qty!=0){
    if(result.data[i].sumqty==null){
            godown_itemss+=' <tr id="'+result.data[i].id+'"><td>'+result.data[i].name+'</td><td>'+godownname+'</td><td>'+result.data[i].Item_Name+'</td><td>'+result.data[i].qty+'</td><td>'+new Date(result.data[i].transaction_date).toString('dd-MM-yyyy')+'</td><td><div class="btn-group"><button type="button" class="btn btn-danger">Action</button><button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button><ul class="dropdown-menu" role="menu"><li><a onclick="appenddata('+result.data[i].id+','+result.data[i].qty+','+result.data[i].send_godown_id+');" >Edit</a></li><li><a id="'+result.data[i].id+'" data-itemqty="" class="class-btn-delete-list">Delete</a></li></ul></div></td></tr>';
          }else{
            godown_itemss+=' <tr id="'+result.data[i].id+'"><td>'+result.data[i].name+'</td><td>'+godownname+'</td><td>'+result.data[i].Item_Name+'</td><td>'+result.data[i].qty+'</td><td>'+new Date(result.data[i].transaction_date).toString('dd-MM-yyyy')+'</td><td><div class="btn-group"><button type="button" class="btn btn-danger">Action</button><button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button><ul class="dropdown-menu" role="menu"></ul></div></td></tr>';
          }
            }

          }
          var html=tranferhtmldatatable();
            $("#appenthtml").html(html);
           $("#godownlistning").append(godown_itemss);

          $('#godownedit').DataTable(  );
       $('#Alter_Self').css('display','block');
        }else{
         var html=tranferhtmldatatable();
          $("#appenthtml").html(html);
           $('#godownedit').DataTable( );
           $('#Alter_Self').css('display','block');
          }
       

        },      
         error: function(result) {
            alert('error');
        }
      
    }); 
        } else{
    $('#appenthtml').hide();
  } 

   var setgodownpri=$('#Primary').val();
                    if(setgodownpri){
                      jQuery.post("{{route('getitemfromPriGodow',[$project->id,base64_encode($store)])}}",{
                   '_token': jQuery('meta[name="csrf-token"]').attr('content'),
                    'setgodownpri':setgodownpri,
                   },function(resitm){
                    
                        if(resitm.length > 0){
                        var itmgodowns='';
                        for(var i=0;i < resitm.length;i++){
              
                         if(parseInt(resitm[i].itmStock) > 0){
itmgodowns+='<option value="'+resitm[i].id+'" data-val_name="'+resitm[i].Item_Name+'">'+resitm[i].Item_Name+'(Qty:'+resitm[i].itmStock+')'+'</option>';
            }

                        }
                        if(itmgodowns!=''){
                          $('#Items').html(itmgodowns);
                        }else{
             $('#Items').html(''); 
            }
                      }else{
             $('#Items').html(''); 
            }


                   });

                    }

        },      
         error: function(result) {
            alert('error');
        }
      
    }); 

              }
              });
 



     $("#upqty").click(function(){
 
 
var shiftgodownid=$('.godownshift').val();
   var id=$('#qty-id').val();
var qty=$('#qty-list').val();
var sendgodownid=$('#sendgodownid').val();
var shift=$( "#Secondary option:selected" ).data('shift_idss');
     var godownid=$( "#Secondary option:selected" ).val();
      $.ajax({
        type: "get",
      
        data: { 
             
           shiftgodownid:shiftgodownid,
            id:id,
            qty:qty,
            shift:shift,
            godownid:godownid,
            sendgodownid:sendgodownid

            
          
        },
        success: function(result) {
          if(result.success){
    $('#godownlistning tr#'+result.success+' td:nth-child(4)').text(result.data);
    $('#messagegodown').html('<span style="color:red">Update Successfully</span>');
    $('#Mymodal').modal('hide')
    $('#MymodalDelEdit').modal('show');
   
          }else{
            alert('Stock Not Available');
          }
          var setgodownpri=$('#Primary').val();
                    if(setgodownpri){
                      jQuery.post("{{route('getitemfromPriGodow',[$project->id,base64_encode($store)])}}",{
                   '_token': jQuery('meta[name="csrf-token"]').attr('content'),
                    'setgodownpri':setgodownpri,
                   },function(resitm){
                    
                        if(resitm.length > 0){
                        var itmgodowns='';
                        for(var i=0;i < resitm.length;i++){
              
                         if(parseInt(resitm[i].itmStock) > 0){
itmgodowns+='<option value="'+resitm[i].id+'" data-val_name="'+resitm[i].Item_Name+'">'+resitm[i].Item_Name+'(Qty:'+resitm[i].itmStock+')'+'</option>';
            }

                        }
                        if(itmgodowns!=''){
                          $('#Items').html(itmgodowns);
                        }else{
             $('#Items').html(''); 
            }
                      }else{
             $('#Items').html(''); 
            }


                   });

                    } 
        },      
         error: function(result) {
            alert('error');
        }
      
    }); 
    });
 jQuery(".datepicker1").datepicker({ 
                    autoclose: true, 
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
              });

             


              $(".godownshift").on('change', function (e) {

                var shifttransfer=$('.godownshift').val();
                     if(shifttransfer){
                           jQuery.get('getShiftByGodowntransfer',{
                   
                    'request_shift_trans':shifttransfer,
                   },function(res){
                   
                   var strs='';

                      jQuery.each(res,function(i,v){
                         strs+='<option value="'+i+'">'+v+'</option>';
                      });
                      secondry='';
                      var priId_godown=@json($getprimaryid->id);
                      jQuery.each(res,function(i,v){
                        if(priId_godown!=i){
    secondry+='<option id="'+i+'" value="'+i+'">'+v+'</option>';
                      }
                      });
                      $('#Secondary').html(secondry);
                      //show tranfer item in table
                        if($("#Secondary").val()){ 


    $('#appenthtml').show();

  
   var godownshift=$(".godownshift").val();
      var id=$("#Secondary").val();
      var Primary=$("#Primary").val();
      var godownname=$("#Secondary option:selected").text();
      $('#Alter_Self').css('display','none');
       $.ajax({
        type: "get",
        url: "{{route('getgodownItemlist',[$project->id,base64_encode($store)])}}",
        data: { 
             
           
            godownId:id,
            Primary:Primary,
            godownshifts:godownshift

            
          
        },
        success: function(result) {
         
          if(result.data.length > 0){
           var godown_items='';
          for(var i=0;i < result.data.length;i++){
           if(result.data[i].qty!=0){
            if(result.data[i].sumqty==null){
            godown_items+=' <tr id="'+result.data[i].id+'"><td>'+result.data[i].name+'</td><td>'+godownname+'</td><td>'+result.data[i].Item_Name+'</td><td>'+result.data[i].qty+'</td><td>'+new Date(result.data[i].transaction_date).toString('dd-MM-yyyy')+'</td><td><div class="btn-group"><button type="button" class="btn btn-danger">Action</button><button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button><ul class="dropdown-menu" role="menu"><li><a onclick="appenddata('+result.data[i].id+','+result.data[i].qty+','+result.data[i].send_godown_id+');" >Edit</a></li><li><a id="'+result.data[i].id+'" data-itemqty="" class="class-btn-delete-list">Delete</a></li></ul></div></td></tr>';
          }else{
            godown_items+=' <tr id="'+result.data[i].id+'"><td>'+result.data[i].name+'</td><td>'+godownname+'</td><td>'+result.data[i].Item_Name+'</td><td>'+result.data[i].qty+'</td><td>'+new Date(result.data[i].transaction_date).toString('dd-MM-yyyy')+'</td><td><div class="btn-group"><button type="button" class="btn btn-danger">Action</button><button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button><ul class="dropdown-menu" role="menu"></ul></div></td></tr>';
          }
          }
            

          }
          var html=tranferhtmldatatable();
            $("#appenthtml").html(html);
          $("#godownlistning").append(godown_items);
          $('#godownedit').DataTable( );
       $('#Alter_Self').css('display','block');
        }else{
           var html=tranferhtmldatatable();
          $("#appenthtml").html(html);
           $('#godownedit').DataTable( );
           $('#Alter_Self').css('display','block');
          }
       

        },      
         error: function(result) {
            alert('error');
        }
      
    }); 


  
  }else{
    $('#appenthtml').hide();
  } 
                      //show tranfer item in table end
                      $('#Primary').html(strs);
                      var setgodownpri=$('#Primary').val();
                    if(setgodownpri){
                      jQuery.post("{{route('getitemfromPriGodow',[$project->id,base64_encode($store)])}}",{
                   '_token': jQuery('meta[name="csrf-token"]').attr('content'),
                    'setgodownpri':setgodownpri,
                   },function(resitm){
                    
                        if(resitm.length > 0){
                        var itmgodowns='';
                        for(var i=0;i < resitm.length;i++){
              
                         if(parseInt(resitm[i].itmStock) > 0){
itmgodowns+='<option value="'+resitm[i].id+'" data-val_name="'+resitm[i].Item_Name+'">'+resitm[i].Item_Name+'(Qty:'+resitm[i].itmStock+')'+'</option>';
            }

                        }
                        if(itmgodowns!=''){
                          $('#Items').html(itmgodowns);
                        }else{
             $('#Items').html(''); 
            }
                      }else{
             $('#Items').html(''); 
            }


                   });

                    }


                     });
                         }


              });
    </script>
                 
@endsection