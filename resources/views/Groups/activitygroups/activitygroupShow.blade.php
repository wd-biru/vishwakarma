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
<h3><a href="{{URL('/activity')}}"> Go Insert Asset Data </a></h3>
      <table border="1">
         <tr>
            <th>Activity Group Id</th>
            <th>Portal Id</th>
            <th>Activity Group</th>
            <td>Action </td>
         </tr>

       @foreach($users as $user)
         <tr>
            <td>{{$user['id']}}</td>
            <td>{{$user['portal_id']}}</td>
            <td>{{$user['activity_group']}}</td>
            <td>
                <a href="{{URL('editActivity',base64_encode(convert_uuencode($user['id'] )))}}">
                  <button type="button" class="btn btn-primary">Edit</button>
                </a> 
                
                &nbsp&nbsp&nbsp
                <a href="{{URL('deleteActivity',base64_encode(convert_uuencode($user['id'] ))) }}" >
                  <button type="button" class="btn btn-danger">Delete</button>
               </a>
            </td>            
        </tr>
        @endforeach
</div>



</body>
</html>
