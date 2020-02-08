
@extends('layout.app')
@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-retweet"></i>&nbsp;Employee Leaves Status</h1>
    </div>
    <div>
        <ul class="breadcrumb">
         <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
          <li><a href="#">Employees Leave Status</a></li>
        </ul>
    </div>
</div>
@endsection
@section('content')
@section('content')
@include('includes.msg')


    <div class="row">
    <div class="col-md-12">

           <div class="content-section">
               <div class="table-responsive">
                <table class="table table-bordered  main-table search-table "  >
                    <thead class="table-primary">
                        <tr class="btn-primary-th">

                          <th>S.No.</th>
                          <th>Employee ID</th>
                          <th>Employee Name</th>
                          <th>Leave Type</th>
                          <th>Leave start date</th>
                          <th>Leave End Date</th>
                          <th>Leave Reason</th>
                          <th>No of Day</th>
                          <th>Status</th>

                        </tr>
                    </thead>
                    <tbody><input type="hidden" name="" value="{{$i = 1}}">
                      @foreach($leave_data as $data)
                           <tr>
	                          <td>{{$i++}}</td>
	                          <td>{{$data->employee_id}}</td>
	                          <td>{{$data->getEmployee->first_name}} {{$data->getEmployee->last_name}}</td>
	                          <td>{{$data->getLeaveType->leave_type}}</td>
	                          <td>{{$data->start_date}}</td>
	                          <td>{{$data->end_date}}</td>
	                          <td>{{$data->reason}}</td>
	                          <td>{{$data->no_of_day}}</td>
	                          <td>approved</td>
                          </tr>
                         @endforeach
                    </tbody>
                </table>
              </div>
            </div>
        </div>
    </div>
</div>





@endsection

@section('script')

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('.example').DataTable();
    });
</script>

@endsection
