@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-money" aria-hidden="true"></i></i>&nbsp; Master Ledger</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('masterLedger.index')}}">Master Ledger</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')

<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plus"></i> Add Master Ledger</h3></div>
            <div class="panel-body">
                @include('includes.msg')
                @include('includes.validation_messages')
                    <form class="form-horizontal" action="{{route('masterLedger.store')}}" method="post" enctype="multipart/form-data">   
                     {{ csrf_field() }}
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body"> 
                                    <fieldset>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Client Type&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control" required="" name="client_id" id="get_client_list_by_client">
                                                    <option>Select Client Type</option>
                                                    @foreach($clientTypes as $clientType)
                                                    <option value="{{$clientType->id}}">{{$clientType->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Client List&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control" required="" name="client_list_id" id="client_list_data">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Opening Balance&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="number" name="opening_balance" placeholder="Opening Balance" required="" value="{{old('opening_balance')}}" step="any" autocomplete="off" id="opening_balance">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Closing Balance&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="number" name="closing_balance" placeholder="Closing Balance" readonly="" value="{{old('closing_balance')}}" step="any" autocomplete="off" id="closing_balance">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">As On Date&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control datepicker" name="as_on_date" value="{{old('as_on_date')}}" placeholder="As On Date" type="text" required="" id="as-on-date" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" id="submit_btn" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
                                            </div>
                                        </div>
                                    </fieldset>
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
    jQuery("#as-on-date").datepicker({
        format: 'dd/mm/yyyy',
        startDate:"today",
        autoclose: true,
        todayHighlight: true,
        minDate:0,
        // endDate: "today",
    });

    $(document).ready(function () {
        $('#get_client_list_by_client').on('change', function () {
            var client_id = $(this).val();
            $.ajax({
                url: "{{route('getClientListData')}}",
                type: 'get',
                data: {
                    "client_id": client_id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {

                    $("#client_list_data").empty();
                    (data.clientList).forEach(function (type) {
                        $("#client_list_data").append("<option value=" + type.id + ">" + type.name_id + "</option>");
                    });

                }

            });
        });

        $("#opening_balance").on('keyup',function () {
            var value = $(this).val();
            $("#closing_balance").val(value); 
        });

    });


</script>

@endsection