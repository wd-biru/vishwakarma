<table class="table table-bordered table-hover search-table" id="freshStoreGroup">
    <thead>
    <tr class="t-head">
        <th>Material Name </th>
        <th>Material Unit</th>
        <th>Select</th>
    </tr>
    </thead>

    <tbody>
        @if($mat_itam_list->count()>0)
            @foreach($mat_itam_list as $value)
                <tr>
                    <td><input type="hidden" name="item_id" value="{{$value->id}}">{{$value->material_name}}</td>
                    <td>{{$value->material_unit}}</td>
                    <td><input id="chkListItem" type="checkbox" onchange="doalert(this);"  value="{{$value->id}}" class="chkclick"               @if($chkIndentItem->count()>0)@foreach($chkIndentItem as $list) @if($list->item_id == $value->id) checked disabled @endif @endforeach @endif></td>
                           
                </tr>
            @endforeach
        @endif
    </tbody>
</table>







