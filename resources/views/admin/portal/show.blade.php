@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i>&nbsp;Portal Management</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('portal')}}">Users List</a></li>
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
                <li role="presentation" class="active"><a  aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-home"></i>  <span>Portal Info</span></a></li>
            </ul>
        </div><br>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Name&nbsp;:</th><td>&nbsp;{{$portal_show_values->name}}</td>
                                </tr>
                                <tr>
                                    <th>Surname&nbsp;:</th><td>&nbsp;{{$portal_show_values->surname}}</td>
                                </tr>
                                <tr>
                                    <th>Mobile&nbsp;:</th><td>&nbsp;{{$portal_show_values->mobile}}</td>
                                </tr>
                                <tr>
                                    <th>Mobile Other&nbsp;:</th><td>&nbsp;{{$portal_show_values->other_mobile}}</td>
                                </tr>

                                <tr>
                                    <th>Address&nbsp;:</th><td>&nbsp;{{$portal_show_values->address}}</td>
                                </tr>


                                <?php $state_name = DB::table('vishwa_states')->where('id',$portal_show_values->state)->first();?>

                                <tr>
                                    <th>State&nbsp;:</th><td>&nbsp;{{$state_name->name}}</td>
                                </tr>

                                <tr>
                                    <th>State Code&nbsp;:</th><td>&nbsp;{{$portal_show_values->state_code}}</td>
                                </tr>

                                <tr>
                                    <th>GSTIN/UIN&nbsp;:</th><td>&nbsp;{{$portal_show_values->gstn_uin}}</td>
                                </tr>
                                <tr>
                                    <th>CIN&nbsp;:</th><td>&nbsp;{{$portal_show_values->cin}}</td>
                                </tr>

                                <tr>
                                    <th>Email&nbsp;:</th><td>&nbsp;{{$email}}</td>
                                </tr>
                                <tr>

                                    @if($portal_show_values->logo_img)
                                    <th>logo&nbsp;:</th><td>&nbsp;<img src="{{my_asset('/uploads/portal_images/'.$portal_show_values->logo_img)}}" class="img-circle" style="height: 150px;width: 150px" alt="User Image"/></td>
                                    @else
                                        <th>logo&nbsp;:</th><td>&nbsp;<img src="{{my_asset('/uploads/portal_images/default.jpg')}}" class="img-circle" style="height: 150px;width: 150px" alt="User Image"/></td>
                                    @endif

                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Company Name&nbsp;:</th><td>&nbsp;{{$portal_show_values->company_name}}</td>
                                </tr>

                                <tr>
                                    <th>Contact person&nbsp;:</th><td>&nbsp;{{$portal_show_values->contact_person}}</td>
                                </tr>
                                <tr>
                                    <th>Company Email&nbsp;:</th><td>&nbsp;{{$portal_show_values->company_mail}}</td>
                                </tr>
                                <tr>
                                    <th>Company Phone&nbsp;:</th><td>&nbsp;{{$portal_show_values->company_mobile}}</td>
                                </tr>
                                <tr>
                                    <th>Company Address&nbsp;:</th><td>&nbsp;{{$portal_show_values->company_address}}</td>
                                </tr>
                                <tr>
                                    <th>Company's VAT TIN&nbsp;:</th><td>&nbsp;{{$portal_show_values->vat_tin}}</td>
                                </tr>
                                <tr>
                                    <th>Company's CST No&nbsp;:</th><td>&nbsp;{{$portal_show_values->cst_no}}</td>
                                </tr>
                                <tr>
                                    <th>Company's Service Tax No&nbsp;:</th><td>&nbsp;{{$portal_show_values->service_tax_no}}</td>
                                </tr>
                                <tr>
                                    <th>Company's PAN&nbsp;:</th><td>&nbsp;{{$portal_show_values->pan}}</td>
                                </tr>
                                <tr>
                                    <th>Status&nbsp;:</th><td>&nbsp;@if($portal_show_values->status==1)
                                    <img src="{{ my_asset('images/activate.png') }}">
                                @else
                                    <img class="change_status"  data-id={{$row->id}} src="{{my_asset('images/deactivate.png')}}">
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
