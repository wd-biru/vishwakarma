@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-address-card-o" aria-hidden="true"></i></i>&nbsp;Profile</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="#">{{ucfirst($data->name)}}</a></li>
                <!-- <li><a href="#">list</a></li> -->
            </ul>
        </div>
    </div>
@endsection
@section('content')
@include('includes.msg')
@include('includes.validation_messages')


<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ucfirst(Auth::user()->user_type)}} Details</h3></div>
            <div class="panel-body">
                <div class="row">
                    <form action="{{route('admin.profile.update')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                    <div class="col-md-8">
                        <div class="myprofile-box">


                                <div class="col-md-6" style="padding:0px;">
                                    <div class="profile-details">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class=" col-md-3">Logo&nbsp;</label>
                                                <div class="col-md-8">
                                                  @if(!$imgdata)
                                                  <div class="comlogo"  style="width: 250px; height:194px; margin: 0 auto;"><img  id="output" style="height: 168px; width: 100%; " src="{{my_asset('/images/default.png')}}" alt="" title="your Logo" class=" img-thumbnail" required></div>
                                                  @else
                                                    <div class="comlogo"  style="width: 250px; height:194px; margin: 0 auto;"><img  id="output" style="height: 168px; width: 100%; " src="{{getAdminImageUrl($imgdata->image_name)}}" alt="" title="your Logo" class=" img-thumbnail" required></div>
                                                    @endif
                                                    <input class="" id="image" type="file" name="image_name" placeholder="Enter IMG">
                                                </div>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-3">
                                                    <lable><strong>Name&nbsp;:</strong></lable>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" name="name" class="form-control" value="{{$data->name}}">
                                                </div>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-3">
                                                    <lable><strong>Email&nbsp;:</strong></lable>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" name="email" disabled="" class="form-control" value="{{$data->email}}">
                                                </div>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-3">
                                                    <lable><strong>User Type&nbsp;:</strong></lable>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" name="user_type" disabled="" class="form-control" value="{{$data->user_type}}">
                                                </div>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-3">
                                                    <lable><strong>Created Date&nbsp;:</strong></lable>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" name="name" disabled="" class="form-control" value="{{Carbon\Carbon::parse($data->created_at)->format('d/m/Y')}}">
                                                </div>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="form-group pull-right">
                                                <div class="col-md-6">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
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
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#output').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image").change(function() {
        readURL(this);
    });
</script>
@endsection
