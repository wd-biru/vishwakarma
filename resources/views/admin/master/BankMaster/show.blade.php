@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-bank" aria-hidden="true"></i></i>&nbsp;Bank Master</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('bankMaster.index')}}">Bank Master</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')


<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plus"></i> Show Bank Info</h3></div>
            <div class="panel-body">
                @include('includes.msg')
                @include('includes.validation_messages')

                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data"> 
                        {{ csrf_field() }}
                       
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body"> 
                                    <fieldset>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Bank Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="bank_name"  placeholder="Bank Name" readonly=""  value="{{ $bankmaster->bank_name}}">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">IFSC Code&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="ifsc_code" placeholder="IFSC Code" readonly=""  value="{{ $bankmaster->ifsc_code}}">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Pincode&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="number" name="pincode" id="pincode" placeholder="Pincode" readonly="" value="{{ $bankmaster->pincode}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Address&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <textarea class="form-control" name="address" placeholder="Enter Address" readonly="">{{ $bankmaster->address}}</textarea>
                                        </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card"   >
                                <div class="card-body">
                                    <fieldset>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">District&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="district" placeholder="District" readonly="" value="{{ $bankmaster->district}}" >
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">City&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="city_name" class="form-control" id="city_name" placeholder="Enter City Name" readonly="" value="{{ $bankmaster->city}}">
                                                <div id="city_name_list"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">State&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="state_name" class="form-control" id="state_name" placeholder="Enter State Name"  readonly="" value="{{ $bankmaster->state}}">
                                                <div id="state_name_list"></div>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="control-label col-md-4">Country&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="country_name" id="country_name" placeholder="Enter Country Name" readonly="" value="{{ $bankmaster->country}}">
                                                <div id="country_name_list"></div>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Status&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="status" required="" disabled="">
                                                    <option>--select status--</option>
                                                    <option value="1" @if($bankmaster->status == 1) selected @endif >Active</option>
                                                    <option value="0" @if($bankmaster->status == 0) selected @endif >DeActive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                           
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

@section('script')



@endsection