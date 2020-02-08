@extends('layout.app')
@section('title')
<div class="page-title">
  <div>
    <h1><i class="fa fa-building"></i>&nbsp;Service Group Master Data</h1>
  </div>
  <div>
    <ul class="breadcrumb">
      <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
      <li><a href="">Service Group Master Data List</a></li>
    </ul>
  </div>
</div>
@endsection
@section('content')
@include('includes.msg')
@include('includes.validation_messages')


<div class="col-md-5">
  <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">&nbsp;Master Of Service group</h3>
        </div>
        <div class="panel-body">
    <form class="form-horizantol">
      <div class="form-group">
        <div class="col-md-12">
          <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModalGroup">
            <i class="fa fa-plus"></i>&nbsp;Service Group
          </button>
        </div>
      </div>
      <div class="clearfix"></div>
    </form><br>

    <div class="card col-md-12">
      <table   class="table table-bordered  table-responsive search-table">
        <thead>
          <tr class="t-head">
            <th>Master of Service Group</th>
              <th>Item Count</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="storeGroup">
          @if(count($serviceGroup)>0)
          @foreach($serviceGroup as $serviceGroup)
                    <tr>
                        <td class="table-text link-color" >
                          <a href="{{ route('GetServiceItem', ['id' => $serviceGroup->id]) }}" class="link-color">{{$serviceGroup->servicename}}</a>
                         </td>

                          <td>{{count($serviceType=$serviceGroup::find($serviceGroup->id)->getServiceType)}}</td>
                        <td>
                            @if($serviceGroup->is_active==1)
                            <form action="{{route('isActiveGroup',['id' => $serviceGroup->id])}}" method="get">
                                <input type="hidden" name="is_active" value="0">
                                <button style="background: white;border:none;outline: none; width: 45px;"  type="submit"><img src="{{ my_asset('images/activate.png') }}"></button >
                            </form>

                            @else
                                <form action="{{route('isActiveGroup',['id' => $serviceGroup->id])}}" method="get">
                                <input type="hidden" name="is_active" value="1">
                                <button  type="submit" style="background: white;border:none;outline: none; width: 45px;"><img src="{{ my_asset('images/deactivate.png') }}"></button>
                            </form>
                            @endif
                        </td>
                        <td>
                          <span>
                          <a class="editgroup" data-id="{{$serviceGroup->id}}" data-name="{{$serviceGroup->servicename}}"><i class="fa fa-edit"></I></a>
                          </span>
                          <span style="margin-right: 3px; margin-left: 3px"> | </span>
                          <span>
                          <a href="{{ route('SrvcMgm.destroy', ['id' => $serviceGroup->id]) }}" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash"></i></a>
                          </span>

                        </td>

                    </tr>
                @endforeach

                @endif
        </tbody>
      </table>
    </div>

  </div>
</div>
</div>

<!-- Service management Of Client BLOCK -->
@if(isset($filterServiceData)>0)
  <div class="col-md-7">

      <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">&nbsp;@if(isset($groupdata) && $groupdata){{$groupdata->servicename}} @else Material @endif</h3>
            </div>
      <div class="panel-body">
        <form class="form-horizantol">
          <div class="form-group">
            <div class="col-md-12">
              <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModalService">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Service Type
              </button>
            </div>
          </div>
          <div class="clearfix"></div>
        </form><br>

        <div class="card col-md-12">
          <table class="table table-bordered  table-responsive search-table"   >
            <thead>
              <tr class="t-head">
                <th>Sr. No.</th>
                <th>Service Type</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody >
              <?php $i=1; ?>
              @foreach($filterServiceData as $item)
               <tr>
                <td>{{$i++}}</td>
                <td>{{$item->servicetype}}</td>
                <td>
                    @if($item->is_active==1)
                    <form action="{{route('isActiveService',['id' => $item->id])}}" method="get">
                        <input type="hidden" name="is_active_item" value="0">
                        <button style="background: white;border:none;outline: none; width: 45px;"  type="submit"><img src="{{ my_asset('images/activate.png') }}"></button >
                    </form>

                    @else
                        <form action="{{route('isActiveService',['id' => $item->id])}}" method="get">
                        <input type="hidden" name="is_active_item" value="1">
                        <button  type="submit" style="background: white;border:none;outline: none; width: 45px;"><img src="{{ my_asset('images/deactivate.png') }}"></button>
                    </form>
                    @endif
                </td>

                <td>
                  <span>
                  <a class="edit_group_item" data-item_id="{{$item->id}}" data-service-name="{{$item->servicetype}}" ><i class="fa fa-edit"></I></a>
                  </span>
                  <span style="margin-right: 3px; margin-left: 3px"> | </span>
                  <span>
                  <a href="{{ route('deleteService', ['id' => $item->id]) }}" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash"></I></a>
                  </span>
                </td>
               @endforeach
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>

