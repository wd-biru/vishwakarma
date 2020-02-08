@if(isset($client_list) and (count($client_list) > 0 ))

            <div class="  table-responsive  "style="overflow-x: inherit!important;
    min-height: 0.01%;">
                <table class="table table-bordered main-table search-table " >
                    <thead class="table-primary">
                        <tr class="btn-primary-th">
                            <th>Sr. No</th>
                            <th>Client Name</th>
                            <th>Source</th>
                            <th>Group</th>
                            <th>Registration No</th>
                            <th>Type</th>
                            <th>File</th>
                            <th>Box File</th>
                            <th>Status</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody"><?php $i=1;?>
    @foreach($client_list as $list)
    <tr>

        <td>{{$i++}}</td>
        <td><a href="{{route('companyShow',[base64_encode($list->id)])}}">{{$list->Client_name}}</a></td>
        <td>{{$list->Source}}</td>
        <td>{{$list->Group}}</td>
        <td>{{$list->Registration_No}}</td>
        <td>{{$list->Type}}</td>
        <td>{{$list->File_No}}</td>
        <td>{{$list->Box_No}}</td>
        <td class="table-status">
            @if($list->Status==1)
                <img src="{{ my_asset('images/activate.png') }}">
            @else
                <img class="change_status"  src="{{my_asset('images/deactivate.png')}}">
            @endif
        <td>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" style="width: 20px;">
                    <li><a href="{{route('companyShow',[base64_encode($list->id)])}}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp; View</a></li>
                    <li><a href="company/edit/{{base64_encode($list->id)}}"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp; Edit</a></li>

                </ul>
            </div>
        </td>
    </tr>
    @endforeach
</tbody>
                </table>
            </div>
@endif
