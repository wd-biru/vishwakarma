@extends('layout.project')

@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>&nbsp;Indent Allocation Edit</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li>{{ link_to_route('projects.index',trans('project.projects'), ['status_id' => request('status_id', $project->status_id)]) }}</li>
                <li>{{ $project->present()->projectLink }}</li>
                <li><a href="#">Indent Allocation Edit</a></li>
            </ul>
        </div>
    </div>

@endsection




@section('content')

        <div class="row">
            <div class="col-md-5">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <h3 class="panel-title">&nbsp;Select Store Name</h3><br>
                            <select name="store_name" class="form-control selectAggregate selectable"   id="store_id" required>
                            <option value="">Select Store Name</option>
                            @if(Auth::user()->user_type == 'employee')
                                @foreach($store_detail as $store)
                                    <option value="{{$store->store_id}}" @if($editIndent->store_id==$store->store_id) selected @endif>{{$store->getStoreDetail->store_name}}</option>
                                @endforeach
                            @else
                                @foreach($store_detail as $store)
                                    <option value="{{$store->id}}"@if($editIndent->store_id==$store->id) selected @endif>{{$store->store_name}}</option>
                                @endforeach

                            @endif
                            </select>
                            <br>
                            <br>
                        <h3 class="panel-title">Select Material Group</h3><br>
                        <select name="department_data" class="form-control selectable"   id="getMaterialList" class="getMaterialList" >
                            <option value="">Select Material Group</option>
                            @foreach($material_group as $material)
                                <option value="{{$material->id}}">{{$material->group_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" id="updated_indent_id" value="{{$editIndent->indent_id}}" name="updated_id"/>
                    <div class="panel-body">
                        <div class="card col-md-12 ">
                            <div class="table-responsive">  
                                <table class="table table-bordered table-hover search-table" id="freshStoreGroup">
                                    <thead>
                                    <tr class="t-head">
                                        <th>Material Name </th>
                                        <th>Material Unit</th>
                                        <th>Select</th>
                                    </tr>
                                    </thead>
                                    <tbody id="storeGroup">
                                        @foreach($editIndent->indentItems as $data) 
                                        <tr  id="remove_{{$data->getItemDetail->id}}">
                                            <td>{{$data->getItemDetail->material_name}}
                                                <input type="hidden" value=">{{$data->getItemDetail->material_name}}" name="material_name[]"/>
                                            </td>
                                            <td>{{$data->getItemDetail->getUnitDetail->material_unit}}
                                                <input type="hidden" value="{{$data->getItemDetail->getUnitDetail->material_unit}}" name="material_unit[]"/>
                                            </td>
                                            <td>
                                                <input type="checkbox"  class="chkclick" value="" checked disabled="" name="itemDetails" /> 
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

            <div class="col-md-7 show-data">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">&nbsp;Selected Indent Allocation</h3><br>
                    {!! Form::model($project, ['route' => ['indentResorurce.update', $project->id], 'method' => 'post' ]) !!}
                        <input type="hidden" id="updated_id" value="{{$editIndent->id}}" name="updated_id"/>
                    <div class="panel-body">
                        <div class="card col-md-12">
                            <div class="table-responsive">
                                {{ csrf_field() }}
                                <table class="table table-bordered table-hover" id="freshitemRequired" style="margin-top: 50px" >
                                    <thead>
                                    <tr class="t-head">
                                        <th>Material Name </th>
                                        <th>Material Unit</th>
                                        <th>Qty</th>
                                        <th>Remarks (optional)</th>
                                        <th></th>
                                  
                                    </tr>
                                    </thead>


                                    <tbody id="itemRequired"> 
                                        @foreach($editIndent->indentItems as $data) 
                                        <tr  id="remove_{{$data->getItemDetail->id}}">
                                            <td>{{$data->getItemDetail->material_name}}
                                                <input type="hidden" value=">{{$data->getItemDetail->material_name}}" name="material_name[]"/>
                                            </td>
                                            <td>{{$data->getItemDetail->getUnitDetail->material_unit}}
                                                <input type="hidden" value="{{$data->getItemDetail->getUnitDetail->material_unit}}" name="material_unit[]"/>
                                            </td>
                                            <td>
                                                <input type="hidden" value="{{$data->getItemDetail->getGroupDetail->id}}" name="group_id[]"/> 
                                                <input type="hidden" value="{{$data->getItemDetail->id}}" name="item_id[]"/>
                                                
                                                <input type="hidden" value="{{$data->indent_id}}" name="indent_id"/>
                                                <input type="number" class="maty" name="qty[]"  value="{{$data->qty}}" min="1" required /></td>
                                                <input type="hidden" class="store" name="store_id"  value="{{$data->store_id}}" />
                                            </td>
                                            <td>
                                                <input type="text" name="remarks[]" value="{{$data->remarks}}"/>
                                            </td>
                                          
                                            <td>
                                                {!! html_link_to_route('indentResorurce.deleteIndent', '', [$project->id,$data->getItemDetail->id], ['class' => 'btn btn-danger','icon' => 'trash']) !!} 
                                            </td> 
                                                                                  
                                        </tr> 
                                        @endforeach
                                    </tbody>

                                </table >

                         

                            </div>
                        </div>
                                <div  id="button_submit" >
                                    <button type="submit" style="float: right;"  class="btn btn-primary">Submit</button>
                                </div>
                               
                       </div>
                             {!! Form::close() !!}
                        </div>
                      </div>
                    </div>
                </div> 


@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script>

        $(document).ready(function() {





            
            $('#getMaterialList').on('change', function () {
                var group_id = $(this).val();
                var indent_id = $('#updated_indent_id').val();


            
                $.ajax({
                  url: "{{route('indentResorurce.chkItem',[$project->id])}}",
                  type: 'post',
                data: {"group_id": group_id,
                       "indent_id": indent_id,
                      
                "_token": "{{ csrf_token() }}"},
                success: function (data) {


                    
                    $("#freshStoreGroup").DataTable().destroy();
                    $('#storeGroup').html(data);
                    $('#freshStoreGroup').DataTable();
                    

                }

                });

            });
        });

        function doalert(checkboxElem) {

           var  checked_id=checkboxElem.value;
           var store_id   = $('.selectAggregate').children(":selected").val();
   
            if (checkboxElem.checked) {
              
                $(document).on('change','input:checkbox[value="'+checked_id+'"]',function(){
                    $(this).prop('disabled',true);
                });

                $.ajax({
                    url: "{{route('getOneItemList',[$project->id])}}",
                    type: 'post',
                    data: {"item_id": checked_id,
                        "_token": "{{ csrf_token() }}"},
                        
                    success: function (data) {
                        var str = '<tr id="remove_'+data[0].id+'"><td>' + data[0].material_name + '' +
                            '<input type="hidden" value="'+data[0].material_name+'" name="material_name[]"/></td>' +
                            '<td>' + data[0].material_unit + '' +
                            '<input type="hidden" value="'+data[0].material_unit+'" name="material_unit[]"/></td>' +
                            '<td><input type="hidden" value="'+data[0].group_id+'" name="group_id[]"/> ' +
                            '<input type="hidden" value="'+data[0].id+'" name="item_id[]"/>' +
                            '<input type="number" class="maty" name="qty[]" id="qty_id" min="1" required /></td>' +
                            '<input type="hidden" class="store" name="store_id" id="store_id" value="'+store_id+'" /></td>' +
                            '<td><input type="text" name="remarks[]" id="remarks_id"/></td>'+
                            '<td> <button type="button" class="form-control remove-entry btn btn-danger" value='+data[0].id+'><i class="fa fa-trash"></i></button></td>'+
                            '</tr>';

                        $('#itemRequired').append(str);
                       // $('#freshitemRequired').DataTable();
                       // $('#freshitemRequired').DataTable();
                        

                    }
                });
            }
                    else {

                    }
        }

 

         jQuery(document).on('click','.remove-entry',function()
         { 
            var for_remove_slip_details_no =  jQuery(this).val(); 
             
              $('input[type=checkbox]').each(function () 
              {
                       if (this.value==for_remove_slip_details_no) {
                          $(this).removeAttr('checked');
                            this.disabled = false;
                       }
            }); 

               jQuery('#remove_'+for_remove_slip_details_no).remove();
         });

    </script>

@endsection






















