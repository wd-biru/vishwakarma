@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Man Power</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('manPower.index')}}">Man Power</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')


<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plus"></i> Edit Man Power</h3></div>
            <div class="panel-body">
                @include('includes.msg')
                @include('includes.validation_messages')

                    <form class="form-horizontal" action="{{route('manPower.update',[$manPower->id])}}" method="post" enctype="multipart/form-data"> 
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body"> 
                                    <fieldset>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Man Power Type:&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Enter Man Power" name="man_power_type" required="" value="{{$manPower->man_power_type}}">
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit_btn" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
                                        </div>
                                    </div>
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

