@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-bank" aria-hidden="true"></i></i>&nbsp;Bank Master</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('bankMaster.index')}}">Bank Master</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')


<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plus"></i> Add Bank Info</h3></div>
            <div class="panel-body">
                @include('includes.msg')
                @include('includes.validation_messages')

                    <form class="form-horizontal" action="{{route('bankMaster.store')}}" method="post" enctype="multipart/form-data"> 
                        {{ csrf_field() }}
                       
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body"> 
                                    <fieldset>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Bank Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="bank_name" value="{{old('bank_name')}}"  placeholder="Bank Name" required="">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">IFSC Code&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="ifsc_code" value="{{old('ifsc_code')}}" placeholder="IFSC Code" required="">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Pincode&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="number" value="{{old('pincode')}}"  name="pincode" id="pincode" placeholder="Pincode" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Address&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <textarea class="form-control" name="address"  placeholder="Enter Address" required=""></textarea>
                                        </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card"   >
                                <div class="card-body">
                                    <fieldset>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">District&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="district" placeholder="District" required="">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">City&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="city_name" class="form-control" id="city_name" placeholder="Enter City Name" data-id="">
                                                <div id="city_name_list"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">State&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="state_name" class="form-control" id="state_name" placeholder="Enter State Name" data-id="">
                                                <div id="state_name_list"></div>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="control-label col-md-4">Country&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="country_name" id="country_name" placeholder="Enter Country Name" required="" data-id="">
                                                <div id="country_name_list"></div>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Status&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="status" required="">
                                                    <option>--select status--</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">DeActive</option>
                                                </select>
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
    $(document).ready(function() {
       $('#city_name').keyup(function () {
            var city = $(this).val();
            console.log(city);
            if (city != '') {
                $.ajax({
                    url: "{{ route('cityName.fetch') }}",
                    type: "get",
                    data: {
                        "city": city,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        $('#city_name_list').fadeIn();
                        $('#city_name_list').html(data);

                    }
                });
            }
            $(document).on('click', 'li.selectCity', function () {
                $('#city_name').val($(this).text());
            });
        });


        $('#state_name').keyup(function () {
            var state = $(this).val();
            console.log(state);
            if (state != '') {
                $.ajax({
                    url: "{{ route('stateName.fetch') }}",
                    type: "get",
                    data: {
                        "state": state,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        $('#state_name_list').fadeIn();
                        $('#state_name_list').html(data);

                    }
                });
            }
        });
        $(document).on('click', 'li.selectState', function () {
            $('#state_name').val($(this).text());
        });

        $('#country_name').keyup(function () {
            var country = $(this).val();
            console.log(country);
            if (country != '') {
                $.ajax({
                    url: "{{ route('countryName.fetch') }}",
                    type: "get",
                    data: {
                        "country": country,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        $('#country_name_list').fadeIn();
                        $('#country_name_list').html(data);

                    }
                });
            }
        });
        $(document).on('click', 'li.selectCountry', function () {
            $('#country_name').val($(this).text());
        });
    });


    function cityFadeOut(check) {
        var city_name = $(check).attr('data-name');
        var city_id = $(check).attr('data-id');

        var textCityName = $('#city_name').attr('data-name', city_name)
        var textCityId = $('#city_name').attr('data-id', city_id)

        $('#city_name_list').fadeOut();
        $('#city_name').val()

       
    }

    function stateFadeOut(check) {
        var state_name = $(check).attr('data-name');
        var state_id = $(check).attr('data-id');

        var textStateName = $('#state_name').attr('data-name', state_name)
        var textStateId = $('#state_name').attr('data-id', state_id)

        $('#state_name_list').fadeOut();
        $('#state_name').val()
    }

    function countryFadeOut(check) {
        var country_name = $(check).attr('data-name');
        var country_id = $(check).attr('data-id');

        var textCountryName = $('#country_name').attr('data-name', country_name)
        var textCountryId = $('#country_name').attr('data-id', country_id)

        $('#country_name_list').fadeOut();
        $('#country_name').val()
    }

</script>

@endsection