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
            <li><a href="">Project Store Stock Maintence</a></li>
            
        </ul>
    </div>
</div>
@endsection
@section('content-project')
@include('projects.partials.nav-store-tabs')


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
    <div class="col-md-12 " > 
        <center> 
            <label>
                <button name="unit_system_no" class="btn btn-primary radio" value="0">Mannualy Entry </button> 
            </label> 
                &nbsp;&nbsp;&nbsp;
            <label>
                <button name="unit_system_no" class="btn btn-primary radio" value="1">CSV Upload</button> 
         
            </label> 
           
        </center>  
    </div>
    <div class="col-md-12" >         
    @include('includes.msg')
    @include('includes.validation_messages')
        <div id="id-Mannualy"  @if(Session::has('CountValues')) style="display: none" @endif >   
            <div class="panel panel-default">
                <div class="panel-heading" id="mannual_link"> 
                    <h3 class="panel-title">&nbsp;Material List</h3>  
                </div> 
                <div class="panel-body"> 
                    <div class="col-md-12 Mannualy">                    
                        <form action="{{route('storeQuantity',[$project->id ,base64_encode($store)])}}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="store_id" value="{{base64_encode($store)}}">                    
                            <label>Material Group</label>&nbsp;&nbsp;&nbsp;
                            <select name="group_id" class="form-control selectable" id="getMaterialQunatity" style="padding-bottom: 9px;margin-bottom: 18px;"> 
                                <option value="">Select Material Group</option>
                                    @foreach($store_inventory_material_group as $material)
                                        <option value="{{$material->id}}">{{$material->group_name}}</option>
                                    @endforeach
                            </select>  
                            <div class="table-responsive" id="getListQuantity"> 
                            </div>  
                            <button type="submit"  class="btn btn-primary">Submit</button>  
                        </form>
                    </div>
                </div>
            </div>
        </div> 
        <div id="id-Bulk" @if(!Session::has('CountValues')) style="display: none" @endif >   
            <div class="panel panel-default">
                <div class="panel-heading" id="mannual_link"> 
                    <h3 class="panel-title">&nbsp;Bulk Upload (CSV Import)</h3>  
                </div> 
                <div class="panel-body"> 
                    <div class="col-md-12">  
                        <div class="row">
                            <form method="post" enctype="multipart/form-data" action="{{route('initialStockImport',[$project->id ,base64_encode($store)])}}">
                                {{ csrf_field() }}
                                <div class=" col-md-4">
                                    <label class="control-lable">Select File for Upload</label> 
                                </div>
                                    
                                <div class=" col-md-6">
                                    <input type="file" class="form-control" name="select_file" />
                                </div>
                                <div class=" col-md-2">
                                     <input type="submit" name="upload" class="btn btn-primary" value="Upload">
                                </div>  
                           </form>
                        </div>
                        <hr> 
                        <div class="row"> 
                            @if(Session::has('CountValues')) 
                            <div class="col-md-6">
                                @foreach(session()->get('CountValues')[0]  as $key => $in)

                                    @if(!is_array($in))
                                    <div class="col-md-6 ">
                                        <h4>{{$key}}</h4>
                                    </div> 
                                    <div class="col-md-6 ">
                                        <h4>{{$in}}</h4>
                                    </div>  
                                    @endif                                     
                                @endforeach
                            </div>
                            <div class="col-md-6  table-responsive"> 
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="btn-primary">
                                            <th>Item Not Exist <b class="pull-right">({{count(session()->get('CountValues')[0]['ItemNotFound'])}})</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(session()->get('CountValues')[0]['ItemNotFound']  as $key => $in) 
                                            <tr>
                                                <td>{{$in}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>                                    
                                </table>
                            </div>
                            @endif 
                        </div>   
                    </div>
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


<script>  

jQuery(function(){
    var obj={
        init:function(){
            jQuery(document).ready(function(){ 
                jQuery(document).on('click',".radio",function(){
                    var radiovalue = jQuery(this).val();  
                    obj.initialStockDivs(radiovalue);
                });
                $('#getMaterialQunatity').on('change', function () {
                    var group_id = $(this).val(); 
                    obj.getItems(group_id);
                });
            });
        },
        initialStockDivs:function(radiovalue){   
            if(radiovalue==0){
                jQuery("#id-Mannualy").show();
                jQuery("#id-Bulk").hide();
            }else{ 
                jQuery("#id-Mannualy").hide();
                jQuery("#id-Bulk").show();
            } 
        },
        getItems:function(group_id){
            $.ajax({
                url: "{{route('getItemsQuantity',[$project->id,base64_encode($store)])}}",
                type: 'get',
                data: {"group_id": group_id,
                "_token": "{{ csrf_token() }}"},
                datatype: 'html',
                success: function (data) {   
                    $("#freshStoreQuantity").DataTable().destroy();  
                    $('#getListQuantity').html(data); 
                    $('#freshStoreQuantity').DataTable({
                        "language": {
                            "emptyTable": "No data available ",
                            "aLengthMenu": [100]
                        }, 
                        dom: 'Bfrtip',
                        buttons: [{extend: 'excel',className: 'btn btn-primary', text: 'Export in Excel', footer: true , filename: 'Current Store Stock Quantity'}]
                    }); 
                }
            });
        },
    }
    obj.init();
});


 

</script>

@endsection
