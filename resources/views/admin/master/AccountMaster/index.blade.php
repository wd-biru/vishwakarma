@extends('layout.app')
@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-money"></i>&nbsp;Master Billing Cycle</h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
            <li><a href="{{route('masterBillingCycle.index')}}">Master Billing Cycle</a></li>
        </ul>
    </div>
</div>
@endsection
@section('content')
@include('includes.msg')
@include('includes.validation_messages')

<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary" data-toggle="modal" data-target="#myBillingCycleModel">Create Master Billing Cycle</a>
    </div>
    <div class="col-md-12">
        <div class="content-section">
            <div class="  table-responsive  "style="overflow-x: inherit!important;min-height: 0.01%;">
                <table class="table table-bordered main-table" id="search-table">
                    <thead class="table-primary-th">
                        <tr class="btn-primary">
                            <th>Sr. No</th>
                            <th>Billing Cycle</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1;
                        ?>
                        @foreach($billingCycles as $billingCycle)
                        <tr>
                            <td>{{$count++}}</td>
                            <td>{{$billingCycle->billing_cycle}}</td>
                            <td>
                                <span><a class="editbillingCycle" data-id="{{$billingCycle->id}}" data-name="{{$billingCycle->billing_cycle}}"><i class="fa fa-edit"></I></a></span>
                                <span><a href="{{route('billingCycleDelete',$billingCycle->id)}}"><i onclick="return confirm('Are you sure?');" class="fa fa-trash"></i></a></span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>



<!--Start Create New Bill Cycle Model-->
<div class="modal fade" id="myBillingCycleModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal" aria-label="Close">
                 &times;
                </button>
                <h5 class="modal-title" id="exampleModalLongTitle">Add Billing Cycle :</h5>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{route('masterBillingCycle.store')}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="email">Billing Cycle <span style="color: red">*</span></label>
                                </div>
                                <div class="col-md-8" style="margin-bottom: 15px;">
                                    <input type="text" name="billing_cycle" class="form-control" placeholder="Enter Billing Cycle" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Create New Bill Cycle Model-->

<!-- Material for Group Item Update-->
<div class="modal fade" id="editMasterBillingCycle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal" aria-label="Close">
           &times;
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Update Billing Cycle : </b></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="{{route('masterBillingCycleUpdate')}}" method="post">
          <div class="modal-body">
            {{csrf_field()}}
               <input type="hidden" id="updated_billing_cycle_id" class="form-control" name="updated_billing_cycle_id">
             <div class="form-group">
              <label class="control-label col-sm-3" for="pwd">Billing Cycle <span style="color:red"> *</span></label>
              <div class="col-sm-8">
                <input type="text" id="edit_billing_cycle" class="form-control" name="edit_billing_cycle" placeholder="Billing Cycle " required/><br>
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



@endsection

@section('script')
<script type="text/javascript">
        jQuery('#search-table').DataTable({
            "language": {
            "emptyTable": "No data available "
            }
        });

    $(document).ready(function(){

        $(".editbillingCycle").on("click", function(){

            $('#edit_billing_cycle').val("");
            $('#updated_billing_cycle_id').val("");
           
            var data_billing_name = $(this).attr("data-name");
            var data_billing_id = $(this).attr("data-id");

            $('#edit_billing_cycle').val(data_billing_name);
            $('#updated_billing_cycle_id').val(data_billing_id);
            
            $('#editMasterBillingCycle').modal('show');
        });
    });


</script>
@endsection
