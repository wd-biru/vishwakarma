@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-bank" aria-hidden="true"></i></i>&nbsp; Bank Account</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('portal.bankAccount')}}">Bank Account</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
@include('includes.msg')
@include('includes.validation_messages')

<div class="row">
    <div class="col-md-12">
        <div class="content-section">
            <a href="{{route('portal.bankAccount.create')}}"><button class="btn btn-primary "><i class="fa fa-user-plus" aria-hidden="true" title="New" ></i>&nbsp;&nbsp;Add </button></a><br><br>
            <div class="  table-responsive ">
                <table class="table table-bordered main-table search-table " >
                    <thead>
                        <tr class="t-head">
                            <th>Sr. No.</th>
                            <th>Bank Name</th>
                            <th>Cheque Book From</th>
                            <th>Cheque Book To</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        ?>
                        @foreach($bankAccounts as $bankAccount)
                        <tr>
                            <td>{{$count++}}</td>
                            <td>{{$bankAccount->bank_name}}</td>
                            <td>{{$bankAccount->from_chq}}</td>
                            <td>{{$bankAccount->to_chq}}</td>
                            <td>
                                @if($bankAccount->currently_use == 1)
                                    Active
                                        @else
                                            Inactive
                                @endif
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



