@extends('layout.app')
@section('title')
<div class="page-title">
    <div class="div">
        <h1><i class="fa fa-comments-o"></i> SMS Setting</h1>
    </div>
    <div class="div">
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
            <li><a href="#">SMS</a></li>
        </ul>
    </div>
</div>
@endsection
@section('content')
@include('includes.msg')


<div class="row">
    <div class="col-md-12"><a href="#" class="btn btn-primary btn_sms" data-id=""  data-toggle="modal" data-target="#mySms" disabled="disabled">Compose Sms</a></div>
    <div class="col-md-12">
        <div class="content-section">
            <form action="{{route('sms.store')}}" method="post">
                {{ csrf_field() }}
                <div class="table-responsive" id="main-table">
                    <table  class="table table-bordered search-table" id="table-wrap">
                        <div><input type="checkbox" id="select_all" on='click' ><label>Select All</label></div>
						<div><input type="checkbox" name="alternate" id="select_all_alternate" value="true" ><label>Select Alternate Mobile</label></div>
                        <thead>
                            <tr class="btn-primary">
                                <th>Name</th>
	                            <th>Mobiile</th>
	                            <th>Company Mobile</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                 		@foreach($portals as $portal)
	                        <tr>
	                        	<td><input type="checkbox" class="add" value="{{$portal->id}}" name="client_id[]">&nbsp;&nbsp;{{ucfirst($portal->name)}} {{ucfirst($portal->surname)}}</a></td>
	                        	<td>{{$portal->mobile}}</td>
                                <td>{{$portal->company_mobile}}</td>
	                        </tr>
	                        @endforeach
	                    </tbody>
	                </table>
	            </div>
                <div class="modal fade" id="mySms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <form method="post" action="">
                                <div class="modal-header">
                                    {{ csrf_field() }}
                                    <button class="close" data-dismiss="modal" style="padding-left: 130px;">x</button> 
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body"> 
                                                <legend>Sms</legend>
                                                <fieldset><br>  
                                                    <div class="form-group">
                                                        <label class="control-label col-md-2">Sms&nbsp;<span style="color: #f70b0b">*</span></label>
                                                        <div class="col-md-10">
                                                        <textarea class="form-control" placeholder="enter sms" name="composed_sms" style="height: 80px;"></textarea>
                                                    </div>
                                                    </div>
                                                </fieldset><br>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit" id="submit_btn" class="btn btn-primary pull-right">Send</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                           </form>          
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>            

@endsection
@section('script')
<script type="text/javascript">

    function buttonevent(){
        if (true) {
            jQuery('.btn_sms').attr('disabled',false);
        }else{
            jQuery('.btn_sms').attr('disabled',true); 
        }
    }
    
    jQuery(document).on('click','#select_all',function(){
        if(this.checked){
            jQuery('.add').each(function(){
                this.checked = true;
                buttonevent(true);
                
            });
                
        }else{
            jQuery('.add').each(function(){
                this.checked = false;      
                jQuery('.btn_sms').attr('disabled',true); 
            });
        }
    });
    
    jQuery('.add').on('click',function(){
        jQuery('.btn_sms').attr('disabled',false); 
        if(jQuery('.add:checked').length == jQuery('.add').length){
            jQuery('#select_all').prop('checked',true);
            this.checked = true;
            jQuery('.btn_sms').attr('disabled',false); 
        }
        else{
            jQuery('#select_all').prop('checked',false);
            jQuery('.btn_sms').attr('disabled',false); 
            
        }
    });

       jQuery(document).on('click','#select_all_alternate',function(){
       
        if(this.checked){
            jQuery('.add_alternate').each(function(){
                this.checked = true;
                
            });
            
        }else{
             jQuery('.add_alternate').each(function(){
                this.checked = false;
            });
        }
    });
    
    jQuery('.add_alternate').on('click',function(){

        if(jQuery('.add_alternate:checked').length == jQuery('.add_alternate').length){
            jQuery('#select_all_alternate').prop('checked',true);
        }else{
            jQuery('#select_all_alternate').prop('checked',false);
        }
    });




</script>
@endsection