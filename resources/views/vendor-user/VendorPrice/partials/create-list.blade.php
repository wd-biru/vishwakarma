<table class="table table-bordered table-hover search-table" id="freshStoreGroup">
    <thead>
    <tr class="t-head">
        <th>Material Name </th>
        <th>Material Unit</th>
        @if($group_type_name->group_type_name == 'rentable')

        <th>Price per Day</th>

        @else
        <th>Price</th>
        @endif 
        <th>Effective Date</th>
    </tr>
    </thead>
    <tbody>
        @if($mat_itam_list->count()>0)
            @foreach($mat_itam_list as $value)
                <tr>
                    <td> <input type="hidden" name="item_id[]" value="{{$value->id}}">{{$value->material_name}}</td>
                    <td>{{$value->material_unit}}</td>
                    <td><input class="form-control" type="text" name="price[]" @if($getVendorItemPrice->count()>0) 
                        @foreach($getVendorItemPrice as $list) @if($list->item_id == $value->id)  value="{{$list->price}}" @endif @endforeach @endif" placeholder="Price"></td>
                    <td><input type="text" class="form-control datepicker" name="effective_date[]" @if($getVendorItemPrice->count()>0) @foreach($getVendorItemPrice as $list) @if($list->item_id == $value->id)  value="{{date('d/m/Y',strtotime($list->effective_date))}}" @endif @endforeach @endif ></td>              
                </tr>
            @endforeach
        @endif
    </tbody>
</table>




