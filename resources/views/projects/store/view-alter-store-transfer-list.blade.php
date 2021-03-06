@extends('layout.project')
<link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet"/>
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
            <li><a href="">View & Alter Inward </a></li>
            
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

  <?php
  $from_date_input=0;
    if(isset($_GET['from_date'])){ 
        $from_date_input=$_GET['from_date']; 
      } 
      $to_date_input=0;
    if(isset($_GET['to_date'])){
        $to_date_input=$_GET['to_date'];
    }
    ?>
    <div class="col-md-12 card" style="padding:15px">
    
     
        <div class="col-md-2 date_change">
          <label>From Date</label>
          <input type="text" class="datetimepicker form-control" autocomplete="off" @if($from_date_input!=0) value="{{$from_date_input}}"@endif  id="from" required>
        </div> 
        <div class="col-md-2 date_change">
          <label>To Date</label>
          <input type="text" class="datetimepicker form-control" autocomplete="off" @if($to_date_input!=0) value="{{$to_date_input}}" @endif  id="to" required>
        </div> 
        

        <div class="col-md-1"> 
          <label>&nbsp;</label>
          <br>
          <button type="submit" class="btn btn-primary" id="datalist">Go</button>
        </div> 
      
      
    </div>

  <!-- End Search Option -->

  <!-- serch data table values -->
  <div class="row">
    <div class="col-md-12 " style="padding:15px" id="appenthtml">
            
    </div>
  </div>
  <!-- serch data 
    table values -->

 <div class="modal fade" id="Mymodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h4 class="modal-title">Update Qty</h4>                                                             
      </div> 
      <div class="modal-body">
         <input type="hidden" class="form-control" id="qty-id">
         <input type="hidden" class="form-control" id="group_id">
         <input type="hidden" class="form-control" id="accept_store_id">
         <input type="hidden" class="form-control" id="send_store_id">
         <input type="hidden" class="form-control" id="transition_date">
        
        <div class="form-group">
    <label for="email">Qty:</label>
    <input type="text" class="form-control" id="qty-list"  required>
  </div>
      </div>  
     
      <div class="modal-footer">
        <button type="submit" class="btn btn-default" id="upqty" >Submit</button>                               
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
  <!-- END content -->

@endsection
@section('script')

     <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
      <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/datejs/1.0/date.min.js"></script>
<script type="text/javascript">
  jQuery(document).on('change','.shift_manager',function(){  
    jQuery('.shift_name').empty();
    jQuery('.change_shift_manager').css('display','none');
  });

  jQuery(document).on('change','.shift_name ',function(){ 
    jQuery('.depend_changes').css('display','none');
  });
</script>

