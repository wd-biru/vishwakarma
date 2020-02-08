
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
                <h4 class="modal-title" id="myModalLabel">Add Auditing </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="auditingform"  method="post">
                {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="year">Year</label>
                        <div class="col-sm-9">
                            <input class="date-own form-control" type="text" name="year" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" required="required" name="Status" id="Status">
                                @foreach($audit_status as $status)
                                <option value="{{$status->id}}">{{$status->audit_status}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Starting Date</label>
                        <div class="col-sm-9">
                            <input class="form-control datepicker"  name="start_date"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Ending Date</label>
                        <div class="col-sm-9">
                            <input class="form-control datepicker"  name="end_date"   required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email" >Reviewed By</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="review_by" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Prepared By</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="prepared_by" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="editAuditingModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
                <h4 class="modal-title" id="myModalLabel">Update Auditing
                 </h4>
            </div>
            <form class="form-horizontal" " id="auditingUpdateform" action="" method="get">
                <div class="modal-body">
                    <input type="hidden" name="update_id"  value="" id="update_id">
                    <input type="hidden" name="update_audit"  value="5">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="year">Year</label>
                        <div class="col-sm-9">
                            <input class="date-own form-control" type="text" name="year" id="year">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" required="required" name="Status" id="auditStatus">
                                 @foreach($audit_status as $status)
                                    <option value="{{$status->id}}">{{$status->audit_status}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Starting Date</label>
                        <div class="col-sm-9">
                            <input class="form-control datepicker" name="start_date" id="audit_startDate" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Ending Date</label>
                        <div class="col-sm-9">
                            <input class="form-control datepicker" name="end_date" id="audit_endDate" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email" >Reviewed By</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="review_by" id="audit_review" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Prepared By</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="prepared_by" id="audit_prepared" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Final approval</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="final_approve_by" id="audit_final" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="auditing_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
                <h4 class="modal-title" id="myModalLabel">Add More Info
                 </h4>
            </div>
            <div class="modal-body">
           <div class="row">
<form action="" id="auditInfoForm" method="post" >
        <input type="hidden" name="auditing_info_id" id="Audit_update_id">
            {{csrf_field()}}
            <div class="col-md-6 ">
                        <fieldset>
                            <legend>Info:</legend>
                            <div class="form-group ">
                                <label class="control-label">Profit/Loss before tax</label>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input class="form-control" name="profit_a" id="profit_a" value="" type="number" placeholder="">
                                    </div>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="number" value="" name="profit_b" id="profit_b" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="control-label">Corporation Tax</label>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input class="form-control" name="corporationTax_a" type="number" id="corporationTax_a" value="" placeholder="">
                                    </div>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="number" name="corporationTax_b" id="corporationTax_b"  value="" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="control-label">Defence Contribution</label>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input class="form-control" type="text" name="defence_a" id="defence_a"  value=""  placeholder="">
                                    </div>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="defence_b" id="defence_b"  value="" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </fieldset>

            </div>
            <div class="col-md-6 ">

                    <fieldset>
                        <legend>Comments</legend>
                            <textarea rows="3" name="audit_comment"  id="audit_comment" class="form-control"></textarea>
                    </fieldset>
                    <fieldset>
                        <legend>Progress:</legend>
                            <textarea rows="3" name="audit_progress" id="audit_progress" class="form-control"></textarea>
                    </fieldset><br>

            </div>

        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary pull-right" ">Submit</button>
        </div>
    </form>
    </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">

            <a href="#" data-toggle="modal" class="btn btn-primary" data-target="#myModal" title="Add"><i class="fa fa-plus-square-o"> Add New</i></a>

    </div>
</div>
<div>
    <form action="{{route('companyAuditEdit')}}" method="post">
        {{ csrf_field() }}
        <div class="table-responsive">
            <table class="table table-bordered searchTable" >
                <thead>
                    <tr class="btn-primary-th">
                        <th>Year</th>
                        <th>Status</th>
                        <th>Start date</th>
                        <th>End date</th>
                        <th>Reviewed by</th>
                        <th>Prepared by</th>
                        <th>Final approval</th>
                        <th>Operations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($auditing_list as $list)
                        <tr>
                            <td>{{$list->year}}</td>
                            <td>{{$list->getStatus->audit_status}}</td>
                            <td>{{Carbon\Carbon::parse($list->start_date)->format('d/m/Y')}}</td>
                            <td>{{Carbon\Carbon::parse($list->end_date)->format('d/m/Y')}}</td>
                            <td>{{$list->review_by}}</td>
                            <td>{{$list->prepared_by}}</td>
                            <td>{{$list->final_approve_by}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" class="auditing_info" data-id="{{$list->id}}">Add/View More Info</a></li>
                                        <li><a href="#" data-year="{{$list->year}}" data-id="{{$list->id}}" data-status="{{$list->getStatus->audit_status}}" data-startdate="{{Carbon\Carbon::parse($list->start_date)->format('d/m/Y')}}" data-edndate="{{Carbon\Carbon::parse($list->end_date)->format('d/m/Y')}}" data-review="{{$list->review_by}}" data-prepared="{{$list->prepared_by}}" data-final="{{$list->final_approve_by}}" class="editAudit" title="Add">Edit</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
</div>

<div id="more-info-holder">

</div>

<script type="text/javascript">
    jQuery('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true,

    });

     jQuery('.date-own').datepicker({
        minViewMode: 2,
        orientation: 'bottom',
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy'
    });
</script>
