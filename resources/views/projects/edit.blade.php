@extends('layout.app')

@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;{{ trans('project.edit')}} </h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>  
            <li>{{ link_to_route('projects.index',trans('project.projects'), ['status_id' => request('status_id', $project->status_id)]) }}</li>
            <li>{{ $project->present()->projectLink }}</li>
            <li class="active">{{ isset($title) ? $title :  trans('project.edit') }}</li>
        </ul>
    </div>
</div>

@endsection

@section('content')


<div class="row">
    <div class="col-md-7 col-md-offset-2">
        {!! Form::model($project, ['route' =>['projects.update', $project->id], 'method' => 'patch']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ $project->name }}</h3></div>
            {{csrf_field()}}
            <div class="panel-body">
                {!! FormField::text('name', ['label' => trans('project.name')]) !!}

                <div class="col-md-12">
                    {!! FormField::select('client_id', $customers, ['label' => trans('project.customer'),'id'=>'id-customers']) !!}
                </div>


                {!! FormField::textarea('location', ['label' => "Address"]) !!}

                <div class="row">
                    <div class="col-md-6">

                {!! FormField::select('state_id', $state, ['placeholder' => 'Select State','id'=>'id_state']) !!}

                  </div>
                <div class="col-md-6">

                {!! FormField::select('city_id', $city, ['placeholder' => 'Select City','id'=>'id_city']) !!}

                 </div>
                  
                </div>

                {!! FormField::text('pin', ['label' => "Pincode"]) !!}

                {!! FormField::text('lat', ['label' => "Latitude"]) !!}

                {!! FormField::text('lng', ['label' => "Longitude"]) !!}
                {!! FormField::textarea('description', ['label' => trans('project.description'),'rows' => 3]) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('proposal_date', ['label' => trans('project.proposal_date')]) !!}
                    </div>
                    <div class="col-md-6">                        
                        <div class="form-group "><label for="price" class="control-label">Proposal value</label>&nbsp;<div class="input-group"><span class="input-group-addon">INR</span><input class="form-control text-right" name="proposal_value" type="text" value="{{$project->proposal_value}}" id="proposal_value"></div></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('start_date', ['label' => trans('project.start_date')]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::text('end_date', ['label' => trans('project.end_date')]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! FormField::select('status_id', ProjectStatus::toArray(), ['label' => trans('app.status')]) !!}
                    </div>

                </div>
            </div>

            <div class="panel-footer">
                {!! Form::submit(trans('project.update'), ['class' =>'btn btn-primary']) !!}
                {!! link_to_route('projects.show', trans('app.show'), [$project->id], ['class' => 'btn btn-info']) !!}
                {!! link_to_route('projects.index', trans('project.back_to_index'), ['status' => $project->status_id], ['class' => 'btn btn-default']) !!}
                @can('delete', $project)
                {!! link_to_route('projects.delete', trans('app.delete'), [$project->id], ['class' =>'btn btn-danger pull-right']) !!}
                @endcan
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('ext_css')
    {!! Html::style(url('assets/css/plugins/jquery.datetimepicker.css')) !!}
@endsection

@section('ext_js')
    {!! Html::script(url('assets/js/pmoJs/plugins/jquery.datetimepicker.js')) !!}
@endsection

@section('script')
<script>
 
     jQuery('#proposal_date').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true,
                });

     jQuery(function(){
var enddated=new Date();
var todate=new Date();
var enddatedAfterDay=new Date();
var app={

init:function(){

$("#id-customers").select2({
        placeholder: "Select a Customer",
        allowClear: true
    });
app.start_date();
app.end_date();

},
start_date:function(){

jQuery("#start_date").datepicker({ 
autoclose: true, 
todayHighlight: true,
endDate: new Date(),
defaultDate:'yyyy-mm-dd',
format: 'yyyy-mm-dd',
}).on('changeDate', function(e) {
jQuery("#end_date").val('');
todate=new Date();
enddated=jQuery(this).val();
/* enddatedAfterDay = jQuery(this).val();
enddatedAfterDay.setDate(enddated.getDate() + 30);
alert(enddatedAfterDay);
var date2 = $('#start_date').datepicker('getDate', '+30d'); 


*/
var enddatedAfterDay = $('#start_date').datepicker('getDate');
enddatedAfterDay.setDate(enddatedAfterDay.getDate()+300)

app.end_date();
});
},
end_date:function(){

var enddatedAfterDay = $('#start_date').datepicker('getDate');
enddatedAfterDay.setDate(enddatedAfterDay.getDate()+300);


jQuery("#end_date").datepicker({ 
autoclose: true, 
todayHighlight: true,
startDate:enddated,

defaultDate:'yyyy-mm-dd',
format: 'yyyy-mm-dd',
}).datepicker('setStartDate',enddated).datepicker('setEndDate',enddatedAfterDay);

/* alert(enddatedAfterDay);
alert(enddated);*/
},

};

app.init();
});


     $('#id_state').on('change',function(){
                //console.log(jQuery('#state').val());

                jQuery.post("{{route('vendorGetCity')}}",{
                state_id:jQuery('#id_state').val(),
                '_token': jQuery('meta[name="csrf-token"]').attr('content'),
                },function(data){
                var opt='';
                jQuery.each(data, function(index,value)
                {     
                opt+='<option value="'+value.id+'">'+value.name+'</option>';
                });


                jQuery('#id_city').html(opt);
                getcity();

 
                

         
    });
});




</script>
@endsection
