<table class="table table-bordered table-hover search-table" id="freshStoreQuantity">
    <thead>
    <tr class="t-head">
        <th>Material Name </th>
        <th>Material Unit</th>
        <th>Quantity</th>
    </tr>
    </thead>
    <tbody>

        @if($mat_itam_list->count()>0)
            @foreach($mat_itam_list as $value)
                <tr>
                    <?php $unit_name = DB::table('vishwa_unit_masters')->where('id',$value->material_unit)->first();?>
                    <td>{{$value->material_name}}</td>
                    <td>{{$unit_name->material_unit}}</td>
                    <td>{{$value->availableQty}}</td>
                    
                </tr>
            @endforeach
        @endif
    </tbody>
</table>