<script type="text/javascript">
  jQuery('.datetimepicker').datepicker({
      autoclose: true, 
      todayHighlight: true,
      endDate: new Date(),   
      format: 'dd/mm/yyyy'
  });


  function tranferhtmldatatable(){

                return '<table id="godownedit" class="display" style="width:95%;"><thead class="heading btn-primary"><tr><th>Transition Date</th><th>From Store</th><th>To Store</th><th>Item Name</th><th >Qty</th><th>Action</th></tr></thead><tbody id="godownlistning"></tbody></table>';

              }


              jQuery(document).on('click','#datalist',function(){
                var from=$("#from").val();
                var to=$("#to").val();
                if(from && to){
                $.ajax({
        type: "post",
        url: "{{route('viewamdalterstoretransfer',[$project->id ,base64_encode($store)])}}",
        data: { 
             
           
            from_date:from,
            to_date:to,
            "_token": "{{ csrf_token() }}"
            
          
        },
        success: function(result) {
          console.log(result);
          

          
          if(result.data.length > 0){
           var godown_items='';
          for(var i=0;i < result.data.length;i++){
           if(result.data[i].qty!=0){
             if(result.data[i].sumqty==null){



          var accept_store ='';
          var send_store ='';
           for(var j=0;j<result.store.length;j++){

          if(result.data[i].accept_store_id==result.store[j].id)
          {
            accept_store = result.store[j].store_name;
          }

          if(result.data[i].send_store_id==result.store[j].id)
          {
            send_store = result.store[j].store_name;
          }
        }
         

            godown_items+=' <tr id="'+result.data[i].id+'"><td>'+new Date(result.data[i].transition_date).toString('dd-MM-yyyy')+'</td><td>'+send_store+'</td><td>'+accept_store+'</td><td>'+result.data[i].material_name+'</td><td style="text-align: right;">'+Math.abs(result.data[i].qty)+'</td><td  style="text-align: center;"><div class="btn-group"><button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span>Action</button><ul class="dropdown-menu" role="menu"><li><a onclick="appenddata('+result.data[i].id+','+result.data[i].qty+','+result.data[i].group_id+','+result.data[i].accept_store_id+','+result.data[i].send_store_id+','+result.data[i].transition_date+');" >Edit</a></li><li><a id="'+result.data[i].id+'" data-group_id="'+result.data[i].group_id+'" data-itemqty="'+result.data[i].qty+'" class="class-btn-delete-list">Delete</a></li></ul></div></td></tr>';
          }else{
            godown_items+=' <tr id="'+result.data[i].id+'"><td>'+new Date(result.data[i].transition_date).toString('dd-MM-yyyy')+'</td><td>'+result.data[i].send_store_id+'</td><td>'+result.data[i].accept_store_id+'</td><td>'+result.data[i].material_name+'</td><td style="text-align: right;">'+result.data[i].qty+'</td><td  style="text-align: center;"><div class="btn-group"><button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span>Action</button><ul class="dropdown-menu" role="menu"></ul></div></td></tr>';

          }
          }
            

          }
           var html=tranferhtmldatatable();
            $("#appenthtml").html(html);
           $("#godownlistning").append(godown_items);
          $('#godownedit').DataTable(  );
       
        }else{
          var html=tranferhtmldatatable();
          $("#appenthtml").html(html);
           $('#godownedit').DataTable( );
          }
       

        },      
         error: function(result) {
            alert('error');
        }
      
    }); 
          }else{
            alert('Enter from and to date');
          }

              });

      function appenddata(id,qty,group_id,accept_store_id,send_store_id,transition_date){

            var qty = Math.abs(qty);
 

            $('#qty-id').val(id);
            $('#group_id').val(group_id);
            $('#accept_store_id').val(accept_store_id);
            $('#send_store_id').val(send_store_id);
            $('#transition_date').val(transition_date);
            



            var qtys=$('#godownlistning tr#'+id+' td:nth-child(5)').text();
            $('#qty-list').val(parseInt(qty));
            $(document).ready(function(){
            $('#Mymodal').modal('show')

      });

      
    }
    jQuery(document).on('click','.class-btn-delete-list',function(){
              var con=confirm("Are you sure you want to delete?");
             
              var id=$(this).attr('id');
               var group_id=$(this).data('group_id');
       
            

            
              if(con==true){
               
                $(this).closest("tr").remove();
                 $.ajax({
        type: "get",
        url: "{{route('storetostoreitemdel',[$project->id ,base64_encode($store)])}}",
        data: { 
             
             id:id,
            group_id:group_id
            
          
        },
        success: function(result) {
           if(result.success){
        $('#messagegodown').html('<span style="color:red">Delete Successfully</span>');
        $('#MymodalDelEdit').modal('show');
        
           
          console.log('reach at new row');
         
          var from=$("#from").val();
                var to=$("#to").val();
                if(from && to){
                $.ajax({
        type: "post",
        url: "{{route('viewamdalterstoretransfer',[$project->id ,base64_encode($store)])}}",
        data: { 
             
           
            from_date:from,
            to_date:to,
            "_token": "{{ csrf_token() }}"
            
          
        },
        success: function(result) {
          console.log(result);
          
          if(result.data.length > 0){
           var godown_items='';
          for(var i=0;i < result.data.length;i++){
           if(result.data[i].qty!=0){
             if(result.data[i].sumqty==null){
            godown_items+=' <tr id="'+result.data[i].id+'"><td>'+result.data[i].invoice_no+'</td><td>'+new Date(result.data[i].invoice_date).toString('dd-MM-yyyy')+'</td><td>'+new Date(result.data[i].inward_date).toString('dd-MM-yyyy')+'</td><td>'+result.data[i].material_name+'</td><td style="text-align: right;">'+result.data[i].qty+'</td><td  style="text-align: center;"><div class="btn-group"><button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span>Action</button><ul class="dropdown-menu" role="menu"><li><a onclick="appenddata('+result.data[i].id+','+result.data[i].qty+','+result.data[i].group_id+','+result.data[i].accept_store_id+','+result.data[i].send_store_id+','+result.data[i].transition_date+');" >Edit</a></li><li><a id="'+result.data[i].id+'" data-group_id="'+result.data[i].group_id+'" data-itemqty="'+result.data[i].qty+'" class="class-btn-delete-list">Delete</a></li></ul></div></td></tr>';
          }else{
            godown_items+=' <tr id="'+result.data[i].id+'"><td>'+result.data[i].invoice_no+'</td><td>'+new Date(result.data[i].invoice_date).toString('dd-MM-yyyy')+'</td><td>'+new Date(result.data[i].inward_date).toString('dd-MM-yyyy')+'</td><td>'+result.data[i].material_name+'</td><td style="text-align: right;">'+result.data[i].qty+'</td><td style="text-align: center;"><div class="btn-group"><button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span>Action</button><ul class="dropdown-menu" role="menu"></ul></div></td></tr>';

          }
          }
            

          }
           var html=tranferhtmldatatable();
            $("#appenthtml").html(html);
           $("#godownlistning").append(godown_items);
          $('#godownedit').DataTable(  );
       
        }else{
          var html=tranferhtmldatatable();
          $("#appenthtml").html(html);
           $('#godownedit').DataTable( );
          }
       

        },      
         error: function(result) {
            alert('error');
        }
      
    }); 
              }else{
                alert('Enter from and to date');
                }
           

        }},      
         error: function(result) {
            alert('error');
        }
      
    }); 

              }
              });


     $("#upqty").click(function(){
 

          var id=$('#qty-id').val();
          var group_id=$('#group_id').val(); 
          var qty=$('#qty-list').val();
          var accept_store_id = $('#accept_store_id').val();
          var send_store_id = $('#send_store_id').val();
          var transition_date = $('#transition_date').val();

          
               
                $.ajax({
                  type: "get",
                  url: "{{route('updatestoretostorealter',[$project->id ,base64_encode($store)])}}",
                  data: { 
                       
                     
                      id:id,
                      group_id:group_id,
                      accept_store_id:accept_store_id,
                      send_store_id:send_store_id,
                      qty:qty

                      
                    
                  },
                  success: function(result) {
                    if(result.success){
                     $('#godownlistning tr#'+result.success+' td:nth-child(5)').text(result.data);
              $('#messagegodown').html('<span style="color:red">Update Successfully</span>');
              $('#Mymodal').modal('hide')
              $('#MymodalDelEdit').modal('show');
              $('#appenthtml').empty();
              
                    }

                  else
                  {
                    ViewHelpers.notify("error","Not Enough Item Available");
                  }
                    
                  },      
                   error: function(result) {
                      alert('error');
                  }
                
              }); 
    });
 </script>

 
@endsection