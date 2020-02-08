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
           <select id="country" name="activity_group_id" class="form-control" >
                <option value="" selected disabled>Select</option>
                  @foreach($countries as $key => $country)
                  <option value="{{$key}}"> {{$country}}</option>
                  @endforeach
           </select>
    </div>

    <div class="form-group">
       <label for="pwd">Sub Activity Work Name</label>
           <select id="state" name="sub_activity_works_id" class="form-control" >
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



<script type="text/javascript">
    $('#country').change(function(){
    var countryID = $(this).val();
    //alert(countryID);
    if(countryID){
        $.ajax({
           type:"GET",
           url:"{{url('subactivityworksList')}}?country_id="+countryID,
           //data: "namee",
           success:function(res){               
            if(res){
                $("#state").empty();
                $("#state").append('<option>Select</option>');
                $.each(res,function(key,value){
                    $("#state").append('<option value="'+key+'">'+value+'</option>');
                });
           
            }else{
               $("#state").empty();
            }
           }
        });
    }else{
        $("#state").empty();
    }      
   });

</script>

</body>
</html>
