<html>

<link href="{{my_asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
 <style>
table{border:1px solid;}
td{padding-left: 5px; border:1px solid #d4d4d4; }
th{border:1px solid #d4d4d4; }
.move-right{float:right;}

</style>
<body style="font-size: 11px">

 <center>
<table width="544" style="border:0px;">
<tr>
@if($invoice_to_data->logo_img!=null)
<td width="150" style="border:0px">
<img src="{{asset('public/uploads/company_images/'.$invoice_to_data->logo_img)}}" width="80" height="80">
</td>
@else
<td width="150" style="border:0px"></td>
@endif
<td width="272" style="border:0px" ><h4>PURCHASE ORDER</h4></td>
</tr>
</table>
</center>
<center>
<table width="544" height="auto">
  <tr>
    <td width="auto" rowspan="3"><b>Invoice To</b>
      <p>{{$invoice_to_data->company_name}}<br />
          <span>{{$invoice_to_data->company_address}}<br/>
          GSTIN/UIN: {{$invoice_to_data->gstn_uin}}<br /> 
          State Name: {{$invoice_to_data->name}}, Code: {{$invoice_to_data->gstcode}}<br />
          CIN: {{$invoice_to_data->cin}}
          <br />
      Email: {{$invoice_to_data->company_mail}}</span> </p></td>
    <td width="auto"><b>Voucher No</b> : {{$voucher_no}}</td>
    <td width="auto" height="55"><b>Dated</b> : {{date("d/m/Y", strtotime($supplier_data->date))}}</td>
  </tr>
  <tr>
    <td height="45">&nbsp;</td>
    <td height="45"><b>Mode/Terms of Payment : {{$supplier_data->mode_payment}} </b></td>
  </tr>
  <tr>
    <td height="45"><b>Supplier's Ref / Order No.</b> : {{$purchase_order_no}} </td>
    <td height="45"><b>Other Reference(S):</b> </td>
  </tr>
  
  <tr>
    <td rowspan="2"><b>Supplier</b>
      <p>{{$supplier_data->company_name}}<br />
    <span>{{$supplier_data->address}}<br />{{$supplier_data->cityname}}<br /> {{$supplier_data->statename}}-{{$supplier_data->pincode}}<br />
    GSTIN/UIN : {{$supplier_data->gstn_uin}}<br /> STATE NAME:{{$supplier_data->statename}}, Code: {{$supplier_data->gstcode}}
    </span>
    </p></td>
    <td><b>Dispatch through : BY ROAD <b></td>
    <td><b>Destination:</b>  </td>
  </tr>
  <tr>
    <td height="50" colspan="2"><b>Terms of Delivery: Freight on Road. (FOR)</b> </td>
  </tr>
</table>

<br>
<table width="544" height="auto">
  <tr>
    <th width="auto">SR. No. </th>
    <th width="auto">Description Of Goods </th>
    <th width="auto">Due on </th>
    <th width="auto">Quantity</th>
    <th width="auto">Rate</th>
    <th width="auto">Tax Rate %</th>
    <th width="auto">Per</th>
    <th width="auto">Disc % </th>
    <th width="auto">Amount</th>
  </tr>
   <?php  $total_amount = 0;
   $tax = 0; ?>

   <?php 

      $amount = 0;
      $fright_charge = 0;
      $load_unload = 0;
      $kata_parchi = 0;
     
    ?>



      <?php $i=1;?>
  @foreach($items as $list)
  <tr>
    <td>{{$i++}}</td>
    <td>{{$list->material_name}}</td>
    <td>{{date("d/m/Y", strtotime($supplier_data->date))}}</td>
    <td><?php echo (int)$list->qty ?></td>
    <td><?php echo (int)$list->price ?></td>
    <td><?php echo (int)$list->tax_rate ?></td>
    <td>{{$list->unit}}</td>
    <td>&nbsp;</td>
   <?php  


        $amount =  $list->qty * $list->price;
        $total_amount = $total_amount + $list->qty * $list->price; 

        $fright_charge = $list->freight;
        $load_unload = 0 + $list->loading;
        $kata_parchi = 0 + $list->kpcharges;



    ?>

    <?php

    if($invoice_to_data->gstcode==$supplier_data->gstcode)
    {
       $tax = (($total_amount * $list->tax_rate)/100)/2;
       $fright_charge_tax =  ($list->freight * 18/100)/2;
    }
    else
    {
       $tax = ($total_amount * $list->tax_rate)/100;
       $fright_charge_tax =  ($list->freight * 18/100);
    }



    ?>

    <td><span class="move-right">{{number_format($amount, 2)}}</span> </td>
  </tr>
  @endforeach
  <tr>
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="move-right">{{number_format($total_amount, 2)}}</span></td>
  </tr>


      <tr>
    <td>&nbsp;</td>
    <td><span style="float:right;">Fright Charges</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td><span class="move-right">{{number_format($fright_charge, 2)}}</span></td>
    </tr>

    <tr>
    <td>&nbsp;</td>
    <td><span style="float:right;">Load/Unload</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td><span class="move-right">{{number_format($load_unload, 2)}}</span></td>
    </tr>

    <tr>
    <td>&nbsp;</td>
    <td><span style="float:right;">Kata Parchi</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td><span class="move-right">{{number_format($kata_parchi, 2)}}</span></td>
    </tr>

 

@if($invoice_to_data->gstcode==$supplier_data->gstcode)
  <tr>
    <td>&nbsp;</td>
    <td><span class="move-right">INPUT CGST</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td><span class="move-right">{{number_format($tax + $fright_charge_tax, 2)}}</span></td>
    <?php        
           DB::table('vishwa_purchase_order')->where('purchase_order_no',$purchase_order_no)->update(['cgst'=>$tax]);
    ?>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span style="float:right;">INPUT SGST</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td><span class="move-right">{{number_format($tax + $fright_charge_tax, 2)}}</span></td>
        <?php
       
           DB::table('vishwa_purchase_order')->where('purchase_order_no',$purchase_order_no)->update(['sgst'=>$tax]);
        
         ?>

  </tr>
  @else
    <tr>
    <td>&nbsp;</td>
    <td><span style="float:right;">INPUT IGST</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td><span class="move-right">{{number_format($tax + $fright_charge_tax, 2)}}</span></td>
    <?php

           DB::table('vishwa_purchase_order')->where('purchase_order_no',$purchase_order_no)->update(['igst'=>$tax]);
     ?>
  </tr>

  @endif





  <tr>
    <td>&nbsp;</td>
    <td><span style="float:right;"><strong>TOTAL</strong></span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
     @if($invoice_to_data->gstcode==$supplier_data->gstcode)
    {
      <td><span class="move-right"><strong>RS.</strong>{{number_format($fright_charge + $load_unload + $kata_parchi + $total_amount + 2*$tax + 2*$fright_charge_tax, 2)}}</span> </td>

    }
    @else
    {
    <td><span class="move-right"><strong>RS.</strong>{{number_format($fright_charge + $load_unload + $kata_parchi + $total_amount + $tax + $fright_charge_tax, 2)}}</span> </td>
    }
    @endif
    
  </tr>
</table>
<br>
<table width="544" height="auto">
  <tr>
    <td width="auto"><p>Amount Chargeable (in words)</p>
     <b><?php echo $total_amount = convertToIndianCurrency($total_amount + $fright_charge_tax + $tax + $fright_charge + $load_unload +$kata_parchi); ?></b></td>
    </tr>
  <tr>
    <td height="50">&nbsp;</td>
    </tr>
  
  <tr>
    <td><b>Company's VAT TIN</b> : {{$invoice_to_data->vat_tin}} </td>
    </tr>
  <tr>
    <td><b>Company's CST No.</b> : {{$invoice_to_data->cst_no}} </td>
    </tr>
  <tr>
    <td><b>Company's Service Tax No.</b> : {{$invoice_to_data->service_tax_no}} </td>
    </tr>
  <tr>
    <td height="30"><b>Company's PAN:</b> {{$invoice_to_data->pan}} </td>
    </tr>
  <tr>
    <td height="67"><span class="move-right" style="margin-right: 10px">For <b>{{$invoice_to_data->company_name}}</b></span> </td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</center>
</body>
</html>
<?php
function convertToIndianCurrency($number) {
    $no = round($number);
    $decimal = round($number - ($no = floor($number)), 2) * 100;    
    $digits_length = strlen($no);    
    $i = 0;
    $str = array();
    $words = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety');
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;            
            $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
        } else {
            $str [] = null;
        }  
    }
    
    $Rupees = implode(' ', array_reverse($str));
    $paise = ($decimal) ? "And Paise " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])  : '';
    return ($Rupees ? 'Rupees ' . $Rupees : '') . $paise . " Only";
}

?>