@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-file"></i>&nbsp;Upload Agreement</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="#">Material Request</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
    @include('includes.msg')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
    <script src="{{URL::to('public/js/dropzone.js')}}"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1>Upload Multiple Images</h1>
            {{--{!! Form::open(['route' => [ 'dropzone.store', $project->id], 'uploadedDocx' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'dropzone', 'method' => 'post' ]) !!}--}}
               {{--{{ csrf_field() }}--}}
            {{--{!! Form::close() !!}--}}



            <form action="{{route('dropzone.store',$project->id)}}"
                  class="dropzone"
                  id="my-awesome-dropzone" method="post" enctype="multipart/form-data">
                {{--<div class="fallback">--}}
                {{ csrf_field() }}
                {{--<input type="hidden" name="client_id" value="{{$id}}">--}}
                <input type="file" name="uploadedDocx" multiple />

                {{--<button type="submit" name="Submit"></button>--}}
                {{--</div>--}}
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script type="text/javascript">

        jQuery('#search-table').DataTable({
            "language": {
                "emptyTable": "No data available "
            }
        });




    </script>
@endsection
