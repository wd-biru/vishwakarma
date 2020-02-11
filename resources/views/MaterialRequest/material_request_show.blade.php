@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-suitcase"></i>&nbsp;Material Request Items For : {{$mr_no}}</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="#">Material Request Item</a></li>
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

    <div class="row">
        <div class="col-md-10">

        </div>

        <div class="col-md-12">
            <div class="content-section" id="id-status_change">


                <div class="  table-responsive  " style="overflow-x: inherit!important;
    min-height: 0.01%;">
                    <table class="table table-bordered main-table" id="search-table">
                        <thead class="table-primary-th">
                        <tr class="btn-primary">
                            <th>Sr. No</th>
                            <th>Item Name</th>
                            <th>Unit</th>
                            <th>Qty</th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php $j = 1; ?>
                        @foreach($mr_items as $mr_req)
                            <tr>

                                <td>{{$j++}}</td>
                                <td>{{$mr_req->material_name}}</td>
                                <td>{{$mr_req->item_unit}}</td>
                                <td>{{$mr_req->item_qty}}</td>


                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>

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
