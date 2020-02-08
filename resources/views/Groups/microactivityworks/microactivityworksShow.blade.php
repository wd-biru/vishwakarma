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
<h3><a href="{{URL('/microactivityworks')}}">Insert Micro Activity Works</a></h3>
      <table border="1">
         <tr>
            <th>Id </th>
            <th>Portal Id</th>
            <th>Activity Group Id</th>
            <th>Micro Activity Work </th>
            <th>Action </th>
         </tr>

       @foreach($user as $users)
         <tr>
            <td>{{$users['id']}} </td>
            <td>{{$users['portal_id']}}</td>
            <td>{{$users['activity_group_id']}}</td>
            <td>{{$users['micro_activity_work']}}</td>
            <td>
                <a href="{{URL('microactivityworksEdit',base64_encode(convert_uuencode($users['id'] )))}}">
                  <button type="button" class="btn btn-primary">Edit</button>
                </a> 
                
                &nbsp&nbsp&nbsp
                <a href="{{URL('microactivityworksDelete',base64_encode(convert_uuencode($users['id'] ))) }}" >
                  <button type="button" class="btn btn-danger">Delete</button>
               </a>
            </td>            
        </tr>
        @endforeach
</div>



</body>
</html>
