@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Vendor Price</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="#">Vendor Price</a></li>
                <li><a href="#">Add</a></li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
@include('includes.msg')
@include('includes.validation_messages')
<style type="text/css">
    .status{
        width: 15px;
        background: none;
        color: inherit;
        border: none;
        padding: 0;
        font: inherit;
        cursor: pointer;
        outline: inherit;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">&nbsp;Material List</h3>
            </div>
            <div class="panel-body">
                <div class="card col-md-12 ">
                    
                       {{ csrf_field() }}
                                         
                        <label style="margin-left: 21%">Material Group</label>&nbsp;&nbsp;&nbsp;
                        <select name="group_id" class="form-control" id="getMaterialList" style="padding-bottom: 9px;margin-bottom: 18px;">

                            <option value="">Select Material Group</option>
                            @foreach($vendor_material_group as $material)
                                <option value="{{$material->id}}">{{$material->group_name}}</option>
                            @endforeach
                        </select>  
            
                        <div class="table-responsive" id="getListItem">   


                            
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') 
    <script> 
        $(document).ready(function() {
            $('#getMaterialList').on('change', function () {
                var group_id = $(this).val();
                $.ajax({
                    url: "{{route('vendorListPrice')}}",
                    type: 'post',
                    data: {"group_id": group_id,
                        "_token": "{{ csrf_token() }}"},
                    datatype: 'html',
                    success: function (data) {                 
                        $("#freshStoreGroup").DataTable().destroy();  
                        $('#getListItem').html(data);
                        $('#freshStoreGroup').DataTable();

                    }
                });
            });
        });
        
    </script>

@endsection






















