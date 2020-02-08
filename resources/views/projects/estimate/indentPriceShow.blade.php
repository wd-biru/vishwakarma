@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Indent:<b>{{$indent_id}}</b> Price</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="#">Indent Price</a></li>
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

                <h3 class="panel-title">&nbsp;Indent</h3>
               
            </div>
            <div class="panel-body">
                    <div class="col-md-12">

                      <div class="table-responsive" style="width:100%">
                                <table id="data-table" class="table table-striped table-hover table-condensed table-bordered">
                                    @if(count($indent)> 0)
                                        <thead>
                                            <tr class="tab-text-align t-head">
                                             <th>Sr.</th>
                                             <th>Checked</th>
                                             <th>Name of Item</th>
                                             <th>Quantity</th>
                                             <th>Material Unit</th>
                                             @foreach($vendor_indent_mapping  as  $vendor_list)
                                             <th>{{ucfirst($vendor_list->company_name)}}</th>
                                             @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; ?> 
                                            @foreach($indent as $list) 
  
                                                <tr class="tab-text-align">
                                                  <td>{{$i++}}</td>
                                                 <td><input type="checkbox" @if(!empty($chkPurchaseOrder)) @foreach($chkPurchaseOrder as $val) @if($val->item_id==$list->item_id) checked disabled @endif   @endforeach  @endif type="checkbox" name="item_id"  data-project_id="{{$list->project_id}}"
                                                    data-qty="{{$list->qty}}"  data-indent_id="{{$list->indent_id}}"
                                                    data-store_id="{{$list->store_id}}" data-material_name="{{$list->material_name}}"  data-unit="{{$list->unit}}"  value="{{$list->item_id}}" class="item_id"></td> 
                                                    <td>{{$list->material_name}}</td>
                                                    <td>{{$list->qty}}</td>
                                                    <td>{{$list->unit}}</td>

                                                    @foreach($vendor_indent_mapping  as  $vendor_price)
                                                    <?php   
                                                    $priceVendor = $list->getPriceAginstEachVendor($vendor_price->id,$list->indent_id,$list->item_id); 
 
                                      
                                                    $price = ($priceVendor==false) ? "" :  $priceVendor->price;  
                                                    $lowest = ($priceVendor==false) ? "" :  $priceVendor->lowest;  
                                                    $LowColor = ($priceVendor==false) ? "fff" :  $priceVendor->LowColor;  
                                                    $remarks = ($priceVendor==false || isset($priceVendor->remarks)==null) ? "" :  "(".$priceVendor->remarks.")"; 


                                            
                                                    ?>

                                                  <td>{{$price}}<b style="color:{{$LowColor}}">{{$lowest}}</b> {{$remarks}} </td>
                                             @endforeach
                                                     
                                                 </tr>
                                            @endforeach
                                        </tbody>
                                    @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


 <?php $idm=DB::table('vishwa_purchase_order')->orderByDesc('id')->pluck('id')->first();
  if(!$idm)
  {
      $indentIncrement=0;
    
  }
  else
  {
      $indentIncrement=intval($idm);
  }
  $purchase_order_number= str_pad($indentIncrement+1, 7, '0', STR_PAD_LEFT);?>

  <div class="row purchase_order">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">&nbsp;Purchase Order No :ORD/{{$purchase_order_number}}/{{ now()->year }}</h3>
            </div>
            <div class="panel-body">
                    <div class="col-md-12">

                    {!! Form::model($project, ['route' => ['storePurchase', $project->id], 'method' => 'post' ]) !!}
                          {{csrf_field()}}
                          <input type="hidden" class="form-control" value="ORD/{{$purchase_order_number}}/{{ now()->year }}"  name="purchase_order_no" id="purchase_order_no">
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
                        <div class="form-group">
                          <label class="control-label col-md-4">Vendor&nbsp;<span style="color: #f70b0b">*</span></label>
                          <div class="col-sm-12">
                            <select class="form-control" required="" name="vendor_id" style="margin-bottom:15px;">
                              @if(isset($vendor_indent_mapping))
                                  <option value="">--Select Vendor--</option>
                                  @foreach ($vendor_indent_mapping as $vendor_list)
                                  <option value='{{$vendor_list->id}}'>{{ucfirst($vendor_list->company_name)}}</option>
                                  @endforeach
                                @endif
                            </select>
                          </div>
                        </div>
                        <div class="form-group" >
                            <label class="control-label col-md-4">PO Date&nbsp;<span style="color: #f70b0b">*</span></label>
                              <div class="col-md-12">
                                  <fieldset>
                                    <input type="text" class="form-control datepicker"  name="date" id="date" autocomplete="off" required>
                                  </fieldset>
                              </div>

                        </div>

                        <br>
                        <div class="form-group" >
                          <label class="control-label col-md-4">Voucher No&nbsp;<span style="color: #f70b0b">*</span></label>
                            <div class="col-md-12">
                
                              <input type="number" class="form-control"  name="voucher_no" id="voucher_no" required>
                            </div>
                        </div>


                        <div class="col-md-4">

                            <button type="submit"  class="btn btn-primary" style="margin-top: 15px;">Submit</button>
                        </div>
                      </div>
                      

                    {!! Form::close() !!}
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
              var project_id    =jQuery(this).data('project_id');
              var qty           =jQuery(this).data('qty');
              var material_name =jQuery(this).data('material_name');
              var store_id      =jQuery(this).data('store_id');
              var unit          =jQuery(this).data('unit');
              $(".purchase_order").show();
              var tr = "<tr id='" + this.value + "'><td>"+material_name+"</td> <td><input type='number' class='form-control' name='qty[]' min='1' value="+qty+"></td><td>"+unit+"<input type='hidden'  name='indent_id' value="+indent_id+"><input type='hidden'  name='project_id' value="+project_id+"><input type='hidden'  name='item_id[]' value="+item_id+"></td><td><input type='hidden'  name='store_id' value="+store_id+"><input type='hidden'  name='unit[]' value="+unit+" ></td>"+ this.value +"</tr>";
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

</script>

@endsection























