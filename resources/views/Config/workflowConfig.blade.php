@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-address-card-o" aria-hidden="true"></i></i>&nbsp;Portal Work Flow Config</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>

            </ul>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <a type="button" class="btn btn-primary pull-left" data-toggle="modal" data-target="#exampleAddWorkFlow">
                <i class="fa fa-plus"></i>&nbsp;ADD TO WORKFLOW
            </a></div><br><br>
            @include('includes.msg')
            @include('includes.validation_messages')
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-edit"></i> Portal Config</h3></div>
                <div class="panel-body">

                    <div class="  table-responsive ">
                        <table class="table table-bordered main-table search-table ">
                            <thead>
                            <tr class="t-head">
                                <th>Sr. No.</th>
                                <th>Work Flow Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($workFlows as $key => $list)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$list->name}}</td>
                                    <td><a href="{{route('workflow.edit',$list->name)}}">Edit WorkFlow</a></td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleAddWorkFlow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal"
                            aria-label="Close">
                        &times;
                    </button>
                    <h5 class="modal-title" id="exampleModalLongTitle">ADD TO WORKFLOW</b></h5>
                </div>
                <form class="form-horizontal" action="{{route('workflow.add')}}" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="modal-body">

                            <div class="form-group">
                                <label class="control-label col-sm-4" for="pwd">Workflow Name<span
                                            style="color:red"> *</span></label>
                                <div class="col-sm-8">
                                    {{--<input type="text" id="name" class="form-control check_value_ea check_name_ea"--}}
                                           {{--name="name" placeholder="Field Name" required/><br>--}}
                                    <select name="name" class="form-control ">
                                        <option value="">Select Workflow Group</option>
                                        @foreach($workFlows_name as $flow)
                                            <option value="{{$flow->id}}">{{$flow->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    </div>

@endsection

