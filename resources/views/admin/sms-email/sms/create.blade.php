@extends('layout.app')
@section('title')
<div class="page-title">
    <div class="div">
        <h1><i class="fa fa-laptop"></i>Sms Setting</h1>
    </div>
    <div class="div">
        <ul class="breadcrumb">
            <li><i class="fa fa-home fa-lg"></i></li>
            <li><a href="#">Sms Setting</a></li>
        </ul>
    </div>
</div>
@endsection
@section('content')
@include('includes.msg')

<div class="mytabs">
    <div class="cardtb">
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <div class="row">
                    <form class="form-horizontal" action="{{route('sms.store')}}" method="post">
                        {{ csrf_field() }}
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-body"> 
                                 <legend>SMS</legend>
                                    <fieldset><br>    
                                        <div class="form-group">
                                            <label class="control-label col-md-2">To&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-10">
                                            <strong><input class="form-control" type="text" name="to" value="@foreach($mobile_data as $data){{$data}};@endforeach @if(!empty($alternate_data))@foreach($alternate_data as $data){{$data}};@endforeach @endif" placeholder="Enter contact" style="text-transform: capitalize"></strong>
                                        </div>
                                        </div> 
                                        <div class="form-group">
                                            <label class="control-label col-md-2">Sms&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-10">
                                         	<textarea class="form-control" placeholder="enter sms" name="composed_sms" style="height: 80px;"></textarea>
                                        </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit_btn" class="btn btn-primary pull-right">Send</button>
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
