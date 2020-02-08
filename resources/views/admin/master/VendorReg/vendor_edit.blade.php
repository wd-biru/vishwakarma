@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Vendor Registration</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('master.vendorReg')}}">Vendor Edit</a></li>
                <li><a href="#">Edit</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')


<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plus"></i>Edit Vendor Info</h3></div>
            <div class="panel-body">
                @include('includes.msg')
                @include('includes.validation_messages')

                    <form class="form-horizontal" action="{{route('vendorUpdate')}}" method="post" enctype="multipart/form-data"> 
                        {{ csrf_field() }}
                        <input class="form-control" type="hidden" name="id" value="{{$vendor_edit_values->id}}">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body"> 
                                    <fieldset>
                                        <legend>Vendor Edit</legend>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="name"  placeholder="Enter  name" style="text-transform: capitalize" value="{{$vendor_edit_values->name}}">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="company_name" value="{{$vendor_edit_values->company_name}}" placeholder="Company Name">
                                        </div>
                                        </div>
                                      
                                       <div class="form-group">
                                            <label class="control-label col-md-4">Mobile&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="number" value="{{$vendor_edit_values->mobile}}" name="mobile" id="mobile" placeholder="9931815443" ><span style="color:green" id="mobile_status"></span>
                                        </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Director Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" value="{{$vendor_edit_values->director_name}}" name="director_name" id="director_name" placeholder="Director Name" ><span style="color:green" id="mobile_status"></span>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Director Number</label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="number" value="{{$vendor_edit_values->director_number}}" name="director_number" id="director_number"  placeholder="9965285943">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-4">Supplier&nbsp;<span style="color: #f70b0b">*</span></label>
                                          <div class="col-sm-8">
                                            <select class="form-control" required="" id="supplier" class="form-control check_value_ea check_name_ea" name="supplier_of[]" multiple>
                                              @if(isset($vendor_material_group))
                                                  @foreach ($allmaster_material_group as  $list)
                                                  <option @foreach ($vendor_material_group as $key => $row)  @if($key==$list->id) selected @endif  @endforeach value="{{$list->id}}">{{ $list->group_name}}</option>
                                                  @endforeach
                                                @endif
                                            </select>
                                          </div>
                                        </div>
                                    </fieldset>
                                 
                                   <fieldset> 
                                          <legend>Login Details</legend>
                                            <div class="form-group">
                                              <label class="control-label col-md-4">Email&nbsp;<span style="color: #f70b0b">*</span></label>
                                              <div class="col-md-8">
                                              <input autocomplete="new-password" class="form-control" type="text" value="{{$vendor_edit_values->getUser->email}}" name="email" id="email" placeholder="xxxxx@xxx.com" >
                                          </div>
                                          </div>
                                          <div class="form-group">
                                              <label class="control-label col-md-4">Password</label>
                                              <div class="col-md-8" >
                                              <input autocomplete="new-password" class="form-control" id="hidepass" type="password" class="effect-2" value="{{$vendor_edit_values->getUser->password}}" name="password" placeholder="Password">
                                          </div>
                                          </div>
                                          <div class="form-group" style="margin-left: 173px; margin-top: -12px;">
                                          <input type="checkbox" onclick="myFunction()">Show Password
                                      </div>
                                      </fieldset> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card" style="margin-top: 28px;">
                                <div class="card-body">
                                    <fieldset>
                                        <legend></legend><br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Address&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <textarea class="form-control" name="address" placeholder="Enter Address">{{$vendor_edit_values->address}}</textarea>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-4">State&nbsp;<span style="color: #f70b0b">*</span></label>
                                          <div class="col-sm-8">
                                            <select class="form-control" required="" id="state" class="form-control check_value_ea check_name_ea" name="state">
                                              @if(isset($vendor_state))
                                                  @foreach ($vendor_state as $unit)
             <option value="{{$unit->id}}" @if($vendor_edit_values->state==$unit->id) selected @endif>{{ $unit->name}}</option>
                                                  @endforeach
                                                @endif
                                            </select>
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <label class="control-label col-md-4">State Code&nbsp;<span style="color: #f70b0b">*</span></label>
                                          <div class="col-sm-8">
                                           <input class="form-control" type="text" name="state_code" id="state_code" value="{{$vendor_edit_values->state_code}}">
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <label class="control-label col-md-4">City&nbsp;<span style="color: #f70b0b">*</span></label>
                                          <div class="col-sm-8">
                                            <select class="form-control" required="" id="city" class="form-control check_value_ea check_name_ea" name="city">
                                                @if(isset($vendor_city))
                                                  @foreach ($vendor_city as $unit)
             <option value="{{$unit->id}}" @if($vendor_edit_values->city==$unit->id) selected @endif>{{ $unit->name}}</option>
                                                  @endforeach
                                                @endif
                                              
                                            </select>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Latitude</label>
                                            <div class="col-md-8">
                                            <input type="text"  class="form-control"  id="latitude" value="{{$vendor_edit_values->latitude}}" class="form-control check_value_ea check_name_ea" name="latitude">
                                              
                        
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Longitude</label>
                                            <div class="col-md-8">
                                            <input type="text"  class="form-control"  id="longitude" class="form-control check_value_ea check_name_ea" name="longitude" value="{{$vendor_edit_values->longitude}}">
                                              
                            
                                        </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">GSTIN/UIN&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="gstn_uin" id="gstn_uin" value="{{$vendor_edit_values->gstn_uin}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Pincode&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="pincode" id="pincode" value="{{$vendor_edit_values->pincode}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-4">Mode/Terms Of Payment&nbsp;<span style="color: #f70b0b">*</span></label>
                                          <div class="col-sm-8">
                                           <input class="form-control" type="text" name="mode_payment" id="mode_payment" value="{{$vendor_edit_values->mode_payment}}">
                                          </div>
                                        </div>
                                                                         
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Status&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <select class="form-control" name="is_active" >
                                                <option value="1" @if($vendor_edit_values->is_active == 1) selected @endif>Active</option>
                                                <option value="0"  @if($vendor_edit_values->is_active == 0) selected @endif>DeActive</option>
                                            </select>
                                        </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit_btn" class="btn btn-primary pull-right"><i class="fa fa-save"></i>Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>  
<script type="text/javascript">
jQuery('#supplier').select2({
                    tags: true,
                    tokenSeparators: [','],
                    placeholder: "Share Document With"
                });

$(document).ready(function() {
    $('#state').click(function(){
                
                jQuery.post("{{route('vendorGetCity')}}",{
                state_id:jQuery('#state').val(),
                '_token': jQuery('meta[name="csrf-token"]').attr('content'),
                },function(data){
                var opt='';
                jQuery.each(data, function(index,value)
                {     
                opt+='<option value="'+value.id+'">'+value.name+'</option>';
                });

             
                jQuery('#city').html(opt);

                getcity();
                

         
    });
});
    });

$(document).ready(function() {
    $('#city').change(function(){
                

                jQuery.post("{{route('vendorGetLatLong')}}",{
                state_id:jQuery('#state').val(),
                city_id:jQuery('#city').val(),
                '_token': jQuery('meta[name="csrf-token"]').attr('content'),
                },function(data){ 
                 
    });
});
    });


function getcity()
{
              jQuery.post("{{route('vendorGetLatLong')}}",{
                state_id:jQuery('#state').val(),
                city_id:jQuery('#city').val(),

                '_token': jQuery('meta[name="csrf-token"]').attr('content'),
                },function(data){
                  jQuery('#state_code').val(data.gstcode);
 
               
                    });
                    

}

function myFunction() {
  var x = document.getElementById("hidepass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}



$(document).ready(function(){

    $('#email').attr('autocomplete','off');

   $('#hidepass').val('');
    });
</script>




@endsection