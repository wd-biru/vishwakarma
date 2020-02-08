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
      

  <h2>Micro Activity Work Form</h2>
  <h3><a href="{{URL('/microactivityworksShow')}}">Show Micro Activity Works Lists</a></h3>
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


  <form action="{{URL('/microactivityworksStore')}}" method="POST">
    @csrf

   <!--  <div class="form-group">
      <label for="email">Portal_Id</label>
      <input type="text" class="form-control" id="portal_Id" placeholder="Enter Portal_Id Name" name="portal_Id">
    </div> -->
    

<!--  <div class="form-group">
      <label for="pwd">Activity Groups Name</label>
      <input type="text" class="form-control" id="activity_group_id  " placeholder="Enter Groups Name" name="activity_group_id">
    </div>

 -->
    <div class="form-group">
      <label for="pwd">Activity Group Name</label>
           <select id="activity_group_id" name="activity_group_id" class="form-control" >
                <option value="" selected disabled>Select</option>
                  @foreach($activity_group as $key => $activity)
                  <option value="{{$key}}"> {{$activity}}</option>
                  @endforeach
           </select>
    </div>

    <div class="form-group">
      <label for="pwd">Micro Activity Works </label>
      <input type="text" class="form-control" id="micro_activity_work" placeholder="Enter Mirco Works" name="micro_activity_work">
    </div>
    
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
    </div>

    <div class="col-md-3"></div>
  </div>
</div>

</body>
</html>
