@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-chain" aria-hidden="true"></i></i>&nbsp;{{$service->service_name}} Attribute</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('master.service')}}">Services list</a></li>
                <li><a href="{{route('master.service.attribute.show',$id)}}">Attribute list</a></li>
                <!-- <li><a href="#">list</a></li> -->
            </ul>
        </div>
    </div>
@endsection
@section('content')
@include('includes.msg')
@include('includes.validation_messages')


<div class="row">
    <div class="col-md-12">
        <div class="content-section">
             <button class="btn btn-primary pull-right"  data-toggle="modal" data-target="#myModalServiceAttributeAdd"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add </button> <br><br><br> 
            <div class="  table-responsive ">
                <table class="table table-bordered main-table search-table " >
                    <thead>
                        <tr class="btn-primary">
                            <th>Sr No.</th>
                            <th>Attribute Name</th>
                            <th>Attribute Type</th>
                            <th>Action</th>                            
                        </tr>
                    </thead>
                    <tbody><?php $i=1?>
                    @foreach($attributes as $data)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$data->attribute_name}}</td>
                            <td>{{$data->attribute_type}}</td>
                            <td>&nbsp;<a href="" class="btn show_modal" data-id="{{$data->id}}" data-name='{{$data->attribute_name}}' data-toggle="modal" ><i class="fa fa-edit" style="font-size: 18px;" aria-hidden="true"></i></a>
                                &nbsp;<a href="{{route('master.service.attribute.delete',[$data->id])}}" onclick="return confirm('Are you sure you want to delete?');" class="btn"><i class="fa fa-trash" style="font-size: 18px; color: red;" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="myModalServiceAttributeAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h5 class="modal-title"><i class="fa fa-plus"></i>&nbsp;{{$service->service_name}} Attributes</h5>
            </div>
            <div class="modal-body">
                <div class="form portlet-body ">
                    <form action="{{route('master.service.attribute.add',$id)}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group is-empty">
                            <div class="row">                                                         
                                <div class="form-group">
                                    <label class="control-label col-md-4">Attribute Name</label>
                                    <div class="col-md-8">
                                        <input class="form-control col-md-8" type="text"  name="attribute_name" value="{{old('attribute_name')}}" placeholder="Enter Attribute Name Name">
                                    </div>
                                </div>
                            </div><br>  
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Attribute Type</label>
                                    <div class="col-md-8">
                                        <select name="attribute_type" class="form-control">
                                            <option value ="checkbox">Checkbox</option>
                                            <option value ="text">Text</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12" style="text-align: center;">
                                    <button type="submit" class="btn btn-primary" id="attribute"><i class="fa fa-check">&nbsp;Submit</i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalServiceAttributeEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h5 class="modal-title"><i class="fa fa-edit"></i>&nbsp;{{$service->service_name}} Attributes</h5>
            </div>
            <div class="modal-body">
                <div class="form portlet-body ">
                    <form action="{{route('master.service.attribute.update',$id)}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="update_id" value="" id="attribute_id">
                        <div class="form-group is-empty">
                            <div class="row">                                                         
                                <div class="form-group">
                                    <label class="control-label col-md-4">Attribute Name</label>
                                    <div class="col-md-8">
                                        <input class="form-control col-md-8 " type="text" id="attribute_name" name="attribute_name" value="" placeholder="Enter Attribute Name Name">
                                    </div>
                                  </div>
                            </div><br>  
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Attribute Type</label>
                                    <div class="col-md-8">
                                        <select name="attribute_type" class="form-control">
                                            <option value ="checkbox">Checkbox</option>
                                            <option value ="text">Text</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12" style="text-align: center;">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check">&nbsp;Update</i></button>
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
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.show_modal').on('click',function(){
            var name=jQuery(this).data('name');
            var id=jQuery(this).data('id');
            jQuery('#attribute_name').val(name);
            jQuery('#attribute_id').val(id);
            jQuery('#myModalServiceAttributeEdit').modal('show');
        });

        jQuery('#attribute').on('click',function(){
            jQuery('#myModalServiceAttributeAdd').modal('show');
        });
    });
</script>
@endsection

