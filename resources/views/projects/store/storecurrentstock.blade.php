@extends('layout.project')
@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;Store</h1>
    </div>
    <div>
        <ul class="breadcrumb"> 
            <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
            <li>{{ link_to_route('projects.index',trans('project.projects'), ['status_id' => request('status_id', $project->status_id)]) }}</li>
            <li>{{ $project->present()->projectLink }}</li>
            <li><a href="">Project Current Store Stock</a></li>
            
        </ul>
    </div>
</div>
@endsection
@section('content-project')
@include('projects.partials.nav-store-tabs')
@include('includes.msg')
@include('includes.validation_messages')
<style type="text/css">
    .status{
        width: 15px;
        background: none;
        color: inherit;
        border: none;
        padding: 0;
        font: inherit;
        cursor: pointer;
        outline: inherit;
    }
</style>
 
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">&nbsp;Material List</h3>
            </div>
            <div class="panel-body">
                <div class="card col-md-12 ">
           
                        <label>Material Group</label>&nbsp;&nbsp;&nbsp;
                        <select name="group_id" class="form-control selectable" id="getMaterialQunatity" style="padding-bottom: 9px;margin-bottom: 18px;">

                              <option value="0">All Material Item</option>
                            @foreach($store_inventory_material_group as $material)
                                <option value="{{$material->id}}">{{$material->group_name}}</option>
                            @endforeach
                        </select> 
                        <br> 
                        <br>
                        <div class="table-responsive" id="getListQuantity"> 

                            <table class="table table-bordered table-hover search-table" id="freshStoreQuantity">
                                <thead>
                                    <tr class="t-head">
                                        <th>Material Name </th>
                                        <th>Material Unit</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if($mat_itam_list->count()>0)
                                        @foreach($mat_itam_list as $value)
                                            <tr>
                                                <?php $unit_name = DB::table('vishwa_unit_masters')->where('id',$value->material_unit)->first();?>
                                                <td>{{$value->material_name}}</td>
                                                <td>{{$unit_name->material_unit}}</td>
                                                <td>{{$value->availableQty}}</td>
                                                
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>  


                            
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')



  

    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>








<script type="text/javascript">
    $(document).ready(function() {
// 
            $('#getMaterialQunatity').on('change', function () {
                var group_id = $(this).val();

              

                $.ajax({
                    url: "{{route('getCurrentItemsQuantity',[$project->id,base64_encode($store)])}}",
                    type: 'get',
                    data: {"group_id": group_id,
                        },
                    datatype: 'html',
                    success: function (data) {      
                        //console.log(data);

                        $("#freshStoreQuantity").DataTable().destroy();  
                        $('#getListQuantity').html(data);
                        $("#freshStoreQuantity").DataTable();

                                  
                  }
                });
            }); 
        });

   

            $('#freshStoreQuantity').DataTable({
            "language": {
            "emptyTable": "No data available "
            },

            dom: 'Bfrtip',
            buttons: [{extend: 'excel',className: 'btn btn-primary', text: 'Export in Excel', footer: true , filename: 'Current Store Stock Quantity'}]
        });



         



</script>

@endsection
