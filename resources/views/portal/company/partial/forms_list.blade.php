
<div class="modal fade" id="formsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
                <h4 class="modal-title" id="">Add Form </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="formsForm" action="" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Type</label>
                        <div class="col-sm-9">
                            <select class="form-control category" required="required" name="category_id"  >
                               @foreach($FormCategory as $category)
                               <option value="{{$category->id}}">{{$category->category_name}}</option>
                               @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Name</label>
                        <div class="col-sm-9">
                            <select class="form-control tax_file" required="required" name="tax_file_id" class="tax_file_name">
                                @foreach($form_names as $name)
                                <option value="{{$name->id}}">{{$name->tax_file_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="date">Date</label>
                        <div class="col-sm-9">
                            <input class="form-control datepicker" name="year" id="year" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="status">Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" required="required" name="status" id="status" >
                                <option value="1">Active</option>
                                <option value="0">Pending</option>
                            </select>
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





<div class="modal fade" id="serviceEditFormUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
                <h4 class="modal-title" id="">Update Form </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="formsUpdateForm"  method="get">
                    <input type="hidden" name="form_edit_id" id="form_edit_id" value="">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="update_form_category_id">Type</label>
                        <div class="col-sm-9">
                            <select class="form-control category" required="required" name="category_id" id="update_form_category_id"  >
                             @foreach($FormCategory as $category)
                             <option value="{{$category->id}}">{{$category->category_name}}</option>
                             @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Name</label>
                        <div class="col-sm-9">
                            <select class="form-control tax_file" required="required" name="tax_file_id" id="tax_file_name">
                                @foreach($form_names as $name)
                                <option value="{{$name->id}}">{{$name->tax_file_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="date">Date</label>
                        <div class="col-sm-9">
                            <input class="form-control datepicker" name="year" id="form_update_year" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="status">Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" required="required" name="status" id="form_update_status" >
                                <option value="1">Active</option>
                                <option value="0">Pending</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-primary pull-right" >Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="form_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
                <h4 class="modal-title" id="">Add More </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                <form class="form-horizontal" id="forms_info_add"  method="post">
        <input type="hidden" name="forms_info_id" id="forms_info_id" >
        {{csrf_field()}}
        <div class="col-md-6 ">
            <div class="card">
                <div class="card-body">

                    <fieldset>
                        <legend>Dates:</legend>
                        <div class="form-group">
                            <label class="control-label col-md-6">Date delivered:</label>
                            <div class="col-md-6">
                                <input class="form-control datepicker" name="Date_delivered" id="Date_delivered" value="" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Date obtained<small> from authorities</small></label>
                            <div class="col-md-6">
                                <input  class="form-control datepicker" name="Date_obtained" id="Date_obtained" value="">
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="card">
                <div class="card-body">
                    <fieldset>
                        <legend>Comments:</legend>
                        <textarea class="form-control" name="Comments" rows="4" id="Comments"
                        ></textarea>
                    </fieldset><br>

                </div>
            </div>
        </div>


            <div class="col-md-12">
                <button type="submit" class="btn btn-primary pull-right">
                    Submit
                </button>
 </div>
    </form>
</div>
            </div>
        </div>
    </div>
</div>




<div class="col-md 12">

        <a href="#" data-toggle="modal" class="btn btn-primary" data-target="#formsModal" title="Add"><i class="fa fa-plus-square-o"> Add New</i></a>

</div>
 <div>
    <form action="{{route('companyServiceFormEdit')}}" method="post">
        {{csrf_field()}}
        <div class="table-responsive">
            <table class="table table-bordered searchTable">
                <thead>
                    <tr class="btn-primary-th">
                        <th>Type</th>
                        <th>IR</th>
                        <th>Year</th>
                        <th>Status</th>
                        <th>Operations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($forms_list as $list)
                    <tr>
                        <td>{{$list->getType->category_name}}<input type="hidden" id="update_value_{{$list->id}}" value="{{$list->id}}"></td>
                        <td>{{$list->getIR->tax_file_name}}</td>
                        <td>{{Carbon\Carbon::parse($list->Year)->format('d/m/Y')}}</td>
                        <td>{{$list->status}}</td>
                        <td><center><div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" data-toggle="modal"  data-year="{{Carbon\Carbon::parse($list->Year)->format('d/m/Y')}}" data-id="{{$list->id}}" class="editForm" title="Add">Edit</a></li>
                                    <li><a href="#" class="forms_info" data-id="{{$list->id}}">Add/View dates</a></li>
                                </ul>
                            </div></center>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
</div>



<div id="more-formsinfo-holder">

</div>


<script type="text/javascript">
    jQuery('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        orientation: 'bottom',
        todayHighlight: true,
    });

    jQuery('.date-own').datepicker({
        minViewMode: 2,
        orientation: 'bottom',
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy'
    });

    jQuery(document).ready(function() {
        jQuery('.search-table').DataTable(
        {
            "aoColumnDefs": [{ "bSortable": false, "aTargets": [1,2,3,6]}],
        });
    });


</script>
