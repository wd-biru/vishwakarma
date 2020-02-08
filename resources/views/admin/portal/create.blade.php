@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Portal Management</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('portal')}}">Users list</a></li>
                <li><a href="#">Add</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')


<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plus"></i> Add Portal Info</h3></div>
            <div class="panel-body">
                @include('includes.msg')
                @include('includes.validation_messages')

                    <form class="form-horizontal" action="{{route('portalInfoStore')}}" method="post" enctype="multipart/form-data"> 
                        {{ csrf_field() }}
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body"> 
                                    <fieldset>
                                        <legend>Portal</legend>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">First Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="name"  placeholder="Enter  name" style="text-transform: capitalize" value="{{old('name')}}">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Last Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="surname" value="{{old('surname')}}" placeholder="surname ">
                                        </div>
                                        </div>
                                      
                                       <div class="form-group">
                                            <label class="control-label col-md-4">Mobile&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="number" value="{{old('mobile')}}" name="mobile" id="mobile" placeholder="9931815443" ><span style="color:green" id="mobile_status"></span>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Mobile Other</label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="number" value="{{old('other_mobile')}}" name="other_mobile" id="Other_Mobiles"  placeholder="9965285943">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-md-4">State&nbsp;<span style="color: #f70b0b">*</span></label>
                                          <div class="col-sm-8">
                                            <select class="form-control" required="" id="state" name="state" >
                                              @if(isset($portal_state))
                                                  <option value="">Select State</option>
                                                  @foreach ($portal_state as $unit)
                             <option  value="{{$unit->id}}">{{ $unit->name}}</option>
                                                  @endforeach
                                                @endif
                                            </select>
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <label class="control-label col-md-4">State Code&nbsp;<span style="color: #f70b0b">*</span></label>
                                          <div class="col-sm-8">
                                        <input class="form-control" type="text" name="state_code" id="state_code" value="">
                                    
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
                                            <textarea class="form-control" name="address" placeholder="enter address">{{old('address')}}</textarea>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">GSTIN/UIN&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="gstn_uin" id="gstn_uin" value="{{old('gstn_uin')}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">CIN&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="cin" id="cin" value="{{old('cin')}}">
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <legend>Login Details</legend><br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Email&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" value="{{old('Email')}}" name="email" id="email" placeholder="xxxxx@xxx.com" >
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Password</label>
                                            <div class="col-md-8">
                                            <input class="form-control" id="password" type="password" class="effect-2" name="password" placeholder="Password" required>
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
                                            <input class="form-control" type="text" name="company_name" id="company_name" placeholder="Enter full name" style="text-transform: capitalize" value="{{old('company_name')}}">
                                        </div>
                                        </div>





        <div class="form-group">
        <label class=" col-md-3" style="margin-left: 39px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Logo&nbsp;</label>
        <div class="col-md-8">
        <div class="comlogo"  style="width: 250px; height:194px; margin: 0 auto;"><img  id="output" style="height: 168px; width: 100%; " src="" alt="" title="your Logo" class=" img-thumbnail" required></div>

        <input class="" id="image" type="file" name="logo_img" placeholder="Enter logo_img">
        </div>
        </div>




                                        <div class="form-group">
                                            <label class="control-label col-md-4">Contact Person&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="contact_person" id="contact_person"  value="{{old('contact_person')}}" placeholder="person name">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company Email&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="email" name="company_mail" id="company_mail" value="{{old('company_mail')}}"  placeholder="xxxxxxxx@xxx.com">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company Phone&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="company_mobile" id="company_mobile" value="{{old('company_mobile')}}"  placeholder="  Enter Contact Number">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company Address&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <textarea class="form-control" name="company_address"  placeholder="Enter Company Address">{{old('company_address')}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company's VAT TIN</label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="vat_tin" id="vat_tin" value="{{old('vat_tin')}}"  placeholder="  Enter Company's VAT TIN Number">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company's CST No</label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="cst_no" id="cst_no" value="{{old('cst_no')}}"  placeholder="  Enter Company's CST Number">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company's Service Tax No</label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="service_tax_no" id="service_tax_no" value="{{old('service_tax_no')}}"  placeholder="  Enter Company's Service Tax Number">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Company's PAN</label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="pan" id="pan" value="{{old('pan')}}"  placeholder="  Enter Company's PAN Number">
                                            </div>
                                        </div>

                                    </fieldset>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit_btn" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
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
                    url: "{{route('vendorGetStateCode')}}",
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