<!-- check here -->
  <!-- Material for Group -->

  <div class="modal fade" id="exampleModalService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal" aria-label="Close">
             &times;
          </button>
          <h5 class="modal-title" id="exampleModalLongTitle">Add Service for Group :
            <b> @if(isset($groupdata) && $groupdata){{$groupdata->servicename}} @endif </b>
          </h5>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" action="{{route('addServiceItem',$groupdata->id)}}" method="post">
            <div class="modal-body">
              {{csrf_field()}}
              <input type="hidden" id="master_id" class="form-control check_value_ea check_name_ea" name="id" value="{{$groupdata->id}}"><br>
               <div class="form-group">
                <label class="control-label col-sm-3" for="pwd">Service Type<span style="color:red"> *</span></label>
                <div class="col-sm-8">
                  <input type="text"  class="form-control check_value_ea check_name_ea" name="servicetype" placeholder="Service Type" value="" required/><br>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3" for="pwd">Is Active<span style="color:red"> *</span></label>
                <div class="col-sm-8">
                  <select class="form-control" required="" id="is_active" class="form-control check_value_ea check_name_ea" name="is_active">
                        <option value="">Select Service Status</option>
                        <option value="1">Active</option>
                        <option value="0">Not Active</option>
                  </select>
                  <br>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Submit</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- END Material for Group MODAL -->

  <!-- Service for Group Item Update-->
  <div class="modal fade" id="exampleModalServiceItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal" aria-label="Close">
             &times;
          </button>
          <h5 class="modal-title" id="exampleModalLongTitle">Update Service For Group :
            <b> @if(isset($groupdata) && $groupdata){{$groupdata->servicename}} @endif </b>
          </h5>
        </div>
        <div class="modal-body">
            {!!Form::open(['route'=>'updateServiceGroupItem','method'=>'post','class'=>'form-horizontal'])!!}

            <div class="modal-body">
              {{csrf_field()}}
                 <input type="hidden" id="updated_service_item_id" class="form-control check_value_ea check_name_ea" name="updated_service_item_id">
                 <input type="hidden" name="_method" value="PUT">

               <div class="form-group">
                <label class="control-label col-sm-3" for="pwd">Service Type<span style="color:red"> *</span></label>
                <div class="col-sm-8">
                  <input type="text" id="edit_service_name" class="form-control check_value_ea check_name_ea" name="edit_service_name"
                  placeholder=""  required/><br>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Update</button>
                </div>
              </div>
            </div>

        {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
  <!-- Material for Service Group Update-->
  @endif
  <!-- END Service for Group Of Client BLOCK -->

  <!-- Service Group MODAL -->
  <div class="modal fade" id="exampleModalGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalGroupLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal" aria-label="Close">
             &times;
          </button>
          <h5 class="modal-title" id="exampleModalGroupLongTitle">Service Mangement</h5>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" action="{{route('SrvcMgm.store')}}" method="post" id="storeGroup">
            <div class="modal-body">
              {{csrf_field()}}
              <input type="hidden" id="group_id" class="form-control check_value_ea check_name_ea" name="id"><br>
              <div class="form-group">
                <label class="control-label col-sm-3" for="pwd">Service Group <span style="color:red"> *</span></label>
                <div class="col-sm-8">
                  <input type="text" id="servicename" class="form-control check_value_ea check_name_ea" name="servicename" placeholder="Group Name"  required/><br>
                  <!-- <span id="e_status" style="color:red"> </span> -->
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3" for="pwd">Is Active<span style="color:red"> *</span></label>
                <div class="col-sm-8">
                  <select class="form-control" required="" id="is_active" class="form-control check_value_ea check_name_ea" name="is_active">
                        <option value="">Select Service Status</option>
                        <option value="1">Active</option>
                        <option value="0">Not Active</option>
                  </select>
                  <br>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Submit</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- END Group Service -->
  <!-- Group Service  MODAL -->
  <div class="modal fade" id="exampleModalUpdateGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalGroupLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal" aria-label="Close">
             &times;
          </button>
          <h5 class="modal-title" id="exampleModalGroupLongTitle">Update Service Management</h5>
        </div>
        <div class="modal-body">
          {!!Form::open(['route'=>['masterServiceGroup'],'method'=>'post','class'=>'form-horizontal','id'=>'storeUpdateGroup'])!!}
            <div class="modal-body">
              {{csrf_field()}}
              <input type="hidden" id="master_update_id" class="form-control check_value_ea check_name_ea" name="update_id" ><br>
              <div class="form-group">
                <label class="control-label col-sm-3" for="pwd">Group Name<span style="color:red"> *</span></label>
                <div class="col-sm-8">

                    @if(!empty($serviceGroup->servicename))
                  <input type="text" id="edit_servicename" class="form-control check_value_ea check_name_ea setInputValue" name="servicename" placeholder="Group"
                  value="{{$serviceGroup->servicename}}" required/><br>
                  <span id="e_status" style="color:red"> </span>
                  @endif
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Update</button>
                </div>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
    </div>
  </div>
  <!-- END Group Material -->
  @endsection
  @section('script')
  <script>
  $(document).ready(function(){
      $(".editgroup").on("click", function(){

          $('#edit_servicename').val("");
          $('#master_update_id').val("");
          var dataname = $(this).attr("data-name");
          var dataid = $(this).data("id");
          $('#edit_servicename').val(dataname);
          $('#master_update_id').val(dataid);
          $('#exampleModalUpdateGroup').modal('show');

      });

      $(".edit_group_item").on("click", function(){

          $('#updated_service_item_id').val("");
          $('#edit_service-name').val("");
          // $('#edit_is_active').val("");

          var data_material_id = $(this).data("item_id");
          // var data_is_active = $(this).attr("data_is_active");
          var data_service_name = $(this).data("service-name");
          $('#updated_service_item_id').val(data_material_id);
          $('#edit_service_name').val(data_service_name);
          // $('#edit_is_active').val(data_is_active);
          $('#exampleModalServiceItem').modal('show');
      });

  });


  </script>

  @endsection
