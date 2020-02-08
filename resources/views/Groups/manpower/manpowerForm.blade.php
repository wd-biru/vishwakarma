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

<div class="container-fluid">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6 ">
      

  <h2>Man Power Entry Form</h2>
  <h3><a href="{{URL('/manPowerShow')}}">Show Man Power</a></h3>
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


  <form action="{{URL('/manPowerStore')}}" method="POST">
    @csrf

   <!--  <div class="form-group">
      <label for="email">Portal_Id</label>
      <input type="text" class="form-control" id="portal_Id" placeholder="Enter Portal_Id Name" name="portal_Id">
    </div> -->
    
    <div class="form-group">
      <label for="pwd">Man Power Type</label>
      <input type="text" class="form-control" id="man_power_type" placeholder="Enter Your Man Power" name="man_power_type">
    </div>
    
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
    </div>

    <div class="col-md-3"></div>
  </div>
</div>

</body>
</html>
