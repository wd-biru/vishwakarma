@extends('layout.app')
@section('title')
<div class="page-title">
  <div>
    <h1><i class="fa fa-building"></i>&nbsp;Material Management Master Data</h1>
  </div>
  <div>
    <ul class="breadcrumb">
      <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
      <li><a href="">Material Management Data List</a></li>
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
                <h3 class="panel-title">&nbsp;Master Of Material group</h3>
            </div>
            <div class="panel-body">

              <form action="{{route('master.matMgmt')}}" method="get">
          <div class="col-md-10">

                <select class=" form-control "  id="getMaterial_by_group" required="" name="group_type_id">
                     
                                <option value="">select Group Type</option>
                                @foreach($group_type as  $row)
                                <option value="{{$row->id}}">{{$row->group_type_name}}</option>
                                @endforeach
                
            </select>
                 <br>
              </div>
              <div class="col-md-2">
              <button type="submit" class="btn btn-primary pull-right" style="width:100%;margin-top:1px;">
                <i class="fa fa-search"></i>
              </button>

             </div>

           </form>



        <form class="form-horizantol">
          <div class="form-group">
            <div class="col-md-12">
              <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModalGroup">
                <i class="fa fa-plus"></i>&nbsp;Material Group
              </button>
            </div>
          </div>
          <div class="clearfix"></div>
        </form><br>

        <div class="card col-md-12">
          <table   class="table table-bordered  table-responsive data-table">
            <thead>
              <tr class="t-head">
                <th>Master of Material Group</th>
                <th>Item Count</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="storeGroup">
            @if(count($group_material)>0)

              @foreach($group_material as $group_material)


                        <tr>
                            <td class="table-text link-color" >
                              <a href="{{ route('Getgroupitem', ['id' => $group_material->id]) }}" class="link-color">{{$group_material->group_name}}</a>
                            </td>
                            <td>{{$group_material->getCountItem()}}</td>
                            <td>
                                @if($group_material->is_active==1)
                                <form action="{{route('IsActive',['id' => $group_material->id])}}" method="get">
                                    <input type="hidden" name="is_active" value="0">
                                    <button style="background: white;border:none;outline: none; width: 45px;"  type="submit"><img src="{{ my_asset('images/activate.png') }}"></button >
                                </form>

                                @else
                                    <form action="{{route('IsActive',['id' => $group_material->id])}}" method="get">
                                    <input type="hidden" name="is_active" value="1">
                                    <button  type="submit" style="background: white;border:none;outline: none; width: 45px;"><img src="{{ my_asset('images/deactivate.png') }}"></button>
                                </form>
                                @endif
                            </td>
                            <td>
                              <span>
                              <a class="editgroup" data-id="{{$group_material->id}}" data-name="{{$group_material->group_name}}"><i class="fa fa-edit"></I></a>
                              </span>
                              <span style="margin-right: 3px; margin-left: 3px">  </span>
                              <span>
                              </span>
                            </td>

                        </tr>

                    @endforeach
            @else
                <tr><td><center>No Data To Displayed</center></td></tr>
            @endif
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
<!-- Matereal management Of Client BLOCK -->
@if(isset($material_item))
  <div class="col-md-7">
      <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">&nbsp;@if(isset($groupdata) && $groupdata){{$groupdata->group_name}} @else Material @endif</h3>
            </div>
      <div class="panel-body">
        <form class="form-horizantol">
          <div class="form-group">
            <div class="col-md-12">
              <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModalMaterial">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Material Item
              </button>
            </div>
          </div>
          <div class="clearfix"></div>
        </form><br>

        <div class="card col-md-12">
          <table class="table table-bordered  table-responsive data-table"   >
            <thead>
              <tr class="t-head">
                <th>Sr. No.</th>
                <th>Material Name</th>
                <th>Material Unit</th>
                <th>Material Description</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody >
              <?php $i=1; ?>
              @foreach($material_item as $item)
               <tr>
                <td>{{$i++}}</td>
                <td>{{$item->material_name}}</td>
                <td>{{$item->mat_unit}}</td>
                <td>{{$item->material_description}}</td>
                <td>
                    @if($item->is_active_item==1)
                    <form action="{{route('IsActiveItem',['id' => $item->id])}}" method="get">
                        <input type="hidden" name="is_active_item" value="0">
                        <button style="background: white;border:none;outline: none; width: 45px;"  type="submit"><img src="{{ my_asset('images/activate.png') }}"></button >
                    </form>

                    @else
                        <form action="{{route('IsActiveItem',['id' => $item->id])}}" method="get">
                        <input type="hidden" name="is_active_item" value="1">
                        <button  type="submit" style="background: white;border:none;outline: none; width: 45px;"><img src="{{ my_asset('images/deactivate.png') }}"></button>
                    </form>
                    @endif
                </td>

                <td>
                  <span>
                  <a class="edit_group_item" data-item_id="{{$item->id}}" data-material-name="{{$item->material_name}}" data-material-unit="{{$item->material_unit}}" data-material-description="{{$item->material_description}}"><i class="fa fa-edit"></I></a>
                      <a href="{{route('matConfig.master',['id' => $item->id, 'materialname' => $item->material_name])}}"><i class="fa fa-cog"></i></a>
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


  <!-- Material for Group -->
