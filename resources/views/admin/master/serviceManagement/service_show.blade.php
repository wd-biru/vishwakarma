@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i>&nbsp;Service Management</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('portal')}}">Service Info</a></li>
                <li><a href="#">View</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
@include('includes.msg')
@include('includes.validation_messages')


<div class="mytabs">
    <div class="cardtb">
        <div class="tabshorizontal">
            <ul class="nav nav-tabs" role="tablist">

                <li><a href="{{route('servicemoreinfo')}}" aria-controls="home"><i class="fa fa-home"></i>  <span>More Info</span></a></li>
                <li><a href="{{route('projectmoreinfo')}}" aria-controls="home" ><i class="fa fa-building"></i>  <span>Projects Info</span></a></li>
                <li ><a href="{{route('documentmoreinfo')}}" aria-controls="home" ><i class="fa fa-file"></i>  <span>Documents Info</span></a></li>
            </ul>
        </div><br>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Name&nbsp;:</th><td>&nbsp;{{$viewInfo->contact_name}}</td>
                                </tr>
                                <tr>
                                    <th>Surname&nbsp;:</th><td>&nbsp;{{$viewInfo->company_name}}</td>
                                </tr>
                                <tr>
                                    <th>Phone No.&nbsp;:</th><td>&nbsp;{{$viewInfo->phone_no}}</td>
                                </tr>
                                <tr>
                                    <th>Mobile No.r&nbsp;:</th><td>&nbsp;{{$viewInfo->mobile}}</td>
                                </tr>

                                <tr>
                                    <th>Website&nbsp;:</th><td>&nbsp;{{$viewInfo->website}}</td>
                                </tr>
                                <tr>
                                    <th>Email&nbsp;:</th><td>&nbsp;{{$viewInfo->email}}</td>
                                </tr>
                                <tr>
                                    <th>logo&nbsp;:</th><td>&nbsp;<img src="{{getPortalImageUrl($viewInfo->logo_img)}}" class="img-circle" style="height: 150px;width: 150px" alt="User Image"/></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Company Name&nbsp;:</th><td>&nbsp;{{$viewInfo->company_name}}</td>
                                </tr>

                                <tr>
                                    <th>Contact person&nbsp;:</th><td>&nbsp;{{$viewInfo->conatct_name}}</td>
                                </tr>
                                <tr>
                                    <th>Company Email&nbsp;:</th><td>&nbsp;{{$viewInfo->company_mail}}</td>
                                </tr>
                                <tr>
                                    <th>Company Phone&nbsp;:</th><td>&nbsp;{{$viewInfo->company_mobile}}</td>
                                </tr>
                                <tr>
                                    <th>Company Address&nbsp;:</th><td>&nbsp;{{$viewInfo->company_address}}</td>
                                </tr>
                                <tr>
                                    <th>Status&nbsp;:</th><td>&nbsp;@if($viewInfo->status==1)
                                    <img src="{{ my_asset('images/activate.png') }}">
                                @else
                                    <img class="change_status"  data-id="0" src="{{my_asset('images/deactivate.png')}}">
                                @endif</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
