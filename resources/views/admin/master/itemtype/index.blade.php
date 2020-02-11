@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Group Category</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('portal')}}">Users list</a></li>
                <!-- <li><a href="#">list</a></li> -->
            </ul>
        </div>
    </div>
@endsection
@section('content')
@include('includes.msg')
@include('includes.validation_messages')


<div class="row ">
    
    <div class="col-md-12">
        <div class="content-section">
            <form class="form-horizantol">
          <div class="form-group">
            <div class="col-md-12">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalGroup">
                <i class="fa fa-plus"></i>&nbsp;Group Category
              </button>
            </div>
          </div>
          <div class="clearfix"></div>
        </form><br><br>
            <div class="  table-responsive ">
                <table class="table table-bordered main-table search-table " >
                    <thead>
                        <tr class="t-head">
                            <th>Sr. No.</th>
                            <th>Item Group Type Name</th>
                            <th>Date</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody><?php $i=1;?>
                        @foreach($group_type as $list)
                        <tr>
                            <td>{{$i++}}</td>
                           
                            <td>{{$list->group_type_name}}</td>
                            <td>{{date("d-m-Y", strtotime($list->created_at))}}</td>
                          
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('itemTypeEdit',[$list->id])}}"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp; Edit</a></li>
                                        <li><a href="{{route('itemTypeDelete',[$list->id])}}" onclick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp; Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Group Material  MODAL -->
<div class="modal fade" id="exampleModalGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalGroupLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal" aria-label="Close">
           &times;
        </button>
        <h5 class="modal-title" id="exampleModalGroupLongTitle">Group Category Management</h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="{{route('storeItemType')}}" method="post">
          <div class="modal-body">
            {{csrf_field()}}
           <br>
            <div class="form-group">
              <label class="control-label col-sm-3" for="pwd">Item Group Type<span style="color:red"> *</span></label>
              <div class="col-sm-8">
                <input type="text" class="form-control check_value_ea check_name_ea" name="group_type_name" placeholder="Group"  required/><br>
                <!-- <span id="e_status" style="color:red"> </span> -->
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
@endsection


<script>
    

      departmentUpdate:function(){
            jQuery(document).on('submit','#updateMasterdepartment',function(event){
                    jQuery.ajax({

                        url:"{{route('department.master.update')}}",
                        type:"POST",
                        data: jQuery('#updateMasterdepartment').serialize(),
                        dataType:'json',
                        success: function(response){
                         //alert();
                            if(response.success){
                              if(response.message){
                                 ViewHelpers.notify("success",response.message);
                                 //$('#table_portals').DataTable().fnClearTable();
                                 jQuery('#myModalDepartmentEdit').modal('hide');
                                 obj.departmentList();
                              }
                            }
                            else{
                              if(response.message){
                                 ViewHelpers.notify("error",response.message);
                              }
                            }
                            $('#department_name').val('');
                        },
                        error: function(err){
                            //alert(err) ;
                        }
                    });
                    event.preventDefault();
                    return false;
                });
        },
</script>
