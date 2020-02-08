<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style type="text/css">
    .col-sm-06 {
    width: 50%;
}
  </style>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
  <h2>Update Asset Services form</h2>

  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
          <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


  <form action="{{URL('/updateServicesData')}}" method="POST">
    @csrf
     <div class="form-group">
      <label for="email">Diesel Id:</label>
      <input type="text" class="form-control" id="diesel_id" placeholder="Enter Diesel Id" name="diesel_id" value="{{$data['diesel_id']}}">
    </div>

    <input type="hidden" name="user_id" value="{{$data['id']}} ">
   
    <div class="form-group">
      <label for="pwd">Service Id:</label>
      <input type="text" class="form-control" id="service_id" placeholder="Enter Service Id" name="service_id" value="{{$data['service_id']}}" >
    </div>

    <div class="form-group">
      <label for="email">Service Due Date:</label>
      <input type="date" class="form-control" id="service_due_date" placeholder="Enter Servise Due Date" name="service_due_date" value="{{$data['service_due_date']}}" >
    </div>
    <div class="form-group">
      <label for="email">Due On Type</label>
      <input type="text" class="form-control" id="due_on_type" placeholder="Enter Due On Type" name="due_on_type" value="{{$data['due_on_type']}}" >
    </div>

    <div class="form-group">
      <label for="email">Valid Detail</label>
      <input type="text" class="form-control" id="v_details" placeholder="Enter Valid Details Information" name="v_details" value="{{$data['v_details']}}" >
    </div>
   
   <div class="form-group">
      <label for="email">Portal_Id</label>
      <input type="text" class="form-control" id="portal_id" placeholder="Enter Portal_Id Name" name="portal_id" value="{{$data['portal_id']}}" >
    </div>
    
    <button type="submit" class="btn btn-default">Update</button>
  </form>
    </div>


  <div class="col-sm-3"></div>
</div>
</div>
</body>
</html>
