@extends('layout.app')
@section('title')
<div class="page-title">
  <div>
    <h1><i class="  fa fa-gavel"></i>&nbsp;Departments</h1>
  </div>
  <div>
    <ul class="breadcrumb">
      <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
      <li><a href="{{route('department.master')}}">Department List</a></li>
    </ul>
  </div>
</div>
@endsection
@section('content')

<div class="row">
  <div class="col-md-12">
@include ('includes.msg')
@include ('includes.validation_messages')
  </div>
</div>




<div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-info"></i> Departments </h3></div>
      <div class="panel-body">
        <div class="row">
  <div class="col-md-7">
  </div>

   <div class="col-md-3 ">
    <a class="btn btn-danger pull-right" href="" data-toggle="modal" data-target="#myModalDepartmentDelete" title="Add"><i class="fa fa-trash"></i>&nbsp;Delete Department</a>
  </div>
  <div class="col-md-2">
    <a class="btn btn-primary pull-right" href="" data-toggle="modal" data-target="#myModalDepartment" title="Add"><i class="fa fa-plus"></i>&nbsp;Add New</a>&nbsp;&nbsp;

  </div>
</div>
<br>
        <div  id="department_holder">
        <!-- DEPARTMENT LIST DATA FROM AJAX-->
        </div>
        </div>
    </div>
  </div>

<!-- ADD DEPARTMENT DELETE MODAL -->
    <div class="modal fade" id="myModalDepartmentDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash"></i> Department Delete</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <form class="form-horizontal" action="{{route('delete.department')}}" method="post" id="deleteMasterdepartment">
                      {{csrf_field()}}
                      <div class="form-group">
                        <table id="table_portals" class="table table-bordered dataTable no-footer example" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;" >
                          <thead>
                            <tr class="t-head">
                              <th>S.No.</th>
                              <th>Department Name</th>
                              <th>Check</th>
                            </tr>
                          </thead>
                          <tbody >
                          <?php $i=1; ?>
                             
                            @foreach($departments as $row)

                              <tr role="row" class="odd">
                                <td class="sorting_1">{{$i++}}</td>
                                <td>{{$row->department_name}}</td>
                                <td>
                                  <input type="checkbox"  name="dept_id[]" value="{{$row->id}}">
                                </td>

                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8 subpadding">
                          <button class="btn btn-primary pull-right" type="submit" onclick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash"></i> Delete</button>
                          &nbsp;
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
<!-- END ADD MODAL -->

<!-- ADD DEPARTMENT MODAL -->
    <div class="modal fade" id="myModalDepartment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Department</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <form class="form-horizontal" action="" method="post" id="storeMasterdepartment">
                      {{csrf_field()}}
                      <div class="form-group">
                        <label class="control-label col-md-4">Department Name<span style="color:red"> *</span></label>
                        <div class="col-md-8">
                          <input class="form-control" id="department_name" autocomplete="false" type="text" name="department_name"  placeholder="Enter full name" required>
                          <span style="color: red" id="name_status"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8 subpadding">
                          <input class="btn btn-primary icon-btn icon-btnone pull-right" type="submit"  value="submit" >
                          &nbsp;
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
<!-- END ADD MODAL -->

<!-- EDIT DEPARTMENT MODAL -->
    <div class="modal fade" id="myModalDepartmentEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Department</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <form class="form-horizontal" action="" method="post" id="updateMasterdepartment">
                      {{csrf_field()}}
                      <input type="hidden" name="update_id" value="" id="dept_id">
                      <div class="form-group">
                        <label class="control-label col-md-4">Department Name<span style="color:red"> *</span></label>
                        <div class="col-md-8">
                          <input class="form-control" id="dept_name" autocomplete="false" type="text" name="department_name"  placeholder="Enter full name" required>
                          <span style="color: green" id="name_status"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8 subpadding">
                          <input class="btn btn-primary icon-btn icon-btnone pull-right" type="submit"  value="submit" >
                          &nbsp;
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
<!-- END EDIT MODAL -->

<!-- ADD designation MODAL -->
    <div class="modal fade" id="myModalDesignationAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Designation</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <form class="form-horizontal" action="" method="post" id="storeMasterdesignation">
                      {{csrf_field()}}
                      <input type="hidden" name="depart_id" value="" id="depart_id">
                      <div class="form-group">
                        <label class="control-label col-md-4">Department Name<span style="color:red"> *</span></label>
                        <div class="col-md-8">
                          <input class="form-control" id="depart_name" disabled="" autocomplete="false" type="text" name="department_name"  placeholder="Enter full name" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-4">Designation Name<span style="color:red"> *</span></label>
                        <div class="col-md-8">
                          <input class="form-control" id='designation_name' autocomplete="off" type="text" name="designation_name"  placeholder="Enter full name" required>
                          <span style="color: red" id="_status"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8 subpadding">
                          <input class="btn btn-primary icon-btn icon-btnone pull-right" type="submit"  value="submit" >
                          &nbsp;
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
<!-- END ADD MODAL -->

