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
<h3><a href="{{URL('/manPower')}}">Insert Man Power Data</a></h3>
      <table border="1">
         <tr>
            <th>Id</th>
            <th>Portal Id</th>
            <th>Man Power Type</th>
            <td>Action </td>
         </tr>

       @foreach($user as $user)
         <tr>
            <td>{{$user['id']}}</td>
            <td>{{$user['portal_id']}}</td>
            <td>{{$user['man_power_type']}}</td>
            <td>
                <a href="{{URL('manPowerEdit',base64_encode(convert_uuencode($user['id'] )))}}">
                  <button type="button" class="btn btn-primary">Edit</button>
                </a> 
                
                &nbsp&nbsp&nbsp
                <a href="{{URL('manPowerDelete',base64_encode(convert_uuencode($user['id'] ))) }}" >
                  <button type="button" class="btn btn-danger">Delete</button>
               </a>
            </td>            
        </tr>
        @endforeach
</div>



</body>
</html>
