@extends('layout.app')
@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-user-circle"></i>&nbsp;Employee Management</h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
            <li><a href="#">Time Sheet</a></li>
        </ul>
    </div>
</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="content-section">
            @if(isset($time_sheet_list) && !empty($time_sheet_list))
            <div class="table-responsive ">
            <table  class="table table-bordered " id="FlagsExport">
                 <thead>
                    <tr class="btn-primary-th">
                        <th>Sr. No</th>
                        <th>Client Name</th>
                        <th>Employee Name</th>
                        <th>Task Type</th>
                        <th>Comment</th>
                        <th>Start Date</th>
                        <th>Created Date</th>
                        <th>Working Hour</th>

                    </tr>
                </thead>
                <tbody><?php $i=1;?>
                    @foreach($time_sheet_list as $sheet_list)

                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$sheet_list->getClientName->Client_name}}</td>
                            <td>@if($sheet_list->getEmployeeName!=null){{ucfirst($sheet_list->getEmployeeName->first_name)}} {{$sheet_list->getEmployeeName->last_name}} @endif</td>
                            <td>{{$sheet_list->work_type}}</td>
                            <td>{{$sheet_list->comment}}</td>
                            <td>{{Carbon\Carbon::parse($sheet_list->from_date)->format('d/m/Y')}}</td>
                            <td>{{Carbon\Carbon::parse($sheet_list->created_at)->format('d/m/Y')}}</td>
                            <td>{{$sheet_list->hour}} Hour</td>

                        </tr>
                   @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection
@section('script')


  <!--   <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>-->
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <!-- <script src="http://localhost/acc-nextweb/public/js/dataTables.buttons.min.js"></script> -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#FlagsExport').DataTable({
            "language": {
      "emptyTable": "No data available "
    },

            dom: 'Bfrtip',
            buttons: [{extend: 'excel',className: 'btn btn-primary',text: 'Export in Excel', footer: true , filename: 'Acc-Next Time Sheet of Employee'}]
        });



    });
</script>
@endsection
