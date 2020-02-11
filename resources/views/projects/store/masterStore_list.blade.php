@extends('layout.app')


@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;Master Store </h1>
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
        <div class="content-section">
            <h3 class="header">
           
            </h3>
            <br>
            <div class="well well-sm text-right">
                <div class="pull-left hidden-xs"></div>
                {{--{!! Form::open(['method' => 'get', 'class' => 'form-inline']) !!}--}}

                {{--{!! FormField::select('status_id', ProjectStatus::toArray(), ['placeholder' => trans('project.all')]) !!}--}}

                {{--{!! Form::text('q', Request::get('q'), ['class' => 'form-control index-search-field', 'placeholder' => trans('project.search'), 'style' => 'width:100%;max-width:350px']) !!}--}}

                {{--{!! Form::submit(trans('project.search'), ['class' => 'btn btn-primary btn-sm']) !!}--}}

                {{--{!! link_to_route('projects.index', 'Reset', [], ['class' => 'btn btn-default btn-sm']) !!}--}}

                {{--{!! Form::close() !!}--}}

                <a href="{{route('masterStore.filterItemStore')}}">Filter Store</a>

            </div>
            <div class="table-responsive" style="width:100%">
                    <table id="data-table" class="table table-striped table-bordered search-table">
                            <thead class="t-head">
                                <tr class="tab-text-align">
                                  <th>Sr.No</th>
                                  <th>Project Name</th>
                                  <th>Store Name</th>
                                  <!-- <th>Status</th> -->
                                  <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php $count = 1;?>
                            	@foreach($stores as $store)
                                <tr>
                                  <td>{{$count++}}</td>
                                  <td>{{$store->project_name}}</td>
                                  <td>{{$store->store_name}}</td>
                                  <!-- <td></td> -->
                                    <?php
                                    $store_id=base64_encode($store->store_id);
                                    ?>
                                  <td>
                                      <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                          <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" style="margin-right:5px;">
                                            <li>
                                                <a href="{{route('masterStore.viewItems',$store_id)}}" class="btn btn-danger">View Store</a>
                                            </li>
                                        </ul>
                                      </div>
                                  </td> 
                                </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>
@endsection
