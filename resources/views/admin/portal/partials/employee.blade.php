<div class="  table-responsive ">
    <table class="table table-bordered main-table search-table " >
        <thead>
            <tr class="btn-primary">
                <th>Sr No.</th>
                <th>Employee Name</th>
                <th>Email</th>
                <th>Contact No.</th>
                <th>Gender</th>
                <th>Other Phone</th>
                <th>Address</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($employees))
            <?php $i=1?>
            @foreach($employees as $list)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$list->first_name}} {{$list->last_name}}</td>
                <td>{{$list->getUserDetails->email}}</td>
                <td>{{$list->phone}}</td>
                <td>{{$list->gender}}</td>
                <td>{{$list->other_phone}}</td>
                <td>{{$list->address}}</td>
                <td>@if($list->status==1)
                    <img src="{{ my_asset('images/activate.png') }}">
                @else
                    <img  src="{{my_asset('images/deactivate.png')}}">
                @endif</td>
            </tr>
            @endforeach     
            @endif              
        </tbody>
    </table>
</div>