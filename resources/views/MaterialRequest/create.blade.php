@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-suitcase" aria-hidden="true"></i></i>&nbsp;Material Request</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="#"><i class="fa fa-home fa-lg"></i></a></li>

                <li><a href="{{route('materialRequest.index')}}">Material Request</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
    @if(Session::has('error_message'))
        <p class="alert alert-danger" style="font-size: 16px;">{{ Session::get('error_message') }}</p>
    @endif
    @if(Session::has('success_message'))
        <p class="alert alert-success" id="msg" style="font-size: 16px;">{{ Session::get('success_message') }}</p>
    @endif
    @if(Session::has('message'))
        <p class="alert alert-info" style="font-size: 16px;">{{ Session::get('message') }}</p>
    @endif
    @include('includes.validation_messages')

    <div class="row">
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">&nbsp;Select Project Name</h3><br>
                    <select name="project_name" id="get_store_name_by_project"
                            class="form-control get_store_name_by_project selectable" required>
                        <option value="">Select Project</option>
                        @foreach($projects as $project)
                            <option value="{{$project->id}}">{{$project->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="panel-heading hide_store_div">
                    <h3 class="panel-title">&nbsp;Select Store Name</h3><br>
                    <select name="store_name" class="form-control store selectable" id="store_name" required>
                        <option value="">Select Store Name</option>

                    </select>
                    <br><br>
                </div>
                <div class="panel-heading hide_store_div">
                    <h3 class="panel-title">&nbsp;Select Tower Name</h3><br>
                    <select name="tower_name" class="form-control store selectable" id="tower_name" required>
                        <option value="">Select Tower Name</option>
                    </select>
                    <br><br>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="panel-heading hide_store_div">
                            <h3 class="panel-title">&nbsp;Material Name</h3><br>
                            <input type="text" name="material_name" data-unit="" value="" data-id=""
                                   class="form-control" id="material_name" placeholder="Enter Material Name" readonly>
                            <div id="auto_material_list"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel-heading hide_store_div">
                            <h3 class="panel-title">&nbsp;Qty</h3><br>
                            <input type="number" name="qty" class="form-control" id="qty_list" readonly >

                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="panel-heading">
                            <h3 class="panel-title"></h3><br><br>
                            <button type="button" class="form-control btn btn-primary" id="add_button"
                                    onclick="doalert(this);" ><i class="fa fa-plus"></i></button>
                            <br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7 show-data">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form action="{{route('materialRequestStore')}}" method="post">
                    <h3 class="panel-title">&nbsp;Selected Material Request</h3><br>
                    <!-- !! Form::model(project, ['route' => ['indentResorurce.store', project->id], 'method' => 'post' ]) !!} -->
                    <div class="panel-body">
                        <div class="card col-md-12">
                            <div class="table-responsive">
                                {{ csrf_field() }}
                                <table class="table table-bordered table-hover" id="freshItemRequired"
                                       style="margin-top: 50px">
                                    <thead>
                                    <tr class="t-head">
                                        <th>Material Name</th>
                                        <th>Material Unit</th>
                                        <th>Qty</th>
                                        <th>Remarks (optional)</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody id="itemRequired">

                                    </tbody>

                                </table>

                            </div>
                        </div>
                        <div id="button_submit">
                            <button type="submit" style="float: right;" class="btn btn-primary" id="dataSubmit" disabled>Submit</button>
                        </div>
                    </div>
                    <!-- !! Form::close() !!} -->
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script>

        $(document).ready(function () {

            $('#get_store_name_by_project').on('change', function () {
                var project_id = $(this).val();
                $.ajax({
                    url: "{{route('getStoreNameByProject')}}",
                    type: 'get',
                    data: {
                        "project_id": project_id,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (data) {

                        $("#store_name").empty();
                        $("#store_name").append('<option>Select Store Name</option>');
                        (data.project).forEach(function (type) {
                            $("#store_name").append("<option value=" + type.id + ">" + type.store_name + "</option>");
                        });

                        $("#tower_name").empty();
                        $("#tower_name").append('<option>Select Tower Name</option>');
                        (data.tower).forEach(function (type) {
                            $("#tower_name").append("<option value=" + type.id + ">" + type.tower_name + "</option>");
                        });

                    }

                });
            });


            $('#material_name').keyup(function () {
                var query = $(this).val();
                if (query != '') {
                    $.ajax({
                        url: "{{ route('autoComplete.fetch') }}",
                        type: "get",
                        data: {
                            "query": query,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (data) {

                            $('#auto_material_list').fadeIn();
                            $('#auto_material_list').html(data);

                        }
                    });
                }
            });

            {{--$('#material_name').autocomplete({--}}
            {{--source:'{{route('autoComplete.fetch')}}',--}}
            {{--minLength:0--}}
            {{--});--}}

                    $('#tower_name').on('change',function(){

                $('#material_name').attr('readonly',false)
                $('#qty_list').attr('readonly',false)

            });

            $(document).on('click', 'li', function () {
                $('#material_name').val($(this).text());
                $('#materialList').fadeOut();
            });

        });

        function fadeout(check) {
            var material_name = $(check).attr('data-name');
            var material_unit = $(check).attr('data-unit');
            var material_id = $(check).attr('data-id');

            var textMaterialName = $('#material_name').attr('data-name', material_name)
            var textMaterialUnit = $('#material_name').attr('data-unit', material_unit)
            var textMaterialId = $('#material_name').attr('data-id', material_id)


            $('#auto_material_list').fadeOut();
            $('#material_name').val()
        }

        function doalert(checkboxElem) {
            $('#material_name').val('');
            var tower = $('#tower_name').val();
            var store = $('#store_name').val();
            var qty = $('#qty_list').val()
            var textMaterialName = $('#material_name').attr('data-name')
            var textMaterialUnit = $('#material_name').attr('data-unit')
            var textMaterialId = $('#material_name').attr('data-id')
            var project_id=$('#get_store_name_by_project').val()
            var store_id=$('#store_name').val()
            var tower_id=$('#tower_name').val()
            $('#dataSubmit').attr('disabled',false)
            $('#qty_list').val('')

            if((tower==undefined) ||(textMaterialName==undefined)||(project_id==undefined)||(store_id==undefined)||(qty==undefined))
            {
                alert("please recheck your data")
                $('#dataSubmit').attr('disabled',true)
                return false
            }

            var tableNewDiv = '';

            tableNewDiv = '<tr>' +
                '<input type="hidden" name="project_id" value="'+project_id+'">'+
                '<input type="hidden" name="store_id" value="'+store_id+'">'+
                '<input type="hidden" name="tower_id" value="'+tower_id+'">'+
                '<td> <input type="hidden" name="material_id[]" value="'+textMaterialId+'">'+textMaterialName+'  </td>'+
                '<td> <input type="hidden" name="material_unit[]" value="'+textMaterialUnit+'">'+textMaterialUnit+'  </td>'+
                '<td> <input type="hidden" name="material_qty[]" value="'+qty+'">'+qty+'  </td>'+
                '<td> <textarea name="material_remarks[]"></textarea> </td>'+

            '</tr>';

            $('#itemRequired').append(tableNewDiv)

        }

    </script>

@endsection
 