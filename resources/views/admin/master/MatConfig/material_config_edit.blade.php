@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Config</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('master.vendorReg')}}">Config</a></li>
                <li><a href="#">Edit</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')


<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plus"></i> Group Category Update</h3></div>
            <div class="panel-body">
                @include('includes.msg')
                @include('includes.validation_messages')

                    <form class="form-horizontal" action="{{route('updateMaterialConfigItem')}}" method="post">
          <div class="modal-body">
            {{csrf_field()}}
               <input type="hidden" id="updated_material_item_id" class="form-control check_value_ea check_name_ea" name="updated_material_item_id">
             <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Label Text</label>
              <div class="col-sm-8">
                <input type="text" value="{{$materialConfig->label_text}}" class="form-control check_value_ea check_name_ea" name="label_text" placeholder="Label Text" /><br>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Control Type</label>
              <div class="col-sm-8">
                <input type="text" value="{{$materialConfig->control_type}}" class="form-control check_value_ea check_name_ea" name="control_type" placeholder="Control Type" /><br>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Default Value</label>
              <div class="col-sm-8">
                <input type="text" value="{{$materialConfig->default_value}}" class="form-control check_value_ea check_name_ea" name="default_value" placeholder="Default Value" /><br>
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Is Calculated</label>
              <div class="col-sm-8">
                <select class="form-control" id="edit_is_calculated" class="form-control" name="is_calculated">
                   
                     <option value="">Select</option>
                     <option value="false">User</option>
                    <option value="true" >System</option>
                </select>
                <br>
              </div>
            </div> 

            <div id="system_calculated_foumulae">
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Default Value</label>
              <div class="col-sm-8">
                 <select class="form-control"  class="form-control  " name="is_calculated">
                 <option value="">select Label</option>
                                @foreach($material_config_by_item as  $row)
                                <option value="{{$row->id}}">{{$row->label_text}}</option>
                                @endforeach
                                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Default Value</label>
              <div class="col-sm-8">
                 <select class="form-control"  class="form-control " name="is_calculated">
                 <option value="">select Operator</option>
                               
                                <option value="addition">addition</option>
                                <option value="substraction">substraction</option>
                                <option value="multiplication">multiplication</option>
                                <option value="division">division</option>
                              
                                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Default Value</label>
              <div class="col-sm-8">
                 <select class="form-control"  class="form-control  " name="is_calculated">
                 <option value="">select Label</option>
                                @foreach($material_config_by_item as  $row)
                                <option value="{{$row->id}}">{{$row->label_text}}</option>
                                @endforeach
                                </select>
              </div>
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
</div>
@endsection

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script> 
<script>

    $( document ).ready(function() {
        $('#system_calculated_foumulae').hide();
    jQuery(document).on('change','#edit_is_calculated',function(){ 
        var thisval = jQuery(this).val(); 

        if(thisval == 'true'){
         $('#system_calculated_foumulae').show();
        }else{
         $('#system_calculated_foumulae').hide();
        }
       
    });
   
});
    
</script>
@endsection