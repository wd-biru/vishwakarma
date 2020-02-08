@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-address-card-o" aria-hidden="true"></i></i>&nbsp;Indent Stages</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>

                <!-- <li><a href="#">list</a></li> -->
            </ul>
        </div>
    </div>
@endsection
@section('content')
    @include('includes.msg')
    @include('includes.validation_messages')
    <style type="text/css">
        input[type="radio"], input[type="checkbox"] {
            width: 15px;
        }
    </style>


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-edit"></i>Indent Stages</h3></div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="card">
                            <form action="{{route('Config.StepProcessStore')}}" method="post" id="StepProcessStoreid">
                                <input type="hidden" name="work_flow_id" value="{{$work_flow_id}}">
                                <input type="hidden" name="indent_step" value="{{$indent_step}}">
                                {{ csrf_field() }}
                                <div class="table-responsive">
                                    <table class="table table-bordered main-table ">
                                        <thead>
                                        <tr>
                                            <th>Step</th>
                                            <th>Action</th>
                                            <th>Sequence</th>
                                            <th>Employee</th>
                                            <th>Assigned Employee</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @for($i=1;$i<=$indent_step;$i++)
                                            <tr>
                                                <td><input type="hidden" name="stepNo[]" value="{{$i}}">{{$i}}</td>
                                                <td><select name="stage_action[]" class="form-control " required="">
                                                        <option value="">**Please Select**</option>
                                                        @foreach($stagemaster as $list)
                                                            <option value="{{$list->id}}">{{$list->name}}</option>
                                                        @endforeach
                                                    </select></td>


                                                <td><select name="sequnce[]" class="form-control sequence" required="">
                                                        <option value="">**Please Select**</option>
                                                        @for($j=1;$j<=$indent_step;$j++)
                                                            <option value="{{$j}}">Sequence{{$j}}</option>
                                                        @endfor
                                                    </select>
                                                </td>
                                                <td><a class="open_model_employee" data-step_id="{{$i}}">Assign Approval
                                                        Employee</a></td>
                                                <td id="assign{{$i}}"></td>
                                            </tr>
                                        @endfor

                                        </tbody>

                                    </table>
                                </div>
                                <button type="submit" style="float: right;" class="btn btn-primary">Submit</button>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('Config.empstore')}}" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="exampleModalLabel">Assign Employee</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="work_flow_id" value="{{$work_flow_id}}">
                        <input type="hidden" name="step_id" value="" id="step_id">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="email">Department</label>
                                </div>
                                <div class="col-md-8" style="margin-bottom: 15px;">
                                    <select class="form-control select2" id="departments" name="departments"
                                            required="">
                                        <option value=""></option>
                                        @foreach($departments as $list)
                                            <option value="{{$list->id}}">{{$list->department_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="checkboxvalues">

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>


    <script type="text/javascript">

        jQuery('.select2').select2({
            tags: true,
            tokenSeparators: [','],
            placeholder: "Select Department"
        });


        $(".sequence").on("change", function () {
            var value = $(this).val();
            $(".sequence option[value=" + value + "]").attr('disabled', 'disabled');
            $('form').bind('submit', function () {
                $(this).find(':disabled').removeAttr('disabled');
            });

        });


        //////////////////////////////////////////
        jQuery(function () {


            var vil = {
                init: function () {

                    $(".open_model_employee").click(function () {

                        $("#checkboxvalues").empty();
                        var step_id = $(this).data("step_id");
                        $('#step_id').val(step_id);

                        var checkbox_name = '';
                        $('.checkboxclass').prop('checked', false);
                        $(".select2").select2("val", "");

                        $('#myModal').modal('show');


                    });

                    $(document).on("change", "#departments", function (e) {
                        var depart_id = $(this).val();

                        vil.assignGetList(depart_id);

                    });


                    $(document).on('click', '.checkboxclass', function (e) {


                        if ($(this).is(':checked')) {
                            var step_id = $("#step_id").val();
                            var checkbox_name = $(this).attr('name');
                            var value_of_checkbox = $(this).val();

                            var id = '#assign' + step_id + '';
                            console.log(id);
                            $(id).append(checkbox_name + '<br>');
                            $('#StepProcessStoreid').append('<input type="hidden" name="step' + step_id + '[]" value="' + value_of_checkbox + '" />');
                            $(this).attr("disabled", true);
                        }

                    });


                },

                assignGetList: function (depart_id) {


                    jQuery.post('getdeptemployee', {
                        department_id: depart_id,

                        '_token': jQuery('meta[name="csrf-token"]').attr('content'),
                    }, function (data) {
                        $('#checkboxvalues').html('');
                        var opt = '';

                        jQuery.each(data, function (index, value) {


                            opt += '<div class="row" style="margin-left: 20px;" ><div class="col-md-4">' + value.first_name + '</div><div class="col-md-8"><input type="checkbox" name="' + value.first_name + '"  class="form-control checkboxclass"  value="' + value.id + '"></div></div>';
                        });


                        $('#checkboxvalues').append(opt);


                    });
                },


            }
            vil.init();
        });


    </script>





@endsection
