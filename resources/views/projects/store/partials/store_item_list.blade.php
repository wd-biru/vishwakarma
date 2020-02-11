<table class="table table-bordered table-hover search-table" id="itemListGroupItem">
    <thead>
    <tr class="t-head">
        <th>Project Name</th>
        <th>Store Name</th>
        <th>Material Name </th>
        <th>Material Unit</th>
        <th>Material Qty</th>
    </tr>
    </thead>
    <tbody>



    @if($store_list->count()>0)
        @foreach($store_list as $store)
            <?php

            $mat_itam_list = DB::table('vishwa_materials_item')
                ->join('vishwa_unit_masters', 'vishwa_materials_item.material_unit', 'vishwa_unit_masters.id')
                ->join('vishwa_store_inventory_qty', 'vishwa_materials_item.id', 'vishwa_store_inventory_qty.item_id')
                ->where('vishwa_materials_item.group_id', $group_id)
                ->where('vishwa_store_inventory_qty.store_id', $store->id)
                ->where('vishwa_store_inventory_qty.item_id', $item_id)
                ->get();

            $project_name=App\Entities\Projects\Project::where('id',$store->project_id)->first();

            $mat_sort_list = DB::table('vishwa_materials_item')
                ->join('vishwa_unit_masters', 'vishwa_materials_item.material_unit', 'vishwa_unit_masters.id')
                ->join('vishwa_store_inventory_qty', 'vishwa_materials_item.id', 'vishwa_store_inventory_qty.item_id')
                ->where('vishwa_materials_item.group_id', $group_id)
                ->where('vishwa_store_inventory_qty.store_id', $store->id)
                ->where('vishwa_store_inventory_qty.item_id', $item_id)
                ->groupBy('vishwa_store_inventory_qty.item_id')
                ->get();

            foreach ($mat_sort_list as $sortValue)
            {
                $sortValue->item_qty=$mat_itam_list->where('item_id',$sortValue->item_id)->sum('qty');
                $sortValue->item_name=$mat_itam_list->where('item_id',$sortValue->item_id);
            }


            ?>
            @foreach($mat_sort_list as $value)
                <tr>
                    <td>{{$project_name->name}}</td>
                    <td>{{$store->store_name}}</td>
                    <td>{{$value->material_name}}</td>
                    <td>{{$value->material_unit}}</td>
                    <td>{{$value->item_qty}}</td>
                </tr>
            @endforeach
        @endforeach
    @endif
    </tbody>
</table>




