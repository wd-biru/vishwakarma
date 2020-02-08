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
      

  <h2>Assets Information Form</h2>
     <h3><a href="{{URL('/assetFormshow')}}"> Go Show Asset Data </a></h3>

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


  <form action="{{URL('/assetFormStore')}}" method="POST">
    @csrf

    <div class="form-group">
      <label for="email">Portal_Id</label>
      <input type="text" class="form-control" id="portal_Id" placeholder="Enter Portal_Id Name" name="portal_Id">
    </div>

    <div class="form-group">
      <label for="email">Asset Name:</label>
      <input type="text" class="form-control" id="asset_name" placeholder="Enter Asset Name" name="asset_name">
    </div>
    <div class="form-group">
      <label for="pwd">Model Number:</label>
      <input type="text" class="form-control" id="modelno" placeholder="Enter Model Number" name="modelno">
    </div>

    <div class="form-group">
      <label for="email">Chassis Number:</label>
      <input type="text" class="form-control" id="c_number" placeholder="Enter Chassis Number" name="c_number">
    </div>
    <div class="form-group">
      <label for="email">Purchase Date</label>
      <input type="date" class="form-control" id="p_date" placeholder="Enter Purchase Date" name="p_date" >
    </div>

    <div class="form-group">
      <label for="email">Insurance Expire</label>
      <input type="date" class="form-control" id="i_exprire" placeholder="Enter Insurance Expire Date" name="i_exprire">
    </div>
    <div class="form-group">
      <label for="pwd">Insurance Valide Till:</label>
      <input type="date" class="form-control" id="i_valid" placeholder="Enter Insurance Valid Date" name="i_valid">
    </div>
    <div class="form-group">
      <label for="email">Tax Policy Number:</label>
      <input type="text" class="form-control" id="text_policy_num" placeholder="Enter Tax Police Number" name="text_policy_num">
    </div>
    <div class="form-group">
      <label for="email">Tax Valid Till:</label>
      <input type="date" class="form-control" id="tax_valid_till" placeholder="Enter tax_valid_till" name="tax_valid_till">
    </div>

    <div class="form-group">
      <label for="email">Tax Expire Date:</label>
      <input type="date" class="form-control" id="tax_expite_date" placeholder="Enter tax_expite_date" name="tax_expite_date">
    </div>
    
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
    </div>

    <div class="col-md-3"></div>
  </div>
</div>


<div class="container">
  <div class="row">
  <div class="col-md-3">wqewqdwqd</div>
  <div class="col-md-6">wqdwqwqdwq</div>
  <div class="col-md-3">qwdwqdwqd</div>
  </div>
</div>
</body>
</html>
