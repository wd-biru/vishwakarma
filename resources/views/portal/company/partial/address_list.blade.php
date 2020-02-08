
@if(!empty($editData))
<div class="modal fade" id="myModalAddressEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div>
               <legend>Contact Details</legend>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="contactformUpdate" action="" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="client_id" value="{{$editData->client_id}}">
                                <input type="hidden" name="update_id" value="{{$editData->id}}">
                                <div class="row">
                                    <div class="col-md-12">


                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Address&nbsp;<span style="color: #f70b0b">*</span></label>
                                                                <div class="col-md-8">
                                                                    <textarea rows="1" cols="50" name="Address" required="" placeholder="H.NO,street.etc"  class="form-control">{{$editData->Address}}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">City&nbsp;<span style="color: #f70b0b">*</span></label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="text" value="{{$editData->City}}" required="" name="City" placeholder="City">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Post Code&nbsp;<span style="color: #f70b0b">*</span></label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control numeric" type="text" value="{{$editData->Post_code}}" required="" name="Post_code" placeholder="47**96">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Country&nbsp;<span style="color: #f70b0b">*</span></label>
                                                                <div class="col-md-8">
                                                                    <select class="form-control" name="Country_id">
                                                                    @foreach($countries as $country)
                                                                        <option value="{{$country->id}}" @if($editData->Country_id == $country->id ) selected @endif>{{$country->name}}</option>
                                                                    @endforeach
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Telephone</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control numeric" type="text"  value="{{$editData->Telephone}}" name="Telephone" placeholder="25348122">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Fax</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control numeric" type="text" value="{{$editData->Fax}}" name="Fax" placeholder="25348195">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Contact Person&nbsp;<span style="color: #f70b0b">*</span></label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="text" value="{{$editData->Contact_Person}}" required="" name="Contact_Person" placeholder="MARIOS & STELIOS & GEORGIOU">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Mobile&nbsp;<span style="color: #f70b0b">*</span></label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control numeric" type="text" required value="{{$editData->Mobile}}"  data-colum="Mobile" name="Mobile" id="Mobile" placeholder="9931815443"><span style="color: green" id="mobile_status"></span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Alternate Mobile</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control numeric" type="text"  value="{{$editData->Alternate_Mobiles}}" name="Alternate_Mobile" placeholder="99652859 - 99445242">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Email&nbsp;<span style="color: #f70b0b">*</span></label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control disable" type="email" required name="Email" id="email" value="{{$editData->Email}}"  data-colum="Email" placeholder="anstelexim@gmail.com"><span style="color: green"  id="email_status"></span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Alternate Email</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" type="email"  name="Alternate_Email" value="{{$editData->Alternate_Email}}" placeholder="georgiougiorgos62@gmail.com">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button  type="submit" class="btn btn-primary pull-right">
                                                            SAVE
                                                        </button>
                                                    </div>
                                                </div>

                                    </div>
                                </div>
                                </form>
            </div>
        </div>
    </div>
</div>

@endif




<div class="table-responsive">
    <table class="table table-bordered searchTable" >
        <thead>
            <tr class="btn-primary-th">
                <th>Sr. No</th>
                <th>Address </th>
                <th>City </th>
                <th>Post Code </th>
                <th>Country </th>
                <th>Contact Person </th>
                <th>Telephone </th>
                <th>Fax </th>
                <th>Mobile</th>
                <th>Alternate Mobiles</th>
                <th>Email</th>
                <th>Alternate Email</th>
                @if($status==0)
                {
                    <th>Action</th>
                }
                @endif

            </tr>
        </thead>
        <tbody><?php $i=1?>
            @foreach($address as $list)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$list->Address}}</td>
                    <td>{{$list->City}}</td>
                    <td>{{$list->Post_code}}</td>
                    <td>{{$list->Country_name}}</td>
                    <td>{{$list->Contact_Person}}</td>
                    <td>{{$list->Telephone}}</td>
                    <td>{{$list->Fax}}</td>
                    <td>{{$list->Mobile}}</td>
                    <td>{{$list->Alternate_Mobiles}}</td>
                    <td>{{$list->Email}}</td>
                    <td>{{$list->Alternate_Email}}</td>
                    @if($status==0)
                {
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#"
                                    data-address_id="{{$list->id}}"
                                    class="editAddress" title="Add">Edit</a></li>
                            </ul>
                        </div>
                    </td>
                }
                @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
