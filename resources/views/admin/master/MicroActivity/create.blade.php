@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Micro Activity Work</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('microAcivity.index')}}">Micro Activity Work</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')


<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plus"></i>Micro Activity Work</h3></div>
            <div class="panel-body">
                @include('includes.msg')
                @include('includes.validation_messages')

                    <form class="form-horizontal" action="{{route('microAcivity.store')}}" method="post" enctype="multipart/form-data"> 
                        {{ csrf_field() }}
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body"> 
                                    <fieldset>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Group Name:&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <select name="activity_group_id" id="activity_group_id" class="form-control" required="">
                                                    @foreach($activityGroups as $activityGroup)
                                                    <option value="">Select Activity Group</option>
                                                    <option value="{{$activityGroup->id}}">{{$activityGroup->activity_group}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Sub Activity Work:&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <select name="sub_activity_id" id="sub_activity_id" class="form-control" required="">
                                                    <option value="">Select Sub Activity Group</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Micro Activity Work:&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Sub Activity Work" name="micro_activity_name" required="">
                                            </div>
                                        </div>
                                    </fieldset>
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

@section('script')

<script type="text/javascript">
    $(document).ready(function() {
        $('#activity_group_id').on('change', function () {
            var activity_id = $(this).val();
             var op = " ";
            var _token = $('input[name="_token"]').val();
            $.ajax({
                type: 'get',
                url: "{{route('getSubActivity')}}",
                data: {'activity_id': activity_id},
                success: function (data) {
                    // op += ' <option value="">----------------select---------------</option>';
                    console.log(data);
                    for (var i = 0; i < data.length; i++) {
                        op += ' <option value="' + data[i].id + '">' + data[i].sub_activity_work + '</option>';
                    }
                    $(document).find('#sub_activity_id').html(" ");
                    $(document).find('#sub_activity_id').append(op);
                },
                error: function () {
                }
            });
        });
    });
        
</script>

@endsection

