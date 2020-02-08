@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-address-card-o" aria-hidden="true"></i></i>&nbsp;Potal Config</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>

            </ul>
        </div>
    </div>
@endsection
@section('content')

    <style type="text/css">
        input[type="radio"], input[type="checkbox"] {
            width: 15px;
        }
    </style>


    <div class="row">
        <div class="col-md-12">
            @include('includes.msg')
            @include('includes.validation_messages')
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-edit"></i> Portal Config</h3></div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                @foreach($portal_config as $list)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{$list->field_label}}</label>
                                        </div>
                                        <form action="{{route('Config.StepProcess')}}" method="get">
                                            <input type="hidden" name="work_flow_name" value="{{$list->field_name}}">
                                            <input type="hidden" name="config_id" value="{{$list->id}}">
                                            @if(strtolower($list->input_type)=='text')
                                                <div class="col-md-6">
                                                    <input style="margin-bottom: 10px;" type="{{$list->input_type}}"

                                                           class="form-control" name="indent_step"
                                                           value="{{$list->value}}">


                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-primary"
                                                            @foreach($VishwaUserWorkflowRoleMapping as $key => $maplist)
                                                            @foreach($maplist as $data)
                                                            @if($data->workflowname==$list->field_name)
                                                            disabled
                                                            @endif
                                                            @endforeach
                                                            @endforeach style="width: 47px;">Go
                                                    </button>
                                                </div>
                                        </form>
                                        @endif
                                        @if(strtolower($list->input_type)=='select')
                                            <div class="col-md-6">
                                                <select class="form-control">

                                                </select>
                                            </div>
                                        @endif

                                        @if(strtolower($list->input_type)=='checkbox')
                                            <div class="col-md-6">
                                                <div class="col-md-6">
                                                    <input style="margin-bottom: 10px;" type="{{$list->input_type}}"
                                                           class="form-control" name="indent_step"
                                                           value="{{$list->value}}">


                                                </div>
                                                <div class="col-md-2">
                                                    <!-- <button type="submit" class="btn btn-primary" style="width: 47px;">Go</button> -->
                                                </div>
                                            </div>
                                        @endif
                                        @if(strtolower($list->input_type)=='radio')
                                            <div class="col-md-6">
                                                <div class="col-md-6">
                                                    <input style="margin-bottom: 10px;" type="{{$list->input_type}}"
                                                           class="form-control" name="indent_step"
                                                           value="{{$list->value}}">


                                                </div>
                                                <div class="col-md-2">
                                                    <!-- <button type="submit" class="btn btn-primary" style="width: 47px;">Go</button> -->
                                                </div>
                                            </div>
                                        @endif


                                    </div>
                                    <a href="{{route('workflow.add',$list->field_name)}}" class="btn btn-primary">ADD TO
                                        WORKFLOW</a>
                                    <a href="{{route('workflow.edit',$list->field_name)}}" class="btn btn-primary">Edit
                                        WORKFLOW</a>
                                @endforeach
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>


    {{--@if(count($VishwaUserWorkflowRoleMapping)>0)
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-edit"></i> Indent Stages Details</h3></div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered main-table search-table">
                                    <thead class="btn-primary">
                                            <tr>
                                            <th>Sequrence</th>
                                            <th>WorkFlow Name</th>
                                            <th>Stage</th>
                                            <th>Employee</th>

                                            </tr>
                                         </thead>
                                        <tbody>
                                            @foreach($VishwaUserWorkflowRoleMapping as $key => $list)
                                             @foreach($list as $data)


                                            <tr>
                                               <td>{{$key}}</td>
                                               <td>{{$data->workflowname}}</td>
                                               <td>{{$data->stage_name}}</td>
                                               <td>{{$data->first_name}}</td>
                                             </tr>

                                                  @endforeach
                                                  @endforeach

                                        </tbody>
                                    </table>

                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif--}}




@endsection

@section('script')
    <script type="text/javascript">

        jQuery('.select2').select2({
            tags: true,
            tokenSeparators: [','],
            placeholder: "Select Department"
        });


    </script>

@endsection
