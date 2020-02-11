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

                    <form class="form-horizontal" action="{{route('itemTypeUpdate')}}" method="post" >
                         <input class="form-control" type="hidden" name="id" value="{{$GroupType->id}}">
                        {{ csrf_field() }}
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body"> 
                                    <fieldset>
         
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-2">Item Group Type Name*&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-6">
                <input class="form-control" type="text" name="group_type_name" required=""  value="{{$GroupType->group_type_name}}">
                                        </div>
                                        </div>
                                        
                                         
                                        </div>
                                        <div class="form-group">
                                          <div class="col-sm-8">
                                            <button type="submit"  class="btn btn-primary pull-right"><i class="fa fa-save"></i>Update</button>
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