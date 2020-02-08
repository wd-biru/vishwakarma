@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Vendor Registration</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('master.vendorReg')}}">Vendor Registration</a></li>
                <li><a href="#">Add</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
@include('includes.msg')
@include('includes.validation_messages')

{{--dd($vendor_reg)--}}
<div class="row">
    <div class="col-md-12">
        <div class="content-section">
            <a href="{{route('vendorCreate')}}"><button class="btn btn-primary "><i class="fa fa-user-plus" aria-hidden="true" title="New" ></i>&nbsp;&nbsp;Add </button></a><br><br>
            <div class="  table-responsive ">
                <table class="table table-bordered main-table search-table " >
                    <thead>
                        <tr class="t-head">
                            <th>Sr. No.</th>
                            <th>Name</th>
                            <th>Company Name</th>
                            <th>Email</th>
                            <th>Contact No.</th>
                            <th>Director Name</th>
                            <th>Director Number</th>
                            <th>Supplier</th>
                            <th>Address/State/City</th>
                            <th>Latitude/Longitude</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody><?php $i=1;?>
                        @foreach($vendor_reg as $list)

                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$list->name}}</td>
                            <td>{{$list->company_name}}</td>
                            <td>{{$list->email}}</td>
                            <td>{{$list->mobile}}</td>
                            <td>{{$list->director_name}}</td>
                            <td>{{$list->director_number}}</td>
                            
                            <td>
                            <?php 
                                $vendor_material_ids =  explode(',', $list->supplier_of);                                 
                                $vendor = $list->getMaterial($vendor_material_ids); 
                            ?>
                            @foreach($vendor as $material_list)       
                                    {{$material_list->group_name}}@if(!$loop->last),@endif
                            @endforeach 
                            </td> 
                            <td>{{$list->address}},{{$list->getState->name}},{{$list->getCity->name}}</td> 
                            <td>{{$list->latitude}},{{$list->longitude}}</td>
                            <td>
                                @if($list->is_active==1)
                                    <img src="{{ my_asset('images/activate.png') }}">
                                @else
                                    <img class="change_status" src="{{my_asset('images/deactivate.png')}}">
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if(Auth::user()->user_type == 'admin')
                                        <li><a href="{{route('vendorEdit',[$list->id])}}"><i class="fa fa-edit" aria-hidden="   true"></i>&nbsp; Edit</a>
                                        </li>
                                        <li><a href="#"  data-toggle="modal" data-target="#modalVendorPortal_{{$list->id}}"><i class="fa fa-map-signs" aria-hidden="   true"></i>&nbsp; Portal Mapping</a>
                                        </li>
                                        <li><a href="{{route('viewPrice')}}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp; View Price</a>
                                        </li>
                                        @else
                                         <li><a href="{{route('viewPrice')}}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp; View Price</a>
                                        </li>
                                        @endif
                                 
                                    </ul>   
                                </div> 
                                <!-- Material for Vedor Portal Mapping -->
                                    <div class="modal fade" id="modalVendorPortal_{{$list->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal" aria-label="Close">
                                               &times;
                                            </button>
                                            <h5 class="modal-title" id="exampleModalLongTitle">Portal List</h5>
                                          </div>
                                          <div class="modal-body">
                                            <form class="form-horizontal" action="{{route('vendorportalStore')}}" method="post">
                                                  <div class="modal-body">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="vendor_id" id="vendor_id" value="{{$list->id}}">

                                                    <div class="table-responsive">
                                                          <table id="example" class="table table-striped table-bordered dataTable no-footer example" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;" >
                                                              <thead>
                                                                  <tr>
                                                                    <th>Company Name</th>
                                                                  </tr>
                                                            </thead>
                                                            <tbody>
 
                                                                @foreach($portal_list as $value)
                                                                   <tr>
                                                                        <td>
                                                                    <input type="checkbox" name="company_name[]"
                                                                             @if($list->getPortalMap != null)
                                                                            @foreach($list->getPortalMap as $vendor_list)
                                                                                @if($vendor_list->portal_id == $value->id )
                                                                                    checked   
                                                                                @endif
                                                                            @endforeach
                                                                            @endif
                                                                                value="{{$value->id}}">
                                                                                <label>{{$value->company_name}}</label>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                      <div class="form-group">
                                                        <div class="col-sm-offset-3 col-sm-9">
                                                            <button type="submit" class="btn btn-primary pull-right">Submit </button>
                                                        </div>
                                                    </div>
                                                  </div>              
                                                </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <!--End  Material for Vedor Portal Mapping -->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>

        </div>
    </div>
</div>



@endsection
@section('script')
<script>
$(document).ready(function(){
    $(".vendor_mapping").on("click", function(){
        $('#vendor_id').val("");  
        var vendor_id = $(this).data("vendor_id");
        $('#vendor_id').val(vendor_id);
        
    });
});



</script>

@endsection


