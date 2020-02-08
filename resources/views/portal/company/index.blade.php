
@extends('layout.app')
@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-building"></i>&nbsp;Company Management</h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
            <li><a href="{{route('company')}}">Company List</a></li>
        </ul>
    </div>
</div>
@endsection
@section('content')
@include('includes.msg')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-10">
        <a href="{{route('companyCreate')}}"><button class="btn btn-primary "><i class="fa fa-user-plus" aria-hidden="true" title="New" ></i>&nbsp;Add</button></a>
    </div>
    <div class="col-md-1">
        <b>Status Filter:</b>
    </div>
    <div class="col-md-1">
        <a class="pull-right status_active"><img src="{{ my_asset('images/activate.png') }}"></a>

        <a class="pull-left status_deactive"><img src="{{ my_asset('images/deactivate.png') }}"></a>
    </div>
    <div class="col-md-12">
        <div class="content-section"  id="id-status_change">


            <div class="  table-responsive  "style="overflow-x: inherit!important;
    min-height: 0.01%;">
                <table class="table table-bordered main-table" id="search-table">
                    <thead class="table-primary-th">
                        <tr class="btn-primary">
                            <th>Sr. No</th>
                            <th>Client Name</th>
                            <th>Status</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody><?php $i=1;?>
                     @if(isset($client_list) and (count($client_list) > 0 ))
                        @foreach($client_list as $list)
                        <tr>

                            <td>{{$i++}}</td>
                            <td><a href="{{route('companyShow',[base64_encode($list->id)])}}">{{$list->Client_name}}</a></td>
                            
                            <td class="table-status">
                                @if($list->Status==1)
                                    <img src="{{ my_asset('images/activate.png') }}">
                                @else
                                    <img class="change_status"  src="{{my_asset('images/deactivate.png')}}">

                                @endif
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" style="width: 20px;">
                                        <li><a href="{{route('companyShow',[base64_encode($list->id)])}}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp; View</a></li>
                                        <li><a href="company/edit/{{base64_encode($list->id)}}"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp; Edit</a></li>

                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>


@endsection

@section('script')
<script type="text/javascript">
    jQuery(function(){
        var vil={
            init:function(){
                jQuery(document).on('click','.status_active',function(event){
                    vil.getStatusData(1);
                });
                jQuery(document).on('click','.status_deactive',function(event){
                    vil.getStatusData(0);
                });
            },
            checkNumeric:function () {
                jQuery(document).on('keyup',".numeric",function() {
                    var $this = jQuery(this);
                    $this.val($this.val().replace(/[^\d.]/g, ''));
                });
            },
            getStatusData:function (status) {
                jQuery.ajax({
                    url:"{{route('getClientDataByStatus')}}",
                    type:"GET",
                    data:{status:status},
                    dataType:'html',
                    success: function(response){//debugger;
                        if(response){
                            jQuery('#id-status_change').empty();
                            jQuery('#id-status_change').html(response);
                            jQuery('.search-table').DataTable({
                                    });
                        }else{
                            alert("NO DATA FOUND !!!")
                        }
                    },
                    error: function(err){
                        alert(err) ;
                    }
                });
               return false;
            },
            }
        vil.init();
    });

jQuery('#search-table').DataTable( {
    "language": {
      "emptyTable": "No data available "
    }
} );


</script>
@endsection
