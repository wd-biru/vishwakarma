@extends('layout.app')
@section('title')
<?php
$material_item_id = $request->id;
$material_item_name = $request->materialname;

?>
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Material Configuration (<?php echo $material_item_name; ?>)</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="#">Material Config</a></li>
                <li><a href="#">Add</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')

<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plus"></i> Add Material Config</h3>
            </div>
            <div class="panel-body">
                @include('includes.msg')
                @include('includes.validation_messages')
                <div class="row">
                    <form class="form-horizontal" action="{{route('matConfigStore')}}" method="post" enctype="multipart/form-data"> 
                        {{ csrf_field() }}

                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-body"> 
                                    <fieldset>
                                        <legend>Material Configuration (<?php echo $material_item_name; ?>)</legend>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Item Name&nbsp;</label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" name="item_name"  placeholder="" value="{{$material_item_name}}" readonly="">
                                                <input type="hidden" name="item_id" value="{{$material_item_id}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Label Text&nbsp;</label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" name="label_text" value="" placeholder=" ">
                                            </div>
                                        </div>
                                      
                                       <div class="form-group">
                                            <label class="control-label col-md-3">Control Type&nbsp;</label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" value="" name="control_type" id="" placeholder="" >
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Default Value</label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" value="" name="default_value" id=""  placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Is Calculated&nbsp;</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="is_calculated" id="edit_is_calculated" >
                                                    <option></option>
                                                    <option value="false">User</option>
                                                    <option value="true">System</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" id="submit_btn" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </form>
                        <div class="col-md-7" style="margin-top: 27px;">
                            <div class="content-section">
                                <div class="  table-responsive ">
                                    <table class="table table-bordered main-table search-table " >
                                        <thead>
                                            <tr class="t-head">
                                                <th>Sr. No.</th>
                                                <!-- <th>Item Name</th> -->
                                                <th>Label Text</th>
                                                <th>Control Type</th>
                                                <th>Default Value</th>
                                                <th>Is Calculated</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $count = 1;?>
                                            @foreach($materialConfigs as $materialConfig)

                                                <tr>
                                                    <td>{{$count++}}</td>
                                                    <!-- <td>{{$materialConfig->item_name}}</td> -->
                                                    <td>{{$materialConfig->label_text}}</td>
                                                    <td>{{$materialConfig->control_type}}</td>
                                                    <td>{{$materialConfig->default_value}}</td>
                                                    <td>@if($materialConfig->is_calculated == 'false')
                                                            User
                                                                @else
                                                            System
                                                        @endif
                                                    </td>
                                                    <td>   

                                                  
                                                        <span>
                                                            <a class="edit_material_item" data-item-id="{{$materialConfig->id}}" data-material-label-text="{{$materialConfig->label_text}}" data-material-control-type="{{$materialConfig->control_type}}" data-material-default-value="{{$materialConfig->default_value}}" data-material-is-calculated="{{$materialConfig->is_calculated}}"><i class="fa fa-edit"></i></a>


                                                         <a  href="{{route('deleteConfig',[$materialConfig->id])}}"><i  onclick="return confirm('Are you sure?');"class="fa fa-trash"></i></a>
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

                <div class="row">
                    <form class="form-horizontal" action="{{route('UpdateFormulae')}}" method="post" enctype="multipart/form-data"> 
                        {{ csrf_field() }}
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-body"> 
                                    <fieldset>
                                        <legend>Material Item Formulae</legend>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Item Name&nbsp;</label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" name="item_name"  placeholder="" value="{{$material_item_name}}" readonly="">
                                                <input type="hidden" name="item_id" value="{{$material_item_id}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Formulae Name&nbsp;</label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" name="formulae_name" value="" placeholder=" ">
                                            </div>
                                        </div>

                                    <div id="system_calculated_foumulae">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="pwd">Default Value</label>
                                            <div class="col-sm-9">
                                                <select class="form-control"  class="form-control  " name="formulae[]" required>
                                                <option value="">select Label</option>
                                                @foreach($material_config_by_item as  $row)
                                                <option value="{{$row->id}}">{{$row->label_text}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="pwd">Select Operator</label>
                                            <div class="col-sm-9">
                                                <select class="form-control"  class="form-control " name="formulae[]" required>
                                                    <option value="">select Operator</option>
                                                    <option value="addition">addition</option>
                                                    <option value="substraction">substraction</option>
                                                    <option value="multiplication">multiplication</option>
                                                    <option value="division">division</option>
                                                </select>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="pwd">Default Value</label>
                                            <div class="col-sm-7">
                                                <select class="form-control"  class="form-control  " name="formulae[]" required>
                                                    <option value="">select Label</option>
                                                    @foreach($material_config_by_item as  $row)
                                                    <option value="{{$row->id}}">{{$row->label_text}}</option>
                                                    @endforeach
                                                </select>
                                          </div>
                                           <div class="col-sm-1">
                                                <a class="btn btn-primary" onclick="addSection();" style="width:100%;margin-top:1px;"><i class="fa fa-plus" ></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="addDataHere"></div>
                                        <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit_btn" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                        </div>
                                    </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-7" style="margin-top: 27px;"> <legend> Formulae</legend>
                        <div class="content-section">
                            <div class="  table-responsive ">
                                <table class="table table-bordered main-table search-table " >
                                    <thead>
                                        <tr class="t-head">
                                            <th>Sr. No.</th>
                                            <!-- <th>Item Name</th> -->
                                            <th>Name</th>
                                            <!-- <th>Formulae</th> -->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1;?>
                                        @foreach($materialFormulae as $row)
                                                <tr>
                                                <td>{{$count++}}</td>
                                                <td>{{$row->formulae_name}}</td>
                                                <!-- <td>$row->formulae}}</td> -->
                                                <td>   
                                                    <span>
                                                        <a href="{{route('editFormulae',[$row->id,$_GET['id']])}}"><i class="fa fa-edit"></i></a>

                                                         <a  href="{{route('deleteFormulae',[$row->id])}}"><i  onclick="return confirm('Are you sure?');"class="fa fa-trash"></i></a>
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
            </div>
        </div>
    </div>