<div class="modal fade" id="exampleModalMaterial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal" aria-label="Close">
           &times;
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Add Material for Group : <b> @if(isset($groupdata) && $groupdata){{$groupdata->group_name}} @endif </b></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="{{route('addGroupItem',$groupdata->id)}}" method="post">
          <div class="modal-body">
            {{csrf_field()}}

             <div class="form-group">
              <label class="control-label col-sm-3" for="pwd">Material Name<span style="color:red"> *</span></label>
              <div class="col-sm-8">
                <input type="text" id="material_name" class="form-control check_value_ea check_name_ea" name="material_name" placeholder="Material Name" required/><br>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="pwd">Material Unit<span style="color:red"> *</span></label>
              <div class="col-sm-8">
                <select class="form-control" required="" id="material_unit" class="form-control check_value_ea check_name_ea" name="material_unit">


                  @if(isset($material_unit))
                      <option value="">Select Material Unit</option>
                      @foreach ($material_unit as $unit)
                      <option value="{{ $unit->id }}">{{ $unit->material_unit }}</option>
                      @endforeach
                    @endif
                </select>
                <br>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="pwd">Material Description<span style="color:red"> *</span></label>
              <div class="col-sm-8">
                <textarea class="form-control check_value_ea check_name_ea" id="material_description" name="material_description" required></textarea><br>
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

<!-- Material for Group Item Update-->
<div class="modal fade" id="exampleModalMaterialItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal" aria-label="Close">
           &times;
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Update Material For Group : <b> @if(isset($groupdata) && $groupdata){{$groupdata->group_name}} @endif </b></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="{{route('updateGroupItem')}}" method="post">
          <div class="modal-body">
            {{csrf_field()}}
               <input type="hidden" id="updated_material_item_id" class="form-control check_value_ea check_name_ea" name="updated_material_item_id">
             <div class="form-group">
              <label class="control-label col-sm-3" for="pwd">Material Name<span style="color:red"> *</span></label>
              <div class="col-sm-8">
                <input type="text" id="edit_material_name" class="form-control check_value_ea check_name_ea" name="material_name" placeholder="Material Name" required/><br>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="pwd">Material Unit<span style="color:red"> *</span></label>
              <div class="col-sm-8">
                <select class="form-control" required="" id="edit_material_unit" class="form-control check_value_ea check_name_ea" name="material_unit">
                  @if(isset($material_unit))
                      <option value="">Select Material Unit</option>
                      @foreach ($material_unit as $unit)
                      <option value="{{ $unit->id }}">{{ $unit->material_unit }}</option>
                      @endforeach
                    @endif
                </select>
                <br>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="pwd">Material Description<span style="color:red"> *</span></label>
              <div class="col-sm-8">
                <textarea class="form-control check_value_ea check_name_ea" id="edit_material_description" name="material_description" required></textarea><br>
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
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Material for Group Item Update-->
@endif
<!-- END Material for Group Of Client BLOCK -->

