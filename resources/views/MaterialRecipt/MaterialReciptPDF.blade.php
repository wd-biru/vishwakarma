<html>

<link href="{{my_asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
 <style>
table{border:1px solid; text-align: center !important;}
td{padding-left: 5px; border:1px solid #d4d4d4; text-align: center !important; }
th{border:1px solid #d4d4d4; }
.move-right{float:right;}

</style>
<body>
 
 <center>
<table width="544" style="border:0px;">
<tr>
@if($vendor_data->logo_img!=null)
<td width="50" style="border:0px">
<img src="{{asset('public/uploads/company_images/'.$vendor_data->logo_img)}}" width="80" height="80">
</td>
@else
<td width="150" style="border:0px"></td>
@endif
<td width="272" style="border:0px" >
  <h5 class="text-align" style="margin-left: 20px !important;"><strong>INWARD-GOODS / ASSETS</strong></h5><
  <h3  style="text-align: center;"><strong>{{$vendor_data->company_name}}</strong></h3>
  <span style="display:block; font-size:12px; font-weight: 600;">{{$vendor_data->address}},{{$vendor_data->state_name}}</span>
  <p class="text-align" style="font-size: 11px;"><strong>Cell: </strong>{{$vendor_data->mobile}} <strong>Tele: </strong> {{$vendor_data->company_mobile}}, <strong>Email: </strong>{{$vendor_data->company_mail}}</p>
</td>
</tr>
</table>
</center>
<br>
<br>



<p><span><strong>M.R. No.</strong><?php echo($mr_reciept) ?></span><span style="float:right"><strong>Date:</strong>{{$mr_date}}</span></p>
<p><strong>Name Of Supplier & Address:</strong> {{$vendor_data->vendor_com_name}}</p>
<p><span><strong>Mode Of Transport:  </strong> Truck (22 Tyer)</span><span style="float:right"><strong>Vechicle No.:</strong>{{$vendor_data->tracker_no}}</span></p>
<p><span><strong>Bill / Challan No.:</strong> {{$vendor_data->challan_no}}</span><span style="float:right"><strong>Form No.:</strong>{{$form_no}}</span></p>
<p><span><strong>Gate Entry No.:</strong>{{$gate_entry}}</span>
  <span style="float: right; "><strong >Arrival Time:</strong>{{date("g:i a", strtotime($arrival_time))}}</span>
  </p>
<p>
  <span><strong >Site:</strong> {{$vendor_data->project_name}}  ({{$vendor_data->store_name}})</span>
  <span  style="float:right"><strong>Master Ledger Folio No.:</strong>{{$master_ledger_folio_no}}</span>
  </p>
 
<center>
<table width="544" border="0">
  <tr>
    <th width="auto">SR. No. </th>
    <th width="auto">Item</th>
    <th width="auto">Qty.</th>
  </tr>
  <?php $i=1;?>
 @foreach($form_data as $key => $list)
  <tr>
    <td>{{$i++}}</td>
    <?php   $item  =  DB::table('vishwa_materials_item')->where('id',$key)->first();  ?>
    <td>{{$item->material_name}}</td>
    <td>{{$list}}</td>
  </tr>
  @endforeach
  
</table>
</center>
<br>
<br>
<br>
<p style="font-weight:600;"><span>Sign. Matetial Supplier</span> <span style="margin: 0 199px;">Sign. Store Keeper</span> <span style="float:right;">Auth. Signatory</span></p>
<p><strong>Remark :</strong> </p>
<p><strong>Note:</strong></p>
</body>



</html>
