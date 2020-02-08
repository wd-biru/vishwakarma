<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Assets Data</h2>
  <h3><a href="{{URL('/assetForm')}}"> Go Insert Asset Data </a></h3>
      <table border="1">
         <tr>
            <th>ID</th>
            <th>Portal Id</th>
            <th>Asset Name</th>
            <th>Model Number</th>
            <th>Chassis Number</th>
            <th>Purchase Date</th>
            <th>Insurance Expire</th>
            <th>Insurance Valide Till</th>
            <th>Tax Policy Number</th>
            <th>Tax Valid Till</th>
            <th>Tax Expire Date</th>
            <th>Action </th>
            
         </tr>

       @foreach($users as $user)
         <tr>
            <td>{{$user['id']}}</td>
            <td>{{$user['portal_Id']}}</td>
            <td>{{$user['asset_name']}}</td>
            <td>{{$user['modelno']}}</td>
            <td>{{$user['c_number']}}</td>
            <td>{{$user['p_date']}}</td>
            <td>{{$user['i_exprire']}}</td>
            <td>{{$user['i_valid']}}</td>
            <td>{{$user['text_policy_num']}}</td>
            <td>{{$user['tax_valid_till']}}</td>
            <td>{{$user['tax_expite_date']}}</td>
            <td>
                <a href="{{URL('editdata',base64_encode(convert_uuencode($user['id'] )))}}">
                  <button type="button" class="btn btn-primary">Edit</button>
                </a> 
                
                &nbsp&nbsp&nbsp
                <a href="{{URL('deletePortaldata',base64_encode(convert_uuencode($user['id'] ))) }}" >
                  <button type="button" class="btn btn-danger">Delete</button>
               </a>
            </td>            
        </tr>
        @endforeach
</div>



</body>
</html>
