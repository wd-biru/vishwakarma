@extends('layout.project')

@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>&nbsp;Indent Allocation</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li>{{ link_to_route('projects.index',trans('project.projects'), ['status_id' => request('status_id', $project->status_id)]) }}</li>
                <li>{{ $project->present()->projectLink }}</li>
                <li><a href="#">Indent Allocation </a></li>
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

                            <select name="store_name" class="form-control store selectable" required>
                                <option value="">Select Store Name</option> 
                             @if(Auth::user()->user_type == 'employee')
                                @foreach($store_detail as $store)
                                    
                                    <option value="{{$store->store_id}}">{{$store->store_name}}</option>
                                @endforeach
                            @else
                                @foreach($store_detail as $store)
                                    <option value="{{$store->id}}">{{$store->store_name}}</option>
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
                    {!! Form::model($project, ['route' => ['indentResorurce.store', $project->id], 'method' => 'post' ]) !!}
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
                $.ajax({
                    url: "{{route('getItemList',[$project->id])}}",
                    type: 'post',
                    data: {"group_id": group_id,                      
                    "_token": "{{ csrf_token() }}"},
                    success: function (data) { 
                        $("#freshStoreGroup").DataTable().destroy();

            
                    var table_body = '<table border="1">';
                    for(var i=0;i<data.length;i++)
                    {

                        table_body+='<tr>';
                            table_body +='<td>';
                            table_body +=' <input type="hidden" name="'+data[i].group_id+'" id="group_id"/>';
                            table_body +=' <input type="hidden" name="'+ data[i].id +'" id="req_item_id"/>';
                            table_body +=' <label  id="mat_name" />'+data[i].material_name+'</label>';
                            table_body +='</td>';

                        table_body +='<td>';
                        table_body +='<label  id="mat_unit"/>'+data[i].material_unit+'</label>';
                        table_body +='</td>';

                        table_body +='<td>';
                        table_body +=' <input type="checkbox" onchange="doalert(this);" class="chkclick" value="'+data[i].id+'"name="itemDetails" id="chkListItem" />';
                        table_body +='</td>';

                        table_body+='</tr>';
                    }
                    table_body+='</table>';
                    $('#storeGroup').html(table_body);
                    $('#freshStoreGroup').DataTable();
                    

                }

                });

            });
        });

        function doalert(checkboxElem) {
           
           var  checked_id=checkboxElem.value;
           var store_id   = $('.store option:selected').val();  
            if (checkboxElem.checked) {
              // $("#freshitemRequired").DataTable();
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






















