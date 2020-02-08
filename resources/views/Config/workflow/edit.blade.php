
@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-building"></i>&nbsp;Config <b>{{$WorkFlow->name}}</b> Work Flow</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('company')}}">Config</a></li>
                <li><a href="#">Config {{$WorkFlow->name}} Work Flow</a></li>
            </ul>
        </div>
    </div>

@endsection
@section('content')


    <div class="mytabs">
        <div class="cardtb">             
            @include('includes.validation_messages')
                @include('includes.msg')
            <div class="row"> 
                <div class="col-md-6"> 
                    <pre>  
                    <?php print_r(json_encode($WorkFlowDaigram,JSON_PRETTY_PRINT)) ; ?>
                </div> 
                <div class="col-md-6"> 
                    <center>
                        <hr> 
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" data-toggle="modal" data-target="#addPlace" class="btn btn-primary ">Add Place</button>
                            </div>

                            <div class="col-md-6">
                                @if($WorkFlow->getPlace->count()>0)
                                <button type="button"  data-toggle="modal" data-target="#upadatePlace" class="btn btn-primary ">Update Place</button>
                                @endif
                            </div>
                        </div>
                        <hr>
                        @if($WorkFlow->getPlace->count()>0)
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button"  data-toggle="modal" data-target="#addTrans" class="btn btn-primary ">Add Trans</button>
                            </div>
                             <div class="col-md-6">
                                @if($WorkFlow->getTransaction->count()>0)
                                <button type="button"  data-toggle="modal" data-target="#upadateTrans" class="btn btn-primary ">Update Trans</button>
                                @endif
                            </div> 
                        </div>
                        @endif
                         <hr>
                        @if($WorkFlow->getPlace->count()>0)
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button"  data-toggle="modal" data-target="#addemp" class="btn btn-primary ">Add Employees </button>
                            </div>
 
                        </div>
                        @endif
                    </center>
                </div>  
            </div>
        </div> 
    </div>
    <div class="modal fade" id="addPlace" role="dialog">
        <div class="modal-dialog">  
            <div class="modal-content">
                <form class="form-horizontal" action="{{route('workflow.update',$WorkFlow->id)}}" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><b>{{$WorkFlow->name}}</b> Places/stages Add</h4>
                    </div>
                         {{ csrf_field() }}
                    <div class="modal-body">
                        <table class="table table-bordered ">
                            <thead class="btn-primary">
                                <tr>
                                    <th>Name</th> 
                                    <th>Add More</th>
                                </tr>
                            </thead>
                            <tbody id="id-append-new-tr">
                                <tr>
                                    <td><input class="form-control" type="text" name="place_name" id="place_name" placeholder="Stage Name" ></td>
                                    <td><a id="addmore" class="btn btn-success"> +</a></td>
                                </tr>

                            </tbody>
                        </table> 
                    </div>
                    <div class="modal-footer">         
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>  
    <div class="modal fade" id="addTrans" role="dialog">
        <div class="modal-dialog">  
            <div class="modal-content">
                <form class="form-horizontal" action="{{route('workflow.update',$WorkFlow->id)}}" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{$WorkFlow->name}}</b> Transaction Add</h4>
                    </div>
                         {{ csrf_field() }}
                    <div class="modal-body">
                         <table class="table table-bordered ">
                            <thead class="btn-primary">
                                <tr>
                                    <th>Name</th> 
                                    <th>From Place/Stages</th> 
                                    <th>To Place/Stages</th> 
                                    <th>Add More</th> 
                                </tr>
                            </thead>
                            <tbody id="id-append-new-tr-trans">
                                <tr>
                                    <td><input class="form-control" type="text" id="trans_name" placeholder="Stage Name" ></td>
                                    <td>
                                        <select  class="form-control" type="text" id="trans_from_id">
                                              <option value="">--select from--</option>
                                             @foreach($WorkFlow->getPlace as $list)
                                              <option value="{{$list->id}}">{{$list->place_name}}</option>
                                             @endforeach
                                        </select>
                                        
                                    </td>
                                    <td>
                                        <select  class="form-control" type="text" id="trans_to_id">
                                                <option value="">--select to-- </option>
                                             @foreach($WorkFlow->getPlace as $list)
                                                <option value="{{$list->id}}">{{$list->place_name}}</option>
                                             @endforeach
                                        </select>
                                         
                                    </td> 
                                    <td><a id="addmoreTrans" class="btn btn-success"> +</a></td>
                                </tr>
                            </tbody>
                        </table> 
                    </div>
                    <div class="modal-footer">         
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>  
    </div>  
    @if($WorkFlow->getPlace->count()>0)
    <div class="modal fade" id="upadatePlace" role="dialog">
        <div class="modal-dialog">  
            <div class="modal-content">
                <form class="form-horizontal" action="{{route('workflow.update',$WorkFlow->id)}}" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{$WorkFlow->name}}</b> Places/stages Update</h4>
                    </div>
                         {{ csrf_field() }}
                    <div class="modal-body">
                        <table class="table table-bordered ">
                            <thead class="btn-primary">
                                <tr>
                                    <th>Name</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($WorkFlow->getPlace as $value)
                                <tr>
                                    <td>
                                        <input type="hidden" name="place_update_id[]" value="{{$value->id}}"  >
                                        <input class="form-control" type="text" name="place_name[]" required="" value="{{$value->place_name}}" placeholder="Stage Name" ></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table> 
                    </div>
                    <div class="modal-footer">         
                        <button type="submit" class="btn btn-primary">update</button>
                    </div>
                </form>
            </div>
        </div>  
    </div>  
    @endif

    @if($WorkFlow->getTransaction->count()>0)
    <div class="modal fade" id="upadateTrans" role="dialog">
        <div class="modal-dialog">  
            <div class="modal-content">
                <form class="form-horizontal" action="{{route('workflow.update',$WorkFlow->id)}}" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{$WorkFlow->name}}</b> Transaction Update</h4>
                    </div>
                         {{ csrf_field() }}
                    <div class="modal-body">
                        <table class="table table-bordered ">
                            <thead class="btn-primary">
                                <tr>
                                    <th>Name</th> 
                                    <th>From Place/Stages</th> 
                                    <th>To Place/Stages</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($WorkFlow->getTransaction as $value)
                                <tr>
                                    <td>
                                        <input type="hidden" name="trans_update_id[]" value="{{$value->id}}"  >
                                        <input class="form-control" type="text" name="trans_name[]" required="" value="{{$value->trans_name}}">
                                    </td>
                                    <td>
                                        <select  class="form-control" type="text" name="trans_from_id[]">
                                             @foreach($WorkFlow->getPlace as $list)
                                              <option @if($list->id==$value->getPlaceFrom->id) selected @endif value="{{$list->id}}">{{$list->place_name}}</option>
                                             @endforeach
                                        </select>
                                        
                                    </td>
                                    <td>
                                        <select  class="form-control" type="text" name="trans_to_id[]">
                                             @foreach($WorkFlow->getPlace as $list)
                                                <option @if($list->id==$value->getPlaceTo->id) selected @endif value="{{$list->id}}">{{$list->place_name}}</option>
                                             @endforeach
                                        </select>
                                         
                                    </td> 
                                </tr>
                                @endforeach
                            </tbody>
                        </table> 
                    </div>
                    <div class="modal-footer">         
                        <button type="submit" class="btn btn-primary">update</button>
                    </div>
                </form>
            </div>
        </div>  
    </div>  
    @endif
 

 @if($WorkFlow->getTransaction->count()>0)
    <div class="modal fade" id="addemp" role="dialog">
        <div class="modal-dialog">  
            <div class="modal-content">
                <form class="form-horizontal" action="{{route('workflow.update',$WorkFlow->id)}}" method="post">
                    <input type="hidden" name="emp" value="emp_list"  >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{$WorkFlow->name}}</b> Add Employee</h4>
                    </div>
                         {{ csrf_field() }}
                    <div class="modal-body">
                        <table class="table table-bordered ">
                            <thead class="btn-primary">
                                <tr>
                                    <th>Name</th> 
                                    <th>From Place/Stages</th> 
                                    <th>To Place/Stages</th> 
                                    <th>Assign Employee</th>
                                </tr>
                            </thead>
                            <tbody>
                                        <?php    $i=0;               ?>
                                @foreach($WorkFlow->getTransaction as $value)
                                <tr>
                                    <td >
                                        <input type="hidden" name="trans_id[]" value="{{$value->id}}"  >
                                        <input class="form-control" type="text" readonly=""  required="" value="{{$value->trans_name}}">

                                        <input type="hidden"  name="trans_name[]"  value="{{$value->id}}">

                                         
                                    </td>
                                    <td  >
                                        <select  class="form-control" type="text" readonly="" name="trans_from_id[]">
                                             @foreach($WorkFlow->getPlace as $list)
                                              <option @if($list->id==$value->getPlaceFrom->id) selected @endif value="{{$list->id}}">{{$list->place_name}}</option>
                                             @endforeach
                                        </select>
                                        
                                    </td>
                                    <td  >
                                        <select  class="form-control" type="text" readonly="" name="trans_to_id[]">
                                             @foreach($WorkFlow->getPlace as $list)
                                                <option @if($list->id==$value->getPlaceTo->id) selected @endif value="{{$list->id}}">{{$list->place_name}}</option>
                                             @endforeach
                                        </select>
                                         
                                    </td>
                                    <td>
                                
                                        <select  class="form-control emp_list" type="text" readonly=""  multiple="" name="{{$i++}}emp[]">
                                           
                                             @foreach($emp_list as $list)
    <option @foreach($emp_mapping as $emp_map) @if($emp_map->emp_id==$list->id && $emp_map->Workflow_place_id==$value->id) selected @endif    @endforeach value="{{$list->id}}">{{$list->first_name}} {{$list->last_name}}</option>
                                             @endforeach
                                                 <option value="vendor">Vendor</option>
                                        </select>
                                         
                                    </td>  
                                </tr>
                                @endforeach
                            </tbody>
                        </table> 
                    </div>
                    <div class="modal-footer">         
                        <button type="submit" class="btn btn-primary">update</button>
                    </div>
                </form>
            </div>
        </div>  
    </div>  
    @endif


