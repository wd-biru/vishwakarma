@extends('layout.project')

@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>&nbsp;Resources Allocation</h1>
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



@section('content-project')

    @if(count($employee)<0)
        <p>
            No Employee Found,Please create employee first.
        </p>
    @else
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
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">&nbsp;Resource List</h3>
                    </div>
                    <div class="panel-body">
                        <div class="card col-md-12 ">
                            <div class="table-responsive">
                                <table class="table table-bordered   search-table">
                                    <thead>
                                    <tr class="t-head">
                                        <th>Employee Name</th>
                                        <th>Department Name</th>
                                        <th>Designation</th>
                                        <td>Action</td>
                                    </tr>
                                    </thead>
                                    <tbody id="storeGroup">
                                    <?php $employees = $employee; ?>

                                    @foreach($employees as $employee)

                                        <tr>
                                            <input type="hidden" class="employee-data" value="">
                                            <td><a href="{{route('companyemployeeInfoEdit',$employee->id)}}">{{$employee->complete_name}}</a>
                                            </td>
                                            <td>{{ucfirst($employee->department_name)}}</td>
                                            <td>{{ucfirst($employee->designation)}}</td>
                                            <td>
                                                <input @foreach($allocatedEmployee as $list) @if($list->employee_id==$employee->id) checked
                                                       disabled @endif   @endforeach type="checkbox"
                                                       name="employee_detail" value="{{$employee->id}}"
                                                       class="employee-data"></td>
                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-7 show-data">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">&nbsp;Resource Allocated</h3>
                    </div>
                    <div class="panel-body">
                        <div class="card col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered  search-table">
                                    <thead>
                                    <tr class="t-head">
                                        <th>Employee Name</th>
                                        <th>Roles</th>
                                        <th>Action</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>


                                    <tbody>
                                    @foreach($allocatedEmployee as $list)
                                        <tr>
                                            {!! Form::model($project, ['route' => ['allocationUpdate', $project->id], 'method' => 'post' ]) !!}
                                            <td>{{$list->first_name}}&nbsp;{{$list->last_name}}</td>
                                            {{csrf_field()}}
                                            <input type="hidden" name="mapping_id" value="{{$list->id}}">
                                            <input type="hidden" name="emp_id" value="{{$list->employee_id}}">
                                            <input type="hidden" name="project_id" value="{{$project->id}}">
                                            <td>
                                                <select class="form-control" required="" class="form-control"
                                                        name="role">
                                                    <option value="">--Select Roles--</option>
                                                    @foreach($roles as $role)
                                                        <option @if($list->role_id==$role->id) selected
                                                                @endif value="{{$role->id}}">{{$role->designation}}</option>
                                                    @endforeach
                                                </select>
                                            </td>


                                            <td style="text-align: center;">


                                                <button type="submit"
                                                        style="background: white;border:none;outline: none; width: 70px;">

                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"
                                                       style="font-size: 27px;"></i>
                                                </button>
                                                {!! Form::close() !!}
                                            </td>
                                            <td> <?php if($list->is_active == 1){?>

                                                {!! Form::model($project, ['route' => ['allocation.change_status', 'id' => $project->id], 'method' => 'post' ]) !!}
                                                <input type="hidden" name="mapping_id" value="{{$list->id}}">
                                                <input type="hidden" name="actt" value="0">
                                                <input type="hidden" name="emp_id" value="{{$list->employee_id}}">
                                                <input type="hidden" name="project_id" value="{{$project->id}}">

                                                <button type="submit" class="status"
                                                        onclick="return confirm('Do you want to deactivate?');"><img
                                                            src="{{URL::asset('public/images')}}/activate.png" style="">
                                                </button>

                                                {!! Form::close() !!}
                                                <?php }else{ ?>
                                                {!! Form::model($project, ['route' => ['allocation.change_status', 'id' => $project->id], 'method' => 'post' ]) !!}
                                                <input type="hidden" name="mapping_id" value="{{$list->id}}">
                                                <input type="hidden" name="actt" value="1">
                                                <input type="hidden" name="emp_id" value="{{$list->employee_id}}">
                                                <input type="hidden" name="project_id" value="{{$project->id}}">
                                                <button type="submit" class="status"
                                                        onclick="return confirm('Do you want to activate?');"><img
                                                            src="{{URL::asset('public/images')}}/deactivate.png"
                                                            style=""></button>

                                                {!! Form::close() !!}

                                                <?php } ?>
                                            </td>


                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    @endif
@endsection
@section('script')
    <script>
        jQuery(document).on('click', '.employee-data', function () {
            var emp_id = jQuery(this).val();
            jQuery(this).attr('disabled', true);
            console.log(emp_id);

            jQuery.ajax({

                url: "{{route('allocation.store',$project->id)}}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "emp_id": emp_id,
                    "project_id": "{{$project->id}}",
                },
                dataType: 'html',
                success: function (response) {


                    if (response == "ok") {
                        ViewHelpers.notify("success", "Resource Allocated");
                        window.location.reload();
                    } else {
                        ViewHelpers.notify("error", 'Already Exist');
                    }
                },
                error: function (err) {
                    //alert(err) ;
                }
            });
            event.preventDefault();
            return false;
        });


    </script>

@endsection






















