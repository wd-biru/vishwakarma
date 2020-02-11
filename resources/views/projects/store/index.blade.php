@extends('layout.project')

@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>&nbsp;Store</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li>{{ link_to_route('projects.index',trans('project.projects'), ['status_id' => request('status_id', $project->status_id)]) }}</li>
                <li>{{ $project->present()->projectLink }}</li>
                <li><a href="">Project Allocation Master Data List</a></li>

            </ul>
        </div>
    </div>

@endsection
@section('action-buttons')
    @if(Auth::user()->user_type != 'employee')
        {!! html_link_to_route('projects.store.create', 'Store Create', [$project->id], ['class' => 'btn btn-success','icon' => 'plus']) !!}

    @endif

@endsection
@section('content-project')
    @include('includes.msg')
    @include('includes.validation_messages')
    @if(Auth::user()->user_type != 'employee')
        @if($store_detail->isEmpty())
            Store list is empty.So,{{ link_to_route('projects.store.create', 'Store Create', [$project->id]) }}.
        @endif
    @endif


    @if(count($store_detail)>0)
        <div class="row">
            <div class="col-md-12">
                <div class="content-section">
                    <div class="  table-responsive ">
                        <table class="table table-bordered main-table search-table ">
                            <thead>
                            <tr class="t-head">
                                <th>Sr. No.</th>
                                <th>Store Name</th>
                                <th>Store Keeper Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($store_detail as $key =>  $data )
                                <?php
                                $empName = "";
                                if (Auth::user()->user_type == "employee") {
                                    $store = $data->getStoreDetail->store_name;
                                    $empName = Auth::user()->getEmp->first_name . "" . Auth::user()->getEmp->last_name;
                                } else {
                                    $store = $data->store_name;

                                    if ($data->getStoreEmp->count() == 0) {
                                        $empName = "No Employee On this store";
                                    } else {
                                        foreach ($data->getStoreEmp as $value) {
                                            $empName .= $value->getEmpDetails->first_name . " " . $value->getEmpDetails->last_name . ',';
                                        }
                                    }

                                }

                                if (Auth::user()->user_type == 'portal') {
                                    $store_id = $data->id;
                                } else {
                                    $store_id = $data->store_id;
                                }

                                ?>
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$store}}</td>
                                    <td>{{$empName}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button"
                                                    data-toggle="dropdown">Action
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" style="margin-right: 215px;">
                                                <li>
                                                    <a href="{{route('storeInventory',[$project->id,base64_encode($store_id)])}}"><i
                                                                class="fa fa-inventory"></i>Stock</a>
                                                </li>
                                                @if(Auth::user()->user_type != "employee")
                                                    <li>
                                                        <a href="#" data-toggle="modal"
                                                           data-target="#modalStore_{{$data->id}}"><i class="fa fa-edit"
                                                                                                      aria-hidden="true"></i>&nbsp;Store
                                                            Update</a>
                                                    </li>
                                                @endif
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

    @endif


    @if(Auth::user()->user_type != "employee")
        @foreach($store_detail  as $value)
            <div class="modal fade" id="modalStore_{{$value->id}}" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" style="padding-left: 130px" data-dismiss="modal"
                                    aria-label="Close">
                                &times;
                            </button>
                            <h5 class="modal-title" id="exampleModalLongTitle">Store Update</h5>
                        </div>
                        <div class="modal-body">
                            <?php
                            $emp_list = [];
                            if (Auth::user()->user_type == "employee") {
                                $store = $value->getStoreDetail->store_name;
                                $store_id = DB::table('vishwa_project_store')->where('store_name', $store)->first();
                                $emp_list = Auth::user()->getEm->id;
                            } else {
                                $store = $value->store_name;
                                $store_id = DB::table('vishwa_project_store')->where('store_name', $store)->first();

                                if ($value->getStoreEmp->count() == 0) {
                                    $emp_list = [];
                                } else {
                                    foreach ($value->getStoreEmp as $row) {
                                        $emp_list[] = $row->store_keeper_id;
                                    }
                                }

                            }

                            ?>

                            {!! Form::model($project, ['route' => ['store.update', $project->id], 'method' => 'post' ]) !!}
                            <div class="panel panel-default">
                                <div class="panel-heading"><h3 class="panel-title">Store Update</h3></div>
                                <div class="panel-body">

                                    <input type="hidden" name="project_id" value="{{$project->id}}">
                                    <input type="hidden" name="store_id" value="{{$store_id->id}}">


                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="email">Store Name</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" style="margin-bottom: 15px;" class="form-control"
                                                   name="store_name" value="{{$store}}" readonly="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="email">Store Keeper Name</label>
                                        </div>
                                        <div class="col-md-8" style="margin-bottom: 15px;">
                                            <select class="form-control store_keepers" name="store_keeper_id[]"
                                                    multiple="" required="">

                                                @foreach($store_emp_list as $list)
                                                    <option value="{{$list->id}}"
                                                            @if(in_array($list->id,$emp_list)) selected @endif>{{$list->first_name}} {{$list->last_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="panel-footer">
                                    {!! Form::submit('Update Store', ['class' => 'btn btn-primary']) !!}
                                    {{ link_to_route('store.index', __('app.cancel'), [$project], ['class' => 'btn btn-default']) }}
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
@section('script')
    <script type="text/javascript">
        $('.store_keepers').select2({
            tags: true,
            width: '100%',
            tokenSeparators: [','],
            placeholder: "Select Store Keepers"
        });

    </script>
@endsection






