<!-- Group Material  MODAL -->
<div class="modal fade" id="exampleModalGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalGroupLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal" aria-label="Close">
           &times;
        </button>
        <h5 class="modal-title" id="exampleModalGroupLongTitle">Material Mangement</h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="{{route('storematMgmt')}}" method="post" id="storeGroup">
          <div class="modal-body">
            {{csrf_field()}}
            <input type="hidden" id="group_id" class="form-control check_value_ea check_name_ea" name="id"><br>
            <div class="form-group">
              <label class="control-label col-sm-3" for="pwd">Group Name<span style="color:red"> *</span></label>
              <div class="col-sm-8">
                <input type="text" id="group_name" class="form-control check_value_ea check_name_ea" name="group_name" placeholder="Group"  required/><br>
                <!-- <span id="e_status" style="color:red"> </span> -->
              </div>

              <label class="control-label col-sm-3" for="pwd">Group Type<span style="color:red"> *</span></label>
              <div class="col-sm-8">

                <select class=" form-control "  name="group_type_id" required="">
                     
                                <option value="">select Group Type</option>
                                @foreach($group_type as  $row)
                                <option value="{{$row->id}}">{{$row->group_type_name}}</option>
                                @endforeach
                
            </select>
                
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
<!-- END Group Material -->

<!-- Group Material  MODAL -->
<div class="modal fade" id="exampleModalUpdateGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalGroupLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal" aria-label="Close">
           &times;
        </button>
        <h5 class="modal-title" id="exampleModalGroupLongTitle">Update Material Mangement</h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="{{route('masterGroupUpdate')}}" method="post" id="storeUpdateGroup">
          <div class="modal-body">
            {{csrf_field()}}
            <input type="hidden" id="master_update_id" class="form-control check_value_ea check_name_ea" name="update_id" ><br>
            <div class="form-group">
              <label class="control-label col-sm-3" for="pwd">Group Name<span style="color:red"> *</span></label>
              <div class="col-sm-8">
                  @if(!empty($group_material->group_name))
                <input type="text" id="edit_group_name" class="form-control check_value_ea check_name_ea" name="group_name" placeholder="Group" value="{{$group_material->group_name}}" required/><br>
                  @endif
                <!-- <span id="e_status" style="color:red"> </span> -->
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
        </form>
      </div>
    </div>
  </div>
</div>
<!-- END Group Material -->
@endsection
@section('script')
<script>
$(document).ready(function() {
    $('.data-table').DataTable({                         
        "bInfo" : false,
        "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>'
    });
});


$(document).ready(function(){
    $(".editgroup").on("click", function(){
        $('#edit_group_name').val("");
        $('#master_update_id').val("");
        var dataname = $(this).attr("data-name");
        var dataid = $(this).data("id");
        $('#edit_group_name').val(dataname);
        $('#master_update_id').val(dataid);
        $('#exampleModalUpdateGroup').modal('show');

    });

    $(".edit_group_item").on("click", function(){
        $('#edit_material_name').val("");
        $('#edit_material_unit').val("");
        $('#edit_material_description').val("");
        $('#updated_material_item_id').val("");
        var data_material_name = $(this).attr("data-material-name");
        var data_material_unit = $(this).attr("data-material-unit");
        var data_material_description = $(this).attr("data-material-description");
        var data_material_id = $(this).attr("data-item_id");
        $('#updated_material_item_id').val(data_material_id);
        $('#edit_material_name').val(data_material_name);
        $('#edit_material_unit').val(data_material_unit);
        $('#edit_material_description').val(data_material_description);
        $('#exampleModalMaterialItem').modal('show');
    });

});


 
                            
 

</script>

@endsection