</div>

<!-- material Config Model Item Update-->
<div class="modal fade" id="materialConfigModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal" aria-label="Close">
                 &times;
                </button>
                <h5 class="modal-title" id="exampleModalLongTitle">Update Material Configuration :</h5>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{route('updateMaterialConfigItem')}}" method="post">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <input type="hidden" id="updated_material_item_id" class="form-control check_value_ea check_name_ea" name="updated_material_item_id">
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="pwd">Label Text</label>
                            <div class="col-sm-8">
                                <input type="text" id="edit_label_text" class="form-control check_value_ea check_name_ea" name="label_text" placeholder="Label Text" /><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="pwd">Control Type</label>
                            <div class="col-sm-8">
                                <input type="text" id="edit_control_type" class="form-control check_value_ea check_name_ea" name="control_type" placeholder="Control Type" /><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="pwd">Default Value</label>
                            <div class="col-sm-8">
                                <input type="text" id="edit_default_value" class="form-control check_value_ea check_name_ea" name="default_value" placeholder="Default Value" /><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="pwd">Is Calculated</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="edit_is_calculated" class="form-control check_value_ea check_name_ea" name="is_calculated">
                                    <option value="false">User</option>
                                    <option value="true" >System</option>
                                </select>
                                <br>
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
<!-- material Config Model Item Update-->

@endsection

@section('script')
<script>
$(document).ready(function(){

    $(".edit_material_item").on("click", function(){
        $('#edit_label_text').val("");
        $('#edit_control_type').val("");
        $('#edit_default_value').val("");
        $('#edit_is_calculated').val("");
        $('#updated_material_item_id').val("");
        var data_material_label_text = $(this).attr("data-material-label-text");
        var data_material_control_type = $(this).attr("data-material-control-type");
        var data_material_default_value= $(this).attr("data-material-default-value");
        var data_material_is_calculated= $(this).attr("data-material-is-calculated");
        var data_material_id = $(this).attr("data-item-id");
        $('#edit_label_text').val(data_material_label_text);
        $('#edit_control_type').val(data_material_control_type);
        $('#edit_default_value').val(data_material_default_value);
        $('#edit_is_calculated').val(data_material_is_calculated);
        $('#updated_material_item_id').val(data_material_id);
        $('#materialConfigModel').modal('show');
    });

});

</script>

<script>

    $( document ).ready(function() {
        // $('#system_calculated_foumulae').hide();
        jQuery(document).on('change','#edit_is_calculated',function(){ 
            var thisval = jQuery(this).val(); 
            if(thisval == 'true'){
                $('#system_calculated_foumulae').show();
            }else{
                $('#system_calculated_foumulae').hide();
            }
       
        });
   
    });
    function addSection(){

        var html = '<div> <div class="form-group"><label class="control-label col-sm-3" for="pwd">Select Operator</label>s<div class="col-sm-7"> <select class="form-control" required class="form-control " name="formulae[]"> <option value="">select Operator</option> <option value="addition">addition</option> <option value="substraction">substraction</option> <option value="multiplication">multiplication</option> <option value="division">division</option> </select> </div> </div> <div class="form-group"> <label class="control-label col-sm-3" for="pwd">Default Value</label> <div class="col-sm-7"> <select class="form-control" class="form-control " required name="formulae[]"> <option value="">select Label</option> @foreach($material_config_by_item as $row) <option value="{{$row->id}}">{{$row->label_text}}</option> @endforeach </select> </div> <div class="col-sm-1"> <a class="btn btn-primary" onclick="addSection();" style="width:100%;margin-top:1px;"><i class="fa fa-plus" ></i> </a> </div> <div class="col-sm-1"> <a class="btn btn-primary" onclick="return removeSection($(this))" style="width:100%;margin-top:1px;"><i class="fa fa-trash"></i></a> </div> </div> </div>';

        $(".addDataHere").append(html);
    }

    function removeSection(data){
        var data1 = data.parent().parent().parent();
        (data1).remove();
    }
    
</script>
@endsection
