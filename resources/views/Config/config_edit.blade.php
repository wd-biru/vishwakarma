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
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plus"></i> Config Edit</h3></div>
            <div class="panel-body">
                @include('includes.msg')
                @include('includes.validation_messages')

                    <form class="form-horizontal" action="{{route('config.update')}}" method="post" >
                         <input class="form-control" type="hidden" name="id" value="{{$VishwaAdminConfigs->id}}">
                        {{ csrf_field() }}
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body"> 
                                    <fieldset>
         
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-2">Field Label&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-6">
                <input class="form-control" type="text" name="field_label" required=""  value="{{$VishwaAdminConfigs->field_label}}">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-2">Field Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-6">
            <input class="form-control" type="text" name="field_name" required="" value="{{$VishwaAdminConfigs->field_name}}" placeholder="Company Name">
                                        </div>
                                        </div>
                                      
                                       <div class="form-group">
                                            <label class="control-label col-md-2">Input Type&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-6">
                <input class="form-control" type="text"  required="" value="{{$VishwaAdminConfigs->input_type}}" name="input_type" id="input_type" >
                                        </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-2">Option&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-6">
                                            <input class="form-control" required="" type="text" value="{{$VishwaAdminConfigs->option}}" name="option" id="option"  > 
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-2">Value</label>
                                            <div class="col-md-6">
                    <input class="form-control" type="text" required="" value="{{$VishwaAdminConfigs->value}}" name="value" id="value"   >
                                        </div>
                                        </div>
                                                                      
                                        <div class="form-group">
                                            <label class="control-label col-md-2">Config Order&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-6">
                        <input type="Number" class="form-control" required="" name="config_order" value="{{$VishwaAdminConfigs->config_order}}">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-2">Category&nbsp;<span style="color: #f70b0b">*</span></label>
                                          <div class="col-sm-6">
                                             <input type="text" required="" class="form-control" name="category" value="{{$VishwaAdminConfigs->category}}">
                                          </div>
                                        </div>
                                         
                                        </div>
                                        <div class="form-group">
                                          <div class="col-sm-8">
                                            <button type="submit" id="submit_btn" class="btn btn-primary pull-right"><i class="fa fa-save"></i>Update</button>
                                            </div>
                                        </div>
                                    </fieldset>
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
  
</script>
@endsection