@extends('layout.project')

@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;Agreement Details</h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>  
            <li>{{ link_to_route('projects.index',trans('project.projects'), ['status_id' => request('status_id', $project->status_id)]) }}</li>
            <li>{{ $project->present()->projectLink }}</li>
            <li class="active">{{ isset($title) ? $title :  trans('agreement.details') }} </li>
        </ul>
    </div>
</div>

@endsection

@section('content-project')


@include('includes.msg')
@include('includes.validation_messages')


    <div class="row">
        <div class="col-md-12">
            <div class="content-section">
              <div class="table-responsive">
                <table  class="table table-bordered main-table search-table ">
                  <thead>
                    <tr class="btn-primary">
                        <th>Sr. No</th>
                        <th>Agreement Name</th>
                        <th>Item Name</th>
                        <th>Recovery Rate</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i=1;
                    ?>
                    @foreach($data as $value)
                    <tr>
                      <td>{{$i++}}</td>
                      <td></td>
                      <td>{{$value->material_name}}</td>
                      <td>{{$value->recovery_rate}}</td>
                      <td>{{$value->remarks}}</td>
                       <td>     
                          <span>
                              <a class="edit_agreement_item" data-item-id="{{$value->id}}" data-item-name="{{$value->material_name}}" data-agreement-racovery-rate="{{$value->recovery_rate}}" data-agreement-remarks="{{$value->remarks}}"><i class="fa fa-edit"></i></a>&nbsp;
                              <a href="{{route('deleteAgreement',$value->id)}}" onclick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash"></i></a>

                          </span>
                      </td>

                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
        </div>
    </div>

<!-- Agreement material Model Item Update-->

<div class="modal fade" id="agreementModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal" aria-label="Close">
           &times;
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Update Agreement :</h5>
      </div>
      <div class="modal-body">
        {!! Form::model($project, ['route' => ['agreementResorurce.update', $project->id], 'method' => 'post','class' => 'form-horizontal' ]) !!}
          <div class="modal-body">
            {{csrf_field()}}
               <input type="hidden" id="updated_material_item_id" class="form-control check_value_ea check_name_ea" name="updated_material_item_id">
               <div class="form-group">
              <label class="control-label col-sm-4" for="pwd">Item Name&nbsp;</label>
              <div class="col-sm-8">
                <input type="text" id="item_name" class="form-control check_value_ea check_name_ea" name="" placeholder="Item Name" readonly /><br>
              </div>
            </div>
             <div class="form-group">
              <label class="control-label col-sm-4" for="pwd">Recovery Rate&nbsp;<span style="color: red;">*</span></label>
              <div class="col-sm-8">
                <input type="number" id="edit_recovery_rate" class="form-control check_value_ea check_name_ea" name="recovery_rate" placeholder="Recovery Rate" required="" /><br>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="pwd">Remarks&nbsp;</label>
              <div class="col-sm-8">
                <input type="text" id="edit_remarks" class="form-control check_value_ea check_name_ea" name="remarks" placeholder="Remarks" /><br>
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
          {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
<!-- Agreement material Model Item Update-->

@endsection

@section('script')
<script>
$(document).ready(function(){

    $(".edit_agreement_item").on("click", function(){
        $('#item_name').val("");
        $('#edit_recovery_rate').val("");
        $('#edit_remarks').val("");
        $('#updated_material_item_id').val("");
        var data_item_name = $(this).attr("data-item-name");
        var data_recovery_rate = $(this).attr("data-agreement-racovery-rate");
        var data_remarks = $(this).attr("data-agreement-remarks");
        var data_agreement_id = $(this).attr("data-item-id");
        $('#item_name').val(data_item_name);
        $('#edit_recovery_rate').val(data_recovery_rate);
        $('#edit_remarks').val(data_remarks);
        $('#updated_material_item_id').val(data_agreement_id);
        $('#agreementModel').modal('show');
    });

});

</script>
@endsection



 
 
