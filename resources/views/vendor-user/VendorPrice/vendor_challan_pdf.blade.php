@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Challan Number</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="#"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="#">Challan</a></li>
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
                        <form  action="{{route('getChallanData')}}" method="post">
                             {{ csrf_field() }}
                             <div class="row">
                                <div class="col-md-2">
                                <label>From Date</label>
                                <input type="text" class="datetimepicker form-control" name="from_date" required autocomplete="off">
                              </div> 
                              <div class="col-md-2">
                                <label>To Date</label>
                                <input type="text" class="datetimepicker form-control" name="to_date" required autocomplete="off">
                              </div>

                           {{--<div class="col-md-4">
                                <label>Projects</label>
                                <select class="form-control selectable" name="project">
                                   <option  value="0">Please Select</option>
                                    @foreach($projects as $list)
                                   <option  value="{{$list->id}}">{{$list->name}}</option>
                                    @endforeach
                              </select>
                                
                              </div>--}}   

                              <div class="col-md-1"> 
                                <label>&nbsp;</label>
                                <br>
                                <button type="submit" class="btn btn-primary">Go</button>
                              </div>
                             </div>
                    </form>
             </div>
        </div>


</div>



@if($purchaseData!=null)

 <div class="row">
  <div  class="col-md-12">
    <div style="margin-top: 10px;background: #fff;padding: 15px;">
      <table class="table display" >
      <thead>
        <tr>
                <th>Sr. No</th>
                <th>Vendor</th>
                <th>Purchase Order No</th>
                <th>Challan Number</th>
                <th>Action</th>
        </tr>
      
      </thead>
          <tbody><?php $i=1;?>
                @foreach($purchaseData as $result)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$result->company_name}}</td>
                        <td>{{$result->purchase_order_no}}</td>
                        <td><form action="{{route('ChallanItemGet') }}"  method="post">
                            {{csrf_field()}} 
                            <input type="hidden" name="purchase_order_no" value="{{$result->purchase_order_no}}">
                            <input type="hidden" name="indent_no" value="{{$result->indent_id}}">
                            <input type="hidden" name="portal_id" value="{{$result->portal_id}}">
                            <input type="hidden" name="challan_no" value="{{$result->challan_no}}">
                            <button type="submit" class="btn btn-link">{{$result->challan_no}}</button>
                          </form></td>
                        <td>
                          <form action="{{route('ChallanViewAndDownloadPDF')}}"  method="post">
                              {{csrf_field()}} 
                             <input type="hidden" name="purchase_order_no" value="{{$result->purchase_order_no}}">
                             <input type="hidden" name="portal_id" value="{{$result->portal_id}}">
                             <input type="hidden" name="indent_no" value="{{$result->indent_id}}">
                             <input type="hidden" name="challan_no" value="{{$result->challan_no}}">
                             <button type="submit" class="btn btn-primary">Download Challan</button>
                           </form>

                        </td>
                    </tr>
              @endforeach
             
          </tbody>
    </table>


               </div>
        </div>
</div>  
 
@endif  




 

@endsection
@section('script')
 

<script>

    jQuery('.datetimepicker').datepicker({
      autoclose: true, 
      todayHighlight: true,
      endDate: new Date(),   
      format: 'dd/mm/yyyy'
  });

  $('.display').DataTable({});

  // $(document).ready(function(){

  //   $('#date').attr('autocomplete','off');
  //   $('#date').val('');
  //   });


     jQuery(".DisableBackDatepicker").datepicker({
        format: 'dd/mm/yyyy',
        startDate:"today",
        autoclose: true,
        todayHighlight: true,
        minDate:0,
        // endDate: "today",
    });

</script>

@endsection


