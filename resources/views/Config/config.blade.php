@extends('layout.app')
@section('content')

 
    <div class="content-wrapper">
        <div class="page-title" >
            <div>
                <h1><i class="fa fa-dashboard"></i>&nbsp;General</h1>
            </div>

            <div>
                <center>
                    @if(Session::has('success'))
                        <font style="color:red">{!!session('success')!!}</font>
                    @endif
                </center>

            </div>
            <div>
                <ul class="breadcrumb">
                    <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                    <li><a href="#">Config</a></li>
                    <li><a href="#">General</a></li>
                </ul>
            </div>
        </div>
         @include('includes.msg')
                @include('includes.validation_messages')

        <div class="row">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLongTitle">
                     Add Config
            </button>
           
        </div>
        <div class="row">
        <div class="col-md-12">
        <div class="content-section">
 
            <div class=" table-responsive ">
                <table class="table table-bordered main-table search-table">
                    <thead>
                        <tr class="t-head">
                            <th>Sr. No</th>
                            <th>Field Label</th>
                            <th>Field Name</th>
                            <th>Input Type</th>
                            <th>Option</th>
                            <th>Value</th>
                            <th>Config Order</th>
                            <th>Category</th>
                            <th>Action</th>
 
                        </tr>
                    </thead>
                    <tbody><?php $i=1;?>
                        @foreach($VishwaAdminConfigs as $list)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$list->field_label}}</td>
                            <td>{{$list->field_name}}</td>
                            <td>{{$list->input_type}}</td>
                            <td>{{$list->option}}</td>
                            <td>{{$list->value}}</td>
                            <td>{{$list->config_order}}</td>
                            <td>{{$list->category}}</td>
 
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('config.edit',[$list->id])}}"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp; Edit</a></li>

                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>

        </div>
    </div>
</div>





    </div>
   







 <style type="text/css">
    .form-control{
            margin-bottom: 10px;
    }
</style>

    <div class="modal fade" id="exampleModalLongTitle" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Admin Config  </h4>
        </div>
         <form   action="{{route('admin.config.store')}}" method="post" >
                                {{ csrf_field() }}
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
                
                 <label for="email">Field Label&nbsp;<span style="color: #f70b0b">*</span></label>
            </div>
            <div class="col-md-8">
                
    <input type="text" class="form-control" name="field_label" required="" id="field_label">
            </div>
  </div>
  <div class="row">
    <div class="col-md-4">
        
    <label for="email">Field Name&nbsp;<span style="color: #f70b0b">*</span></label>
    </div>
    <div class="col-md-8">
        
    <input type="text" class="form-control" name="field_name" required="" id="field_name">
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
        
    <label for="text">Input Type&nbsp;<span style="color: #f70b0b">*</span></label>
    </div>
    <div class="col-md-8">
        
    <input type="text" class="form-control" name="input_type" required="" id="input_type">
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
        
    <label for="text">Option&nbsp;<span style="color: #f70b0b">*</span></label>
    </div>
    <div class="col-md-8">
        
    <input type="text" class="form-control" name="option"  required="" id="option">
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
        
    <label for="text">Value&nbsp;<span style="color: #f70b0b">*</span></label>
    </div>
    <div class="col-md-8">
        
    <input type="text" class="form-control" name="value" required="" id="value">
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
        
    <label for="text">Config Order&nbsp;<span style="color: #f70b0b">*</span></label>
    </div>
    <div class="col-md-8">
        
    <input type="Number" class="form-control"  name="config_order" required="" id="config_order" min="0">
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
        
    <label for="text">Category&nbsp;<span style="color: #f70b0b">*</span></label>
    </div>
    <div class="col-md-8">
        
    <input type="text" class="form-control"  name="category" required="" id="category">
    </div>
  </div>
</div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
          <button type="submit" class="btn btn-primary">Submit</button>
      </form>
        </div>
      </div>
      
    </div>
  </div>




<!-- Javascripts-->
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 
 

 

@endsection