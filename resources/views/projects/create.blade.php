@extends('layout.app')


@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;{{ trans('project.create') }}</h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
            <li>{{ link_to_route('projects.index',trans('project.projects')) }}</li>
            <li class="active">{{ trans('project.create') }}</li>            
        </ul>
    </div>
</div>
@endsection

@section('content')


<div class="row">
    <div class="col-md-4 col-md-offset-3">
        {!! Form::open(['route' => 'projects.store']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('project.create') }}</h3></div>
            <input type="hidden" name="portal_id" value="{{Auth::user()->getPortal->id}}">
            <div class="panel-body">
                {!! FormField::text('name', ['label' => trans('project.name')]) !!}

                {!! FormField::select('client_id', $customers, ['placeholder' => 'Select Customer','placeholder' => 'Select Customer','id'=>'id-customers',]) !!}

                {!! FormField::textarea('location', ['label' => "Address"]) !!}

                <div class="row">
                    <div class="col-md-6">

                {!! FormField::select('state_id', $state, ['placeholder' => 'Select State','id'=>'id-state']) !!}

                </div>
                <div class="col-md-6">

                {!! FormField::select('city_id', $customers, ['placeholder' => 'Select City','id'=>'id-city']) !!}

                 </div>
                  
                </div>

                {!! FormField::text('pin', ['label' => "Pincode"]) !!}



                {!! FormField::text('lat', ['label' => "Latitude"]) !!}

                {!! FormField::text('lng', ['label' => "Longitude"]) !!}


           

                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('proposal_date', ['label' => trans('project.proposal_date')]) !!}
                    </div>
                    <div class="col-md-6">
                        <div class="form-group "><label for="proposal_value" class="control-label">Proposal Value</label>&nbsp;<div class="input-group"><span class="input-group-addon">INR</span><input class="form-control text-right" name="proposal_value" type="text" id="proposal_value"></div></div>
                    </div>
                  
                </div>
                {!! FormField::textarea('description', ['label' => trans('project.description')]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::submit(trans('project.create'), ['class' => 'btn btn-primary']) !!}
                {!! link_to_route('projects.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) !!}
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
@endsection

@section('script') 
 
<script type="text/javascript">     
    jQuery('#proposal_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });
    $("#id-customers").select2({
        placeholder: "Select a Customer",
        allowClear: true,
        width:'90%'
    });



    $('#id-state').on('change',function(){
                //console.log(jQuery('#state').val());

                jQuery.post("{{route('vendorGetCity')}}",{
                state_id:jQuery('#id-state').val(),
                '_token': jQuery('meta[name="csrf-token"]').attr('content'),
                },function(data){
                var opt='';
                jQuery.each(data, function(index,value)
                {     
                opt+='<option value="'+value.id+'">'+value.name+'</option>';
                });


                jQuery('#id-city').html(opt);

                //getcity();
                

         
    });
});




   
</script>
@endsection
