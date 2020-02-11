@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Store Details</h1>
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
        .status {
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

                            <label style="margin-left: 21%">Select Group Type</label>&nbsp;&nbsp;&nbsp;


                            <select class=" form-control " id="get_materialGroupBy_itemType">

                                <option value="">select Group Type</option>
                                @foreach($group_type as  $row)
                                    <option value="{{$row->id}}">{{$row->group_type_name}}</option>
                                @endforeach

                            </select>


                            <label style="margin-left: 21%">Material Group</label>&nbsp;&nbsp;&nbsp;
                            <select name="group_id" class="form-control" id="getMaterialList"
                                    style="padding-bottom: 9px;margin-bottom: 18px;">
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
                $(document).ready(function () {
                    $('#getMaterialList').on('change', function () {
                        var group_id = $(this).val();
                        var group_type_id = $('#get_materialGroupBy_itemType option:selected').val();

                        $.ajax({
                            url: "{{route('masterStore.getItemList')}}",
                            type: 'get',
                            data: {
                                "group_id": group_id,
                                "group_type_id": group_type_id,
                                "store_id":"{{$store_id}}"
                            },
                            datatype: 'html',
                            success: function (data) {
                                $("#itemListGroup").DataTable().destroy();
                                $('#getListItem').html(data);
                                $("#itemListGroup").DataTable({
                                    "aLengthMenu": [100]
                                });
                                jQuery('.datepicker').datepicker({
                                    format: 'dd/mm/yyyy',
                                    autoclose: true,
                                    todayHighlight: true,
                                });

                            }
                        });
                    });

                    $('#get_materialGroupBy_itemType').on('change', function () {

                        var group_type_id = $(this).val();

                        $.ajax({
                            url: "{{route('getMaterialGroup')}}",
                            type: 'post',
                            data: {
                                "group_type_id": group_type_id,
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data) {

                                $("#getMaterialList").empty();
                                $("#getMaterialList").append('<option name="">Select Material Group</option>');
                                $.each(data, function (key, value) {
                                    $("#getMaterialList").append('<option value="' + key + '">' + value + '</option>');
                                });
                            }


                        });
                    });


                });


            </script>
    </div>
@endsection






















