@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Tickets Issue</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>

                <li><a href="#">Add</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plus"></i> Add Issue Info</h3></div>
            <div class="panel-body">
                @include('includes.msg')
                @include('includes.validation_messages')

                    <form class="form-horizontal" action="{{route('portalInfoStore.store')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <fieldset>
                                        <legend>Issue</legend>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="name"  placeholder="Enter Issue type" style="text-transform: capitalize" value="{{old('name')}}">
                                        </div>
                                        </div>






                                    </fieldset>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit_btn" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
