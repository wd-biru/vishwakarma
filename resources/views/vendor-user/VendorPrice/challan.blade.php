<html>
<head>
<title>Challan Book :{{$item->challan_no}}</title>
<style>
body{
  margin: 0 10px;
}

td{padding-left: 5px; border:1px solid #d4d4d4; text-align: center !important; }
th{border:1px solid #d4d4d4;}
th, td{text-align:center;}
</style>

</head>



<body>
<center>
<h3 class="text-align"><strong>Challan Book</strong></h3>
 <h1 class="text-align">{{$item->company_name}}</h1>
 <?php $state_name = DB::table('vishwa_states')->where('id',$item->state)->first();?>
 <h4 class="text-align">{{$item->address}}({{$state_name->name}}).</h4>
</center>
 <p><span><strong>Mobile No.</strong>{{$item->mobile}}</span> <span style="float:right"><strong>Vehicle No.</strong>{{$item->tracker_no}}</span></p>
 <p><span><strong>Challan No.</strong>{{$item->challan_no}} </span><span style="float:right"><strong>Date.</strong>{{date("d/m/Y", strtotime($item->date))}}</span></p>
 <p><strong>Company's Name.</strong>{{$item->portal_name}}</p>
 <center>
 <table width="500" height="93" >
   <tr >
     <th width="73">SR. No. </th>
     <th width="220">Particulars.</th>
     <th width="100">UOM</th>
     <th width="73">Qty.</th>
   </tr>


     <?php $i=1;?>
  @foreach($supplier_data as $list)
  <tr style="border-bottom: 1px solid #000 !important;">
    <?php $material_name = DB::table('vishwa_materials_item')->where('id',$list->item_id)->first(); ?>  
    <td>{{$i++}}</td>
    <td>{{$material_name->material_name}}</td>
    <td>{{$list->unit}}</td>
    <td>{{$list->qty}}</td>
    
  </tr>
  @endforeach
   </tr>
 </table>
</center>
<p><span>Receiver's Signature</span><span style="float:right">Auth. Signatory</span></p>
</body>



</html>
