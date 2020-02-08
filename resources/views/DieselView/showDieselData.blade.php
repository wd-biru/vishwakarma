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
  <h3><a href="{{URL('/assetServiceForm')}}"> Go Insert Asset Data </a></h3>
      <table border="1">
         <tr>
            <th>Diesel Id</th>
            <th>Service Id</th>
            <th>Service Due Date</th>
            <th>Dual On Type</th>
            <th>Valid Details</th>
            <th>Portal Id</th>
            <th>Action</th>
            
         </tr>

       @foreach($users as $user)
         <tr>
            <td>{{$user['diesel_id']}}</td>
            <td>{{$user['service_id']}}</td>
            <td>{{$user['service_due_date']}}</td>
            <td>{{$user['due_on_type']}}</td>
            <td>{{$user['v_details']}}</td>
            <td>{{$user['portal_id']}}</td>
            <td>
                <a href="{{URL('editServiceData',base64_encode(convert_uuencode($user['id'] )))}}">
                  <button type="button" class="btn btn-primary">Edit</button>
                </a> 
                
                &nbsp&nbsp&nbsp
                <a href="{{URL('deleteServiceData',base64_encode(convert_uuencode($user['id'] ))) }}" >
                  <button type="button" class="btn btn-danger">Delete</button>
               </a>
            </td>            
        </tr>
        @endforeach
</div>



</body>
</html>
