@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Challan</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="#">Vendor Challan</a></li>
                <li><a href="#">Add</a></li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
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
</style>


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">&nbsp;Challan Number</h3>
            </div>
            <div class="panel-body">
                <div class="card col-md-12">
                    <form action="#" method="POST" id="form">
                       {{ csrf_field() }}
                            <div class="  table-responsive ">
                             <table class="table table-bordered main-table" >
                                    <thead>
                                 
                                        <tr class="t-head"> 
                                            <th>Checked</th> 
                                            <th>Material Name.</th>
                                            <th>Unit.</th>
                                            <th>Quantity.</th>
                                            <th>Remaining Quantity.</th>

                                        </tr>
                                    </thead>
                                    <tbody>  


                                        @foreach($getChallan as $list)
                                        <tr>
                                          
                                        <?php 
                                          $material_name = App\Models\MaterialItem::where('id',$list->item_id)->first();
                                          $order = $list->checkQty($list->vendor_id,$list->purchase_order_no,$list->item_id,$list->qty)['orderQty'];
                                          $remain =  $list->checkQty($list->vendor_id,$list->purchase_order_no,$list->item_id,$list->qty)['remainQty'] ;
                                        ?>
                                            <td><input type="checkbox" @foreach($chkChallanNumber as $val) @if($val->item_id==$list->item_id && $remain == 0) checked disabled @endif   @endforeach type="checkbox" name="item_id"  data-project_id="{{$list->project_id}}"
                                            data-store_id="{{$list->store_id}}" 
                                            data-qty="{{$remain}}"  data-purchase_no="{{$list->purchase_order_no}}" data-portal_id="{{$list->portal_id}}" data-indent_id="{{$list->indent_id}}" data-material_name="{{$material_name->material_name}}"  data-unit="{{$list->unit}}"  value="{{$list->item_id}}" class="item_id"></td>
                                            <td>{{$material_name->material_name}}</td>
                                            <td>{{$list->unit}}</td>

                                            <td>
                                             {{$order}}
                                                </td>  
                                            <td id="remain_{{$list->item_id}}">
                                               {{$remain}}
                                            </td>   
                                        </tr>
                                        @endforeach
                                    </tbody>
                                   
                                </table>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row purchase_order">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">&nbsp;Challan Number:</h3>
            </div>
            <div class="panel-body">
                    <div class="col-md-12">

                    <form action="{{route('ChallanOrderNumber')}}"  method="get">
                        {{csrf_field()}} 
                        <div class="col-md-6">
                          <div class="table-responsive" style="width:100%">
                                  <table id="data-table" class="table table-striped table-hover table-condensed ">
                    
                                          <thead>
                                              <tr class="tab-text-align t-head">
                                                
                                               <th>Material Name.</th>
                                               <th>Quantity.</th>
                                               <th>Unit.</th>
                                              </tr>
                                          </thead>
                                          <tbody id="id-bind-data">

                                              

                                          </tbody>

                                  </table>
                           </div>
                        </div>
                      <div class="col-md-6">
                        <div class="form-group" >
                        <label class="control-label col-md-4">Challan Date&nbsp;<span style="color: #f70b0b">*</span></label>
                          <div class="col-md-12">
                              <fieldset>
                                  <input type="text" class="form-control datepicker" placeholder="Date" autocomplete="off"  name="date" id="date" required>
                              </fieldset>
                          </div>

                        </div>
                        <div class="form-group" >
                        <label class="control-label col-md-4">Challan No:&nbsp;<span style="color: #f70b0b">*</span></label>
                          <div class="col-md-12">
                              <input type="number" class="form-control" placeholder="Challan Number" autocomplete="off"  name="challan_no" id="challan_no" required>
                          </div>
                        </div>

                        <br>
                        <div class="form-group" >
                        <label class="control-label col-md-4">Truck No:&nbsp;<span style="color: #f70b0b">*</span></label>
                          <div class="col-md-12">
                              <input type="text" class="form-control" placeholder="Truck No" autocomplete="off"  name="tracker_no" id="tracker_no" required>
                          </div>
                        </div>

                        <div class="form-group" >
                        <label class="control-label col-md-4">Driver Name:&nbsp;<span style="color: #f70b0b">*</span></label>
                          <div class="col-md-12">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Driver Name"  name="driver_name" id="driver_name" required>
                          </div>
                        </div>

                        <div class="form-group" >
                        <label class="control-label col-md-4">Driver Mobile Number:&nbsp;<span style="color: #f70b0b">*</span></label>
                          <div class="col-md-12">
                              <input type="number" class="form-control" pattern="[7-9]{1}[0-9]{9}" placeholder="Phone number with 7-9 and remaing 9 digit with 0-9"  name="dmobile_no" id="mobile_no" required>
                          </div>
                        </div>


            <div class="col-md-4">

      <button type="submit"  class="btn btn-primary" name="action" value="save" style="margin-top: 15px;">Submit</button>
   
                     
            </div>
                      </div>
                      

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
@section('script')
<script>

    $(document).ready(function(){
       $(".purchase_order").hide();
       $('input[name="item_id"]').click(function(){ 
             if (this.checked) {
              var item_id       =jQuery(this).val();
              var indent_id     =jQuery(this).data('indent_id');
              var purchase_no   =jQuery(this).data('purchase_no');
              var portal_id     =jQuery(this).data('portal_id');
              var project_id    =jQuery(this).data('project_id');
              var qty           =jQuery(this).data('qty');
              var rem_qty        =jQuery(this).data('rem_qty');
              var material_name =jQuery(this).data('material_name');
              var store_id      =jQuery(this).data('store_id');
              var unit          =jQuery(this).data('unit');



              $(".purchase_order").show();
              var tr = "<tr id='" + this.value + "'><td>"+material_name+"</td> <td><input type='number' min='1' max="+qty+" class='form-control quantity' id='quantity' name='qty[]' data-id="+this.value+" value="+qty+"></td><td>"+unit+" <input type='hidden'  name='indent_id' value="+indent_id+"> <input type='hidden'  name='project_id' value="+project_id+"> <input type='hidden'  name='item_id[]' value="+item_id+"><input type='hidden'  name='purchase_order_no' value="+purchase_no+"><input type='hidden'  name='portal_id' value="+portal_id+"><input type='hidden'  name='store_id' value="+store_id+"> <input type='hidden'  name='unit[]' value="+unit+" ><input type='hidden' id='previousQty_"+this.value+"' value="+qty+" ></td>"+ this.value +"</tr>";
                jQuery('#id-bind-data').append(tr);
 

              }
              else{
              $("#" + this.value).remove();
             
              }
               
        });  

              jQuery(".datepicker").datepicker({
                  autoclose: true,
                  todayHighlight: true,
                  format: 'dd/mm/yyyy'
              });

    });
    $(document).on("keyup",".quantity",function(){
      var id = jQuery(this).data('id');
      var previous = jQuery("#previousQty_"+id).val(); 
      var current = jQuery(this).val();
      var remain_value = parseInt(previous)-parseInt(current);
      jQuery("#remain_"+id).html(remain_value);
      if(parseInt(previous)<parseInt(current)){
        alert("Maximum Quantity Value Is :"+previous);
        jQuery(this).val(previous);
        return false;
      }
      if(parseInt(current)<=0){
        alert("Quantity Value Should be Greather than 0");
         jQuery(this).val(previous);
         jQuery("#remain_"+id).html(0);
        return false;
      }
    })

</script>

@endsection

