@endsection

@section('script')
<script type="text/javascript">

    $('.emp_list').select2({
                    width:'210px',
                    tags: true,
                    tokenSeparators: [','],
                    placeholder: "Employees List"
                });
     
    jQuery(function(){
        var vil={
            init:function(){ 
                jQuery(document).on('click','.remove-entry',function(){   
                    var place_ =  jQuery(this).val(); 
                    jQuery('#place_'+place_).remove();               
                });
                jQuery(document).on('click','#addmore',function(){ 
                    var place_name = $('#place_name').val()
                    if(place_name){
                        vil.appendRow(place_name);
                        $('#place_name').val("");
                    }
                }); 
                jQuery(document).on('click','.remove-entry-trans_name',function(){   
                    var trans_name =  jQuery(this).val(); 
                    jQuery('#trans_name'+trans_name).remove();               
                });
                jQuery(document).on('click','#addmoreTrans',function(){ 
                    var trans_name = $('#trans_name').val()
                    var trans_from_id = $('#trans_from_id').val()
                    var trans_to_id = $('#trans_to_id').val()
                    if(trans_name && trans_from_id && trans_to_id ){
                        vil.appendRowTrans(trans_name);
                        $('#trans_name').val("");
                        $('#trans_from_id').val("")
                        $('#trans_to_id').val("")
                    }
                }); 
            },

            appendRow:function(place_name){
                var tr = "<tr id='place_"+place_name+"'>" +
                        "<td><input class='form-control' name='place_name[]' value="+place_name+"  type='hidden'/>"+place_name+"</td>"+
                        "<td><a class='remove-entry btn btn-danger' value="+place_name+"><i class='fa fa-trash'></i></a></td>"+             
                    "</tr>";
                jQuery('#id-append-new-tr').append(tr); 

            }, 
            appendRowTrans:function(trans_name){
                var trans_from_id = $('#trans_from_id').val();
                var trans_from_html = $('#trans_from_id option:selected').text();
                var trans_to_id = $('#trans_to_id').val();
                var trans_to_html = $('#trans_to_id option:selected').text();
                var tr = "<tr id='trans_name"+trans_name+"'>" +
                        "<td><input class='form-control' name='trans_name[]' value="+trans_name+"  type='hidden'/>"+trans_name+"</td>"+
                        "<td><input class='form-control' name='trans_from_id[]' value="+trans_from_id+"  type='hidden'/>"+trans_from_html+"</td>"+
                        "<td><input class='form-control' name='trans_to_id[]' value="+trans_to_id+"  type='hidden'/>"+trans_to_html+"</td>"+
                        "<td><a class='remove-entry-trans_name btn btn-danger' value="+trans_name+"><i class='fa fa-trash'></i></a></td>"+             
                    "</tr>";
                jQuery('#id-append-new-tr-trans').append(tr); 

            }, 
        }
        vil.init();
    });
</script>
@endsection
