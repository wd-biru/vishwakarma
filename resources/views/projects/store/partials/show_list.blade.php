<table class="table table-bordered table-hover search-table" id="itemListGroup">
    <thead>
    <tr class="t-head">
        <th>Material Name </th>
        <th>Material Unit</th>
        <th>Material Qty</th>
    </tr>
    </thead>
    <tbody>

        @if($mat_sort_list->count()>0)
            @foreach($mat_sort_list as $value)

                <tr>
                    <td>{{$value->material_name}}</td>
                    <td>{{$value->material_unit}}</td>
                    <td>{{$value->item_qty}}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>




