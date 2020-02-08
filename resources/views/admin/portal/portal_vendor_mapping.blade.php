
@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Portal Management</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('portal')}}">Users list</a></li>
                <!-- <li><a href="#">list</a></li> -->
            </ul>
        </div>
    </div>
@endsection
@section('content')
@include('includes.msg')
@include('includes.validation_messages')
<div class="row">
    <div class="col-md-5">
        <div class="content-section">
            <div class="  table-responsive ">
                <table class="table table-bordered main-table search-table " >
                    <thead>
                        <tr class="t-head">
                            <th>Portal List</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($portal_list as $value)
                        <tr>
                            <td class="table-text link-color" >
                              <a href="{{ route('Getvendoritem', $value->id) }}" class="link-color">{{$value->company_name}}</a>
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>


    <div class="col-md-7">
        <div class="content-section">
            <div class="  table-responsive ">
                <table class="table table-bordered main-table search-table">
                    <thead>
                        <tr class="t-head">
                            <th>Company Name</th>
                            <th>Supplier</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody> 
                      @foreach($vendor as $value)
                        <tr>
                            <td>{{$value->company_name}}</td>
                            <td><?php 
                                $vendor_material_ids =  explode(',', $value->supplier_of);
                                $vendorData = $value->getMaterial($vendor_material_ids); 
                            ?>
                            @foreach($vendorData as $Supp_list)       
                                    {{$Supp_list->group_name}}<b>,</b>
                            @endforeach </td>
                            <td>{{$value->address}}</td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection

<!-- Matereal management Of Client BLOCK -->