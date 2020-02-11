
@extends('layout.app')
@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-money"></i>&nbsp;Billing Cycle Config</h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
            <li><a href="{{route('portal.billingCycle')}}">Billing Cycle Config</a></li>
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
    <div class="col-md-12">
        <a href="{{route('billingCycle.create')}}"><button class="btn btn-primary "><i class="fa fa-plus" aria-hidden="true" title="New" ></i>&nbsp;Add</button></a>
    </div>
    <div class="col-md-12">
        <div class="content-section">
            <div class="  table-responsive  "style="overflow-x: inherit!important;min-height: 0.01%;">
                <table class="table table-bordered main-table" id="search-table">
                    <thead class="table-primary-th">
                        <tr class="btn-primary">
                            <th>Sr. No</th>
                            <th>Billing Cycle</th>
                            <th>Status</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1;
                        ?>
                        @foreach($billingCycles as $billingCycle)
                        <tr>
                            <td>{{$count++}}</td>
                            <td>{{$billingCycle->billing_cycle}}</td>
                            <td></td>
                            <td></td>
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