<!-- EDIT designation MODAL -->
    <div class="modal fade" id="myModalDesignationEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Designation</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <form class="form-horizontal" action="" method="post" id="updateMasterdesignation">
                      {{csrf_field()}}
                      <input type="hidden" name="depart_id" value="" id="depa_id">
                      <input type="hidden" name="deg_id" value="" id="deg_id">

                      <div class="form-group">
                        <label class="control-label col-md-4">Designation Name<span style="color:red"> *</span></label>
                        <div class="col-md-8">
                          <input class="form-control" id='deg_name' autocomplete="off" type="text" name="designation_name"  placeholder="Enter full name" required>
                          <span style="color: red" id="name_status"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-8" style="margin-left: 199px;">
    <select class="form-control" name="status" id="status">
      <option value="1">Activate</option>
      <option value="0">Deactivate</option>
    </select>
  </div>
  </div>
                      <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8 subpadding">
                          <input class="btn btn-primary icon-btn icon-btnone pull-right" type="submit"  value="submit" >
                          &nbsp;
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
<!-- END EDIT MODAL -->
@endsection
@section('script')
<script>
$(document).ready(function() {

});


jQuery(function(){
    var obj={
        init:function(){
          obj.departmentList();

          obj.departmentStore();
         // obj.departmentUnique();
          obj.departmentUpdate();

          obj.designationStore();
          //obj.designationUnique();
          obj.designationUpdate();
        },

        departmentList : function(){
          Helpers.callAjax(APP_URL+'/admin/master/department/show',
            'GET',
            {},
            'html',
            function(type,response){
              
              switch(type){
                case "success":
                  $("#department_holder").html(response);
                  $('#table_portals').DataTable();
                break;
              }
            });
          return false;
        },

        departmentStore:function(){
            jQuery(document).on('submit','#storeMasterdepartment',function(event){
                    jQuery.ajax({

                        url:"{{route('department.master.store')}}",
                        type:"POST",
                        data: jQuery('#storeMasterdepartment').serialize(),
                        dataType:'json',
                        success: function(response){
                         //alert();
                            if(response.success){
                              if(response.message){
                                 ViewHelpers.notify("success",response.message);


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
        departmentUnique:function(){
            jQuery("#department_name").on('keyup',function () {
                       var d_name = jQuery('#department_name').val();
                       if(d_name){
                           jQuery.get('department/checkUnique',{

                               d_name:d_name,

                               '_token': jQuery('meta[name="csrf-token"]').attr('content'),
                           },function(response){
                               //jQuery('#name_status').html(response);
                               if(response=="OK")
                               {
                                   jQuery('#name_status').html("This Name Already Exist!!");
                                   jQuery(':input[type="submit"]').prop('disabled', true);
                                   return true;
                               }
                               else
                               {
                                   jQuery('#name_status').html("");
                                   jQuery(':input[type="submit"]').prop('disabled', false);
                                   return false;
                               }
                           });
                       }
                       else
                       {
                           jQuery('#name_status').html("");
                           return false;
                       }
                    });
        },
        designationUnique:function(){
            jQuery("#designation_name").on('keyup',function () {
                       var d_name = jQuery('#designation_name').val();
                       var dept_id=jQuery('#depart_id').val();
                       if(d_name){
                           jQuery.get('department/checkUniquedesignation',{

                               d_name:d_name,
                               dept_id:dept_id,

                               '_token': jQuery('meta[name="csrf-token"]').attr('content'),
                           },function(response){
                               if(response=="OK")
                               {
                                   jQuery('#_status').html("This Name Already Exist!!");
                                   jQuery(':input[type="submit"]').prop('disabled', true);
                                   return true;
                               }
                               else
                               {
                                   jQuery('#_status').html("");
                                   jQuery(':input[type="submit"]').prop('disabled', false);
                                   return false;
                               }
                           });
                       }
                       else
                       {
                           jQuery('#name_status').html("");
                           return false;
                       }
                    });
        },
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
        designationStore:function(){
            jQuery(document).on('submit','#storeMasterdesignation',function(event){
                    jQuery.ajax({

                        url:"{{route('designation.master.store')}}",
                        type:"POST",
                        data: jQuery('#storeMasterdesignation').serialize(),
                        dataType:'json',
                        success: function(response){
                         //alert();
                            if(response.success){
                              if(response.message){
                                 ViewHelpers.notify("success",response.message);
                                 //$('#table_portals').DataTable().fnClearTable();

                                 obj.departmentList();
                              }
                            }
                            else{
                              if(response.message){
                                 ViewHelpers.notify("error",response.message);
                              }
                            }
                            $('#designation_name').val('');
                        },
                        error: function(err){
                            //alert(err) ;
                        }
                    });
                    event.preventDefault();
                    return false;
                });
        },
        designationUpdate:function(){
            jQuery(document).on('submit','#updateMasterdesignation',function(event){
                    jQuery.ajax({

                        url:"{{route('designation.master.update')}}",
                        type:"POST",
                        data: jQuery('#updateMasterdesignation').serialize(),
                        dataType:'json',
                        success: function(response){
                         //alert();
                            if(response.success){
                              if(response.message){
                                 ViewHelpers.notify("success",response.message);
                                 //$('#table_portals').DataTable().fnClearTable();
                                  // $('input[name=checkListItem').val('');
                                  jQuery('#myModalDesignationEdit').modal('hide');
                                 obj.departmentList();
                              }
                            }
                            else{
                              if(response.message){
                                 ViewHelpers.notify("error",response.message);
                              }
                            }
                            $('#designation_name').val('');
                        },
                        error: function(err){
                            //alert(err) ;
                        }
                    });
                    event.preventDefault();
                    return false;
                });
        },
    }
    obj.init();
});
</script>
@endsection
