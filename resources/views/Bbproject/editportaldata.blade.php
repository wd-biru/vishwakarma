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
  <h2>Update Asset Portal form</h2>

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


  <form action="{{URL('/updateAsset')}}" method="POST">
    @csrf
  <input type="hidden" name="user_id" value="{{$data['id']}} ">
    <div class="form-group">
      <label for="email">Portal_Id</label>
      <input type="text" class="form-control" id="portal_Id" name="portal_Id" value="{{$data['portal_Id']}}">
    </div>

    <div class="form-group">
      <label for="email">Asset Name:</label>
      <input type="text" class="form-control" id="asset_name" placeholder="Enter Asset Name" name="asset_name" value="{{$data['asset_name']}}" >
    </div>
    <div class="form-group">
      <label for="pwd">Model Number:</label>
      <input type="text" class="form-control" id="modelno" placeholder="Enter Model Number" name="modelno" value="{{$data['modelno']}}" >
    </div>

    <div class="form-group">
      <label for="email">Chassis Number:</label>
      <input type="text" class="form-control" id="c_number" placeholder="Enter Chassis Number" name="c_number" value="{{$data['c_number']}}" >
    </div>
    <div class="form-group">
      <label for="email">Purchase Date</label>
      <input type="date" class="form-control" id="p_date" placeholder="Enter Purchase Date" name="p_date" value="{{$data['p_date']}}" >
    </div>

    <div class="form-group">
      <label for="email">Insurance Expire</label>
      <input type="date" class="form-control" id="i_exprire" placeholder="Enter Insurance Expire Date" name="i_exprire" value="{{$data['i_exprire']}}" >
    </div>
    <div class="form-group">
      <label for="pwd">Insurance Valide Till:</label>
      <input type="date" class="form-control" id="i_valid" placeholder="Enter Insurance Valid Date" name="i_valid" value="{{$data['i_valid']}}" >
    </div>
    <div class="form-group">
      <label for="email">Tax Policy Number:</label>
      <input type="text" class="form-control" id="text_policy_num" placeholder="Enter Tax Police Number" name="text_policy_num" value="{{$data['text_policy_num']}}" >
    </div>
    <div class="form-group">
      <label for="email">Tax Valid Till:</label>
      <input type="date" class="form-control" id="tax_valid_till" placeholder="Enter tax_valid_till" name="tax_valid_till" value="{{$data['tax_valid_till']}}" >
    </div>

    <div class="form-group">
      <label for="email">Tax Expire Date:</label>
      <input type="date" class="form-control" id="tax_expite_date" placeholder="Enter tax_expite_date" name="tax_expite_date" value="{{$data['tax_expite_date']}}" >
    </div>
    
    <button type="submit" class="btn btn-default">Update</button>
  </form>
</div>
  <div class="col-sm-3"></div>
</div>
</div>
</body>
</html>
