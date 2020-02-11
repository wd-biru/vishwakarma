@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Material Receipt View</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href=""><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="">Material Receipt</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
@if(Session::has('error_message'))
<p class="alert alert-danger"  style="font-size: 16px;">{{ Session::get('error_message') }}</p>
@endif
@if(Session::has('success_message'))
<p class="alert alert-success" id="msg"  style="font-size: 16px;">{{ Session::get('success_message') }}</p>
@endif
@if(Session::has('message'))
<p class="alert alert-info" style="font-size: 16px;">{{ Session::get('message') }}</p>
@endif
@include('includes.validation_messages')
 
 <div class="row">
      <div  class="col-md-12">
        <div class="content-section">              
                        <form  action="{{route('MaterialRecipt.MaterialRecieptData')}}" method="get">
                             {{ csrf_field() }}
                              <div class="row">
                                <div class="col-md-2">
                                <label>From Date</label>

                                    <input  class="datepicker" autocomplete="off" name="from_date" id="to_from_date" placeholder="From Date" value="" style="
    font-size: 14px;" required>



                              </div>
                              <div class="col-md-2">
                                <label>To Date</label>
                                  <input  class="datepicker" autocomplete="off" name="to_date" id="to_to_date" placeholder="To Date" value="" style="
    font-size: 14px;">
                              </div>
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


@if($MaterialReciptData!=null)
 <div class="row">
  <div  class="col-md-12">
     <div style="margin-top: 10px;background: #fff;padding: 15px;height: auto">
                  <table class="table table-bordered table-hover datatable">
                  <thead>
                  <tr>
                      <th>Material Reciept Number</th>
                      <th>Material Reciept Date</th>
                      <th>Purchase Order Number</th>
                      <th>Challan Number</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                      
                      @foreach($MaterialReciptData as $value)
                      <tr>
                      <td>{{$value->mr_no}}</td>  
                      <td>{{date("d/m/Y", strtotime($value->material_reciept_date))}}</td>
                      <td>{{$value->po_no}}</td>
                      <td><form action="{{route('MaterialRecipt.getMaterialRecieptItem') }}"  method="post">
                            {{csrf_field()}} 
                           <input type="hidden" name="project_id" value="{{$value->project_id}}">
                           <input type="hidden" name="challan_no" value="{{$value->challan_no}}">
                           <input type="hidden" name="po_no" value="{{$value->po_no}}">
                           <input type="hidden" name="portal_id" value="{{$value->portal_id}}">  
                           <button type="submit" class="btn btn-link">{{$value->challan_no}}</button>
                      </form></td>
                      <td>
                           <form action="{{route('MaterialRecipt.DownloadMaterialReciept')}}"  method="post">
                                         {{csrf_field()}} 
                              <input type="hidden" class="form-control" name="pdf" value="{{$value->pdf_file_name}}">
                             <button type="submit" class="btn btn-primary" style="width: 170px">View Material Reciept</button>
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

    $('#to_from_date').datepicker({
        format:"dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true,
    });
    //
    $('#to_to_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
    });

 $('.datatable').DataTable({});

 

</script>

@endsection


