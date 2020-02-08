<table class="table table-bordered table-hover search-table" id="freshStoreGroup">
    <thead>
    <tr class="t-head">
        <th>Material Name </th>
        <th>Material Unit</th>
        <th>Price</th>
        <th>Effective Date</th>
    </tr>
    </thead>
    <tbody>
        @if($mat_itam_list->count()>0)
            @foreach($mat_itam_list as $value)
                <tr>
                    <td> <input type="hidden" name="item_id[]" value="{{$value->id}}">{{$value->material_name}}</td>
                    <td>{{$value->material_unit}}</td>
                    <td> @if($getVendorItemPrice->count()>0) 
                         @foreach($getVendorItemPrice as $list) @if($list->item_id == $value->id){{$list->price}} @endif @endforeach @endif</td>
                    <td> @if($getVendorItemPrice->count()>0)@foreach($getVendorItemPrice as $list) @if($list->item_id == $value->id) {{date('d/m/Y',strtotime($list->effective_date))}} @endif @endforeach @endif</td>              

                </tr>
            @endforeach
        @endif
    </tbody>
</table>


