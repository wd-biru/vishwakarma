@extends('layout.app')
<style type="text/css">
    .box-header {
        color: #444;
        display: block;
        padding: 10px;
        position: relative;
    }

    .box-header.with-border {
        border-bottom: 1px solid #f4f4f4;
    }

    .box-body {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
        padding: 10px;
    }

    .box-footer {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
        border-top: 1px solid #f4f4f4;
        padding: 10px;
        background-color: #ffffff;
    }

    .box-header > .fa, .box-header > .glyphicon, .box-header > .ion, .box-header .box-title {
        display: inline-block;
        font-size: 18px;
        margin: 0;
        line-height: 1;
        width: 100%;
    }
</style>
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>&nbsp;Dashboard</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('employee.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="#">Dashboard</a></li>
                <li></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')


    <div class="row">
        <div class="col-md-6">
            <div class="box-header with-border"
                 style="border-top: 2px solid #003260;background-color: #fff;  margin-top: 10px;">
                <h3 class="box-title">Client List</h3><a href="{{route('getEmpNotification')}}">GetNotify</a>
            </div>
            <div class="box-body" style="background-color:#fff;">
                <div class="table-responsive">
                    <table class="table search-table">
                        <thead>
                        <tr style="font-size: 14px;">
                            <th>Sr. No</th>
                            <th>Client Name</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = 1; ?>

                        @foreach($clients as $data)


                            <tr style="    font-size: 11px;">

                                <td>{{ $count++}}</td>
                                <td>{{ucfirst($data->Client_name)}}</td>
                                <td>@if($data->Status ==1) Active @else DeActive @endif</td>

                            </tr>

                        @endforeach

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="box-header with-border"
                 style="border-top: 2px solid #b62722;background-color: #fff;  margin-top: 10px;">
                <h3 class="box-title">Project List</h3>
            </div>
            <div class="box-body" style="background-color:#fff;">
                <div class="table-responsive">
                    <table class="table" id="search2">
                        <thead>
                        <tr style="font-size: 14px;">
                            <th>Sr. No</th>
                            <th>Project Name</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = 0; ?>
                        @if($count < 5)

                            @foreach($project_list as $data)
                                <?php
                                $count++;
                                ?>

                                <tr style="font-size: 11px;">
                                    <td>{{ $count}}</td>
                                    <td> {{link_to_route('projects.show',ucfirst($data->name),$data->id)}}</td>
                                    <td class="table-status">
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if(($data->status_id==1)||($data->status_id==2)||($data->status_id==3))
                                                    <div class="col-md-3" style="text-align: right;"><span><img src="{{ my_asset('images/activate.png') }}"></span></div>
                                                    <div  class="col-md-6" style="text-align: left;">
                                                       <span>
                                                        @if($data->status_id==1)
                                                               <strong>Planned</strong>@elseif($data->status_id==2)<strong>On
                                                                Progress</strong>
                                                           @elseif($data->status_id==3)<strong>Done !</strong>
                                                           @endif
                                                        </span>
                                                    </div>
                                                @elseif(($data->status_id==4)||($data->status_id==5)||($data->status_id==6))
                                                    <div class="col-md-3" style="text-align: right;">
                                                        <span><img class="change_status" src="{{my_asset('images/deactivate.png')}}"></span>
                                                    </div>
                                                    <div  class="col-md-6" style="text-align: left;">
                                                        <span>
                                                            @if($data->status_id == 4)
                                                                <strong>Closed</strong>@elseif($data->status_id==5)
                                                                <strong>Cancelled</strong>
                                                            @elseif($data->status_id==6)<strong>On Hold</strong>
                                                            @endif
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="box-footer text-center">
                <a href="{{route('projects.index')}}" class="uppercase">View All </a>
            </div>
        </div>
    </div>




@endsection
