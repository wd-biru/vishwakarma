@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-address-card-o" aria-hidden="true"></i></i>&nbsp;Profile</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
               
                <!-- <li><a href="#">list</a></li> -->
            </ul>
        </div>
    </div>
@endsection
@section('content')
@include('includes.msg')
@include('includes.validation_messages')

<form class="form-horizontal" action="{{route('portal.profile.update')}}" method="post" enctype="multipart/form-data">
{{csrf_field()}}
<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-edit"></i> Edit Info</h3></div>
            <div class="panel-body">
                  <div class="col-md-12">
                            <div class="card">
                                <div class="card-body"> 
                                       <div class="form-group">
                                            <div class="row">
                                            <label class="control-label col-md-4">Logo&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                @if($portal_edit_values->logo_img)
                                                <img id="output" src="{{my_asset('/uploads/portal_images/'. $portal_edit_values->logo_img)}}" height="40%" width="40%"  alt="User Image">

                                                @else
                                                    <img id="output" src="{{my_asset('/uploads/portal_images/default.jpg')}}" height="40%" width="40%"  alt="User Image">
                                                @endif
                                            </div>

                                    </div>
                                        <br>
                                        <div class="form-group">
                                         <div class="row">
                                            <div class="col-md-4">
                                            </div>
                                            <div class="col-md-8">

                                            <input  type="file" name="logo_img" id="image" value="{{$portal_edit_values->logo_img}}" placeholder="Enter logo_img">
                                        </div>
                                        </div>
                                     
                                        </div>
                                </div>
                            </div>
                        </div>
                <div class="col-md-6">
                            <div class="card">
                                <div class="card-body"> 
                                 <legend>Portal</legend>
                                    <fieldset><br>
                                        <input type="hidden" name="update_id" value="{{$portal_edit_values->user_id}}">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="name"  placeholder="Enter  name" style="text-transform: capitalize" value="{{$portal_edit_values->name}}">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Surname&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="surname" value="{{$portal_edit_values->surname}}" placeholder=" ">
                                        </div>
                                        </div>
                                      
                                       <div class="form-group">
                                            <label class="control-label col-md-4">Mobile&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control groupOfTexbox" type="number" value="{{$portal_edit_values->mobile}}" name="mobile" id="mobile" placeholder="9931815443" ><span style="color:green" id="mobile_status"></span>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Mobile Other</label>
                                            <div class="col-md-8">
                                            <input class="form-control groupOfTexbox" type="number" value="{{$portal_edit_values->other_mobile}}" name="other_mobile" id="Other_Mobiles"  placeholder="9965285943">
                                        </div>
                                        </div>

                                        <div class="form-group">
                                          <label class="control-label col-md-4">State&nbsp;<span style="color: #f70b0b">*</span></label>
                                          <div class="col-sm-8">
                                            <select class="form-control" required="" id="state" name="state" >
                                              @if(isset($portal_state))
                                                  <option value="">Select State</option>
                                                  @foreach ($portal_state as $unit)
                             <option value="{{$unit->id}}" @if($portal_edit_values->state==$unit->id) selected @endif>{{ $unit->name}}</option>
                                                  @endforeach
                                                @endif
                                            </select>
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <label class="control-label col-md-4">State Code&nbsp;<span style="color: #f70b0b">*</span></label>
                                          <div class="col-sm-8">
                                        <input class="form-control" type="text" name="state_code" id="state_code" value="{{$portal_edit_values->state_code}}">
                                    
                                          </div>
                                        </div>
                                                                         
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Status&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <select class="form-control" name="status" >
                                                <option value="1">Active</option>
                                                <option value="0">DeActive</option>

                                            </select>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Address&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <textarea class="form-control" name="address">{{$portal_edit_values->address}}</textarea>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">GSTIN/UIN&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="gstn_uin" id="gstn_uin" value="{{$portal_edit_values->gstn_uin}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">CIN&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="cin" id="cin" value="{{$portal_edit_values->cin}}">
                                            </div>
                                        </div>
                                    </fieldset>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                     <fieldset>
                                        <legend>Company</legend><br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="company_name" id="company_name" placeholder="Enter full name" style="text-transform: capitalize" value="{{$portal_edit_values->company_name}}">
                                        </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Contact Person&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="contact_person" id="contact_person"  value="{{$portal_edit_values->contact_person}}" placeholder="person name">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company Email&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="email" name="company_mail" id="company_mail" value="{{$portal_edit_values->company_mail}}"  placeholder="xxxxxxxx@xxx.com">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company Phone&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="company_mobile" id="company_mobile" value="{{$portal_edit_values->company_mobile}}"  placeholder="  enter contact number">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company Address&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <textarea class="form-control" name="company_address"  placeholder="enter company address">{{$portal_edit_values->company_address}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company's VAT TIN</label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="vat_tin" id="vat_tin" value="{{$portal_edit_values->vat_tin}}"  placeholder="  Enter Company's VAT TIN Number">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company's CST No</label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="cst_no" id="cst_no" value="{{$portal_edit_values->cst_no}}"  placeholder="  Enter Company's CST Number">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company's Service Tax No</label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="service_tax_no" id="service_tax_no" value="{{$portal_edit_values->service_tax_no}}"  placeholder="  Enter Company's Service Tax Number">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company's PAN</label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="pan" id="pan" value="{{$portal_edit_values->pan}}"  placeholder="  Enter Company's PAN Number">
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit_btn" class="btn btn-primary pull-right">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
</form>
@endsection

@section('script')
<script type="text/javascript">
        function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#output').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image").change(function() {
        readURL(this);
    });

    $(document).ready(function() {
            $('#state').on('change', function () {
                var state_id = $(this).val();

                $.ajax({
                    url: "{{route('vendorGetCode')}}",
                    type: 'get',
                    data: {"state_id": state_id},
                    datatype: 'html',
                    success: function (data) {      
                              
                       $('#state_code').val(data.gstcode);
                  
                    }
                });
            }); 
        });
</script>
@endsection
