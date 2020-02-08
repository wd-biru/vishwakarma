
        <table id="table_portals" class="table table-bordered dataTable no-footer example" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;" >
          <thead>
            <tr class="t-head">
              <th>S.No.</th>
              <th>Department Name</th>
              <th>Designation</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody >
          <?php $i=1; ?>
            @foreach($departments as $row)
              <tr role="row" class="odd">
                <td class="sorting_1">{{$i++}}</td>
                <td><a class="myModalDepartmentEdit" style="background: #fff ;"  data-update_id="{{$row->id}}" data-update_department_name="{{$row->department_name}}">{{$row->department_name}}</a></td>
                <td>
                  @if(!empty($row->getDesignations))
                  @foreach($row->getDesignations as $data)
                  @if($data->status==0)
                    <li><a class="myModalDesignationEdit" style="background: #fff ;color: red;" data-deg_id="{{$data->id}}" data-status=" {{$data->status}}" data-deg_name=" {{$data->designation}}"> {{$data->designation}}</a></li>
                    @else
                    <li><a class="myModalDesignationEdit" style="background: #fff ;" data-deg_id="{{$data->id}}" data-status=" {{$data->status}}" data-deg_name=" {{$data->designation}}"> {{$data->designation}}</a></li>
                    @endif
                  @endforeach
                  @endif
                </td>
                <td> @if($row->status==1)
                         <img src="{{ my_asset('images/activate.png') }}">
                         @else
                          <img class="change_status"  data-id={{$row->id}} src="{{ my_asset('images/deactivate.png') }}">
                          @endif</td>
                <td>
                  <li><a class="btn btn-primary myModalDesignationAdd"  data-depart_id="{{$row->id}}" data-depart_name="{{$row->department_name}}"> <i class="fa fa-plus"></i> Add Designation </a></li>
                  <!-- <li><a href="" style="background: #fff ;" onclick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash"></i> Delete</a></li> -->
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>




<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('.myModalDepartmentEdit').on('click',function () {
      var id = jQuery(this).data('update_id');
      var name = jQuery(this).data('update_department_name');
      jQuery('#dept_id').val(id);
      jQuery('#dept_name').val(name);
      jQuery('#myModalDepartmentEdit').modal('show');
   });
  });
  jQuery(document).ready(function(){
    jQuery('.myModalDesignationAdd').on('click',function () {
      var id = jQuery(this).data('depart_id');
      var name = jQuery(this).data('depart_name');
      jQuery('#depart_id').val(id);
      jQuery('#depart_name').val(name);
      jQuery('#myModalDesignationAdd').modal('show');
   });
  });
  jQuery(document).ready(function(){
    jQuery('.myModalDesignationEdit').on('click',function () {
      var id = jQuery(this).data('deg_id');
      var name = jQuery(this).data('deg_name');
      var status = jQuery(this).data('status');
      console.log(status);
//       if(status==0)
//       {
// $('#status').find('option').remove().end().append('<option value="1">Activate</option>').val(1);

//       }
//       else
//       {
// $('#status').find('option').remove().end().append('<option value="0">Deactivate</option>').val(0);
//       }

      jQuery('#deg_id').val(id);
      jQuery('#deg_name').val(name);
      jQuery('#myModalDesignationEdit').modal('show');
   });
  });
</script>
