<html>
<link href="{{my_asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
  <style type="text/css">


  </style>
  <body id="body">
<div class="container">
        <div class="row">
                <div class="col-md-2" >
                  <img src="{{url('public/images/logo1.png')}}" width="80" height="80">
                </div>
                <div class="col-md-9" style="text-align: center; ">
                    <h2>INDENT</h2>
                    <h3>{{$indent[0]->company_name}}</h3>
                </div>
        </div>
        <div class="row" style="text-align: center">
            <div class="col-md-2" ></div>
            <div class="col-md-9" >
                <p >{{$indent[0]->address}} </p>
                <p ><strong>Phone No. -</strong>{{$indent[0]->company_mobile}},<strong> Email:- </strong>{{$indent[0]->company_mail}} </p>
                <br><br><br>
                <h4>Created-By: {{$indent[0]->user_name}}</h4>
            </div>
</div>


        <br>

<div class="container">

      <table width="100%"  >

        <br>
          <tr>
              <td width="10%" style="text-align:left "><strong>Indent No.:-</strong></td><td>{{$indent[0]->indent_id}}</td>
          </tr>
        <tr>
            <td width="10%" style="text-align:left "><strong>Project Name:- </strong></td><td>{{$indent[0]->project_name}}</td>
            <td width="30%" style="text-align: right;"><strong>Date-:</strong> {{date('d-m-Y', strtotime($indent[0]->created_at))}}</td>

        </tr>
     </table> 
    <br>
  
      <table  width="100%" class="table table-bordered" >
        <tr>
            <th>Sr.</th>
            <th>Name of Item</th>
            <th>Remarks </th>
            <th>Quantity</th>
            <th>Material Unit</th>
        </tr>
            <?php $i=1;?>
        @foreach($indent as $list)
        <tr>
            <td>{{$i++}}</td>
            <td>{{$list->material_name}}</td>
            <td>@if($list->remarks ==null)

                @else
                    {{$list->remarks}}

                @endif</td>
            <td>{{$list->qty}}</td>
            <td>{{$list->unit}}</td>
        </tr>
        @endforeach
     </table>

</div>


<br>
<br>
<br>
<br>
<br>
<div class="container">
          <footer id="footer">
      <table width="100%" >
        <tr>

           <td style="text-align: center;"><b>Site Engg.</b></td>
           <td style="text-align: center;"><b>Approved By</b></td>
        </tr>
     </table>


          </footer>
</div>
  </body>
</html>
