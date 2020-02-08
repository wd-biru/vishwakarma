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
                    <td> <input type="hidden" name="item_id[]" value="{{$value->id}}">{{$value->material_name}}</td>
                    <td>{{$value->material_unit}}</td>
                    <td><input class="form-control" type="text" name="qty[]" @if($getInventoryQuantity->count()>0) 
                        @foreach($getInventoryQuantity as $list) @if($list->item_id == $value->id)  value="{{$list->qty}}" @endif @endforeach @endif" placeholder="Quantity">
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>


@section('script')



    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>





        


@endsection





