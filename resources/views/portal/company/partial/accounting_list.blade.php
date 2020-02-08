
<div class="modal fade" id="myModalAccounting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
                <h4 class="modal-title" id="myModalLabel">Add Accounting </h4>
            </div>
            <div class="modal-body">
                <form action="" id="accountingform" method="post">
                    <input type="hidden" name="client_id" value="{{$id}}">
                    {{csrf_field()}}

                     <div class="row accac">
                        <div class="col-sm-12">
                            <fieldset>
                                <legend>Info</legend>
                                <div class="form-group no-padding">
                                    <label>Bank Reconcilation performed up to</label>
                                    <input  class="form-control DisableFutureDatepicker" name="Bank_Reconcilation" value="@if(isset($ClientServiceAccountingData) && !empty($ClientServiceAccountingData)){{Carbon\Carbon::parse($ClientServiceAccountingData->Bank_Reconcilation)->format('d/m/Y')}}@endif" placeholder="" required>
                                </div>
                                <div class="form-group no-padding">
                                    <label>Creditor Reconcilation performed up to</label>
                                    <input  class="form-control DisableFutureDatepicker"  value="@if(isset($ClientServiceAccountingData) && !empty($ClientServiceAccountingData)){{Carbon\Carbon::parse($ClientServiceAccountingData->Creditor_Reconcilation)->format('d/m/Y')}}@endif"  name="Creditor_Reconcilation" placeholder="" required>
                                </div>
                                <div class="form-group no-padding">
                                    <label>Debtor Reconcilation performed up to</label>
                                    <input class="form-control DisableFutureDatepicker" placeholder=""  value="@if(isset($ClientServiceAccountingData) && !empty($ClientServiceAccountingData)){{Carbon\Carbon::parse($ClientServiceAccountingData->Debtor_Reconcilation)->format('d/m/Y')}}@endif" name="Debtor_Reconcilation" required>
                                </div>

                                <div class="form-group no-padding">

                                    <legend>Comments</legend>
                                    <textarea  class="form-control" name="Comments" rows="3" required>@if(isset($ClientServiceAccountingData) && !empty($ClientServiceAccountingData)){{$ClientServiceAccountingData->Comments}}@endif</textarea>
                                </div>
                            </fieldset>

                            <div class="row">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" id="button-accounting" class="btn btn-primary pull-right">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>







<div class="row">
    <div class="col-md-12">

            <a href="#" data-toggle="modal" class="btn btn-primary" data-target="#myModalAccounting" title="Add"><i class="fa fa-plus-square-o"> Add New</i></a>

    </div>
</div>
<div>
    <form action="{{route('companyAuditEdit')}}" method="post">
        {{ csrf_field() }}
        <div class="table-responsive">
            <table class="table table-bordered searchTable" >
                <thead>
                    <tr class="btn-primary-th">
                        <th>Sr. No</th>
                        <th>Bank Reconcilation</th>
                        <th>Creditor Reconcilation </th>
                        <th>Debtor Reconcilation </th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody><?php $i=1?>
                    @foreach($accounting_list as $list)
                        <tr>

                            <td>{{$i++}}</td>
                            <td>{{Carbon\Carbon::parse($list->Bank_Reconcilation)->format('d/m/Y')}}</td>
                            <td>{{Carbon\Carbon::parse($list->Creditor_Reconcilation)->format('d/m/Y')}}</td>
                            <td>{{Carbon\Carbon::parse($list->Debtor_Reconcilation)->format('d/m/Y')}}</td>
                            <td>{{$list->Comments}}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
</div>


<script type="text/javascript">
jQuery(".DisableFutureDatepicker").datepicker({
                    format: 'dd/mm/yyyy',
                    autoclose: true,
                    todayHighlight: true,
                    endDate: "today",
                });
</script>
