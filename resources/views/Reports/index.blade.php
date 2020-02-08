@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Reports</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href=""><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('Reports.index')}}">Reports</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
@include('includes.msg')
@include('includes.validation_messages')
 
 
    <div class="row content-section">           
                            
                    <div  class="col-md-12">
                    <form  action="{{route('Reports.getReport')}}" method="post">
                         {{ csrf_field() }}
                         <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Project</label>&nbsp;&nbsp;
                             <select class="form-control selectable" name="project" id="project">
                                   <option  value="0">Please Select</option>
                                       @foreach($projects as $list)
                             <option  value="{{$list->id}}">{{$list->name}}</option>
                                       @endforeach
                              </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label" >Store</label>
                           <select class="form-control" name="store" id="stores">
                             <option  value="">Please Select</option>
                                       
                              </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label">Material Group</label>&nbsp;&nbsp;
                           <select class="form-control selectable" name="material_group" >
                                       @foreach($MaterialsGroup as $data)
                             <option  value="{{$data->id}}">{{$data->group_name}}</option>
                                       @endforeach
                                      
                              </select>
                        </div>
                    </div>
                       <div class="col-md-3">
                        <div class="form-group">
                                <input type="submit" class="btn btn-primary" id="submit" style="margin-top: 20px;" value="Submit">
                        </div>
                        </div>
                        </form>
                </div>
                 
             


@if($reportdata!=null)



  <div  class="col-md-12">
    <table class="table" id="item_list">
      <thead>
        <tr>
                <th>Sr. No</th>
                <th>Item Name</th>
                <th>Qty</th>
        </tr>
      </thead>
      <tbody><?php $i=1;?>
            @foreach($reportdata as $result)
                <tr>
                     <td>{{$i++}}</td>
                    <td><a  class="transaction_history" data-project="{{$result->project_id}}" data-store="{{$result->store_id}}" data-item="{{$result->item_id}}" data-portal="{{$result->portal_id}}">{{$result->material_name}}</a></td>

                    <?php     


                    $sum = DB::table('vishwa_store_inventory_qty')
                  ->where('vishwa_store_inventory_qty.project_id',$result->project_id)
                  ->where('vishwa_store_inventory_qty.store_id',$result->store_id)
                  ->where('vishwa_store_inventory_qty.item_id',$result->item_id)  
                  ->where('vishwa_store_inventory_qty.portal_id',$result->portal_id)    
                  ->select(DB::raw("SUM(vishwa_store_inventory_qty.qty) as availableQty"))
                  ->first();
                    

                ?>
                    <td>{{$sum->availableQty}}</td>
                </tr>
          @endforeach
         
      </tbody>
    </table>
</div>
</div>
@endif     




<div id="transaction_model" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Transaction History</h4>
      </div>
      <div class="modal-body">

        <div class="table-responsive" id="appenthtml">
            
        </div>
    
 
            
     
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
 

 

@endsection
@section('script')
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

<script>

    //***********************************************for getting Store*********************************//


      jQuery(document).on('change','#project ',function(){ 
                var project_id = $(this).val();

                      $.ajax({
                        type: "get",
                        url: "{{route('Reports.getStore')}}",
                        data: { 
                            project_id:project_id,
                            "_token": "{{ csrf_token() }}"
                            
                          
                        },
                            success: function(data) {
                                console.log(data);
                                    var opt='';
                                    jQuery.each(data, function(index,value)
                                    {     
                                    opt+='<option value="'+value.id+'">'+value.store_name+'</option>';
                                    });

                                    jQuery('#stores').html(opt);
                              
                                
                           

                            },      
                             error: function(result) {
                                alert('Error in getting Store Details');
                            }
                          
                   }); 
    
     });


        //***********************************************End getting Store*********************************//



        //***********************************************Validation *********************************//


        jQuery(document).on('click','#submit',function(){
            var check_value = jQuery('#project').val();
            if(check_value == "0")
                {
                    alert('Please Select Projects');
                    return false;
                }
            
       
         });


        //***********************************************Validation *********************************//


            function tranferhtmldatatable()
            {

                return '<table id="godownedit" class="table table-striped table-hover responsive display"><thead class="heading"><tr><th>Transaction</th><th>Transaction Date</th><th>From Store</th><th>To Store</th><th>Qty</tr></thead><tbody id="godownlistning"></tbody></table>';

              }
     




 jQuery(document).on('click','.transaction_history',function(){
            var store = $(this).data('store');
            var item = $(this).data('item');
            var portal = $(this).data('portal');
            var project = $(this).data('project');
              $.ajax({
                        type: "post",
                        url: "{{route('Reports.getitemtransaction')}}",
                        data: { 
                            store:store,
                            item:item,
                            portal:portal,
                            project:project,
                            "_token": "{{ csrf_token() }}"
                            
                          
                        },
                            success: function(result) {
                                console.log(result);

                              
                       var godown_items=''; 
                        for(var i=0;i <result.data.length;i++)
                         {
                            if(result.data[i].initial_state==1)
                            {
            var date = result.data[i].created_at.split(' ')[0];
            var dateAr = date.split('-');
            var newDate = dateAr[2] + '/' + dateAr[1] + '/' + dateAr[0].slice(-2);
godown_items+=' <tr><td>Initial Stock</td><td>'+newDate+'</td><td></td><td></td><td>'+result.data[i].qty+'</td></tr>';
                            }
                            if(result.data[i].invoice_no!=null && result.data[i].invoice_date!=null)
                            {

            var dateAr = result.data[i].inward_date.split('-');
            var newDate = dateAr[2] + '/' + dateAr[1] + '/' + dateAr[0].slice(-2);
                                
godown_items+=' <tr><td>Inward Stock</td><td>'+newDate+'</td><td></td><td></td><td>'+result.data[i].qty+'</td></tr>';
                            }
                    if(result.data[i].transition_date!=null && result.data[i].accept_store_id==null && result.data[i].send_store_id==null)
                            {

            var dateAr = result.data[i].transition_date.split('-');
            var newDate = dateAr[2] + '/' + dateAr[1] + '/' + dateAr[0].slice(-2);
            godown_items+=' <tr><td>Outward Stock</td><td>'+newDate+'</td><td></td><td><td>'+result.data[i].qty+'</td></tr>';
                            }
                            if(result.data[i].accept_store_id!=null && result.data[i].send_store_id!=null)
                            {
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


            var dateAr = result.data[i].transition_date.split('-');
            var newDate = dateAr[2] + '/' + dateAr[1] + '/' + dateAr[0].slice(-2);
                             godown_items+=' <tr><td>Store Transfer</td><td>'+newDate+'</td><td>'+send_store+'</td><td>'+accept_store+'</td><td>'+result.data[i].qty+'</td></tr>';
                            }


                         }

                         var html=tranferhtmldatatable();
                        $("#appenthtml").html(html);
                        $("#godownlistning").append(godown_items);
                        $('#transaction_model').modal('show');


                            },      
                             error: function(result) {
                                alert('Error in getting Item transaction history');
                            }
                          
                   }); 
             
            
       
         });


 

     $('#item_list').DataTable({
             dom: 'Bfrtip',
    buttons: [
            {
                text: 'Export to Excel',
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
        ],


     });

          $('.display').DataTable({

       


          });


 

</script>

@endsection


