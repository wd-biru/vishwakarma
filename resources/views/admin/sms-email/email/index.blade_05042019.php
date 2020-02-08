@extends('layout.app')
@section('title')
<div class="page-title">
    <div class="div">
        <h1><i class="fa fa-envelope"></i> E-Mail Setting</h1>
    </div>
    <div class="div">
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
            <li><a href="#">E-Mail</a></li>
        </ul>
    </div>
</div>
@endsection
@section('content')
@include('includes.msg')


<div class="row">
    <div class="col-md-12"><a href="#" class="btn btn-primary btn_email" data-id=""  data-toggle="modal" data-target="#myEmail" disabled="disabled">Compose E-Mail</a>
        <div class="content-section">
            <form action="{{route('email.store')}}" method="post">
                {{csrf_field()}}
                <div class="table-responsive">
                    <table  class="table table-bordered main-table search-table">
                        <div><input type="checkbox" id="select_all" on='click' ><label>Select All</label></div>
                        <div><input type="checkbox" id="select_all_alternate" name="alternate" value="true" ><label>Select Alternate Email</label></div>
                        <thead>
                            <tr class="btn-primary">
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($portals as $portal)
                            <tr>
                                <td><input type="checkbox" class="add" value="{{$portal->id}}" name="client_id[]">&nbsp;&nbsp;{{ucfirst($portal->name)}} {{ucfirst($portal->surname)}}</td>
                                <td>{{$portal->getUser->email}}</td>
                                <td>{{$portal->company_mail}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="myEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <form method="post" action="">
                                <div class="modal-header">
                                    {{ csrf_field() }}
                                    <button class="close" data-dismiss="modal" style="padding-left: 130px;">x</button> 
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body"> 
                                             <legend>Email</legend>
                                                <fieldset><br>   
                                                    <div class="form-group">
                                                        <label class="control-label col-md-2">Subject&nbsp;<span style="color: #f70b0b">*</span></label>
                                                        <div class="col-md-10">
                                                        <strong><input class="form-control" type="text" name="subject"  placeholder="Enter  Subject" style="text-transform: capitalize" ></strong>
                                                    </div>
                                                    </div> <br>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-2">Composed&nbsp;<span style="color: #f70b0b">*</span></label>
                                                        <div class="col-md-10">
                                                        <textarea class="form-control" placeholder="enter sms" name="composed_email" style="height: 200px;"></textarea>
                                                    </div>
                                                    </div><br>
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
            jQuery('.btn_email').attr('disabled',false);
        }else{
            jQuery('.btn_email').attr('disabled',true); 
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
                jQuery('.btn_email').attr('disabled',true); 
            });
        }
    });
    
    jQuery('.add').on('click',function(){
        jQuery('.btn_email').attr('disabled',false); 
        if(jQuery('.add:checked').length == jQuery('.add').length){
            jQuery('#select_all').prop('checked',true);
            this.checked = true;
            jQuery('.btn_email').attr('disabled',false); 
        }
        else{
            jQuery('#select_all').prop('checked',false);
            jQuery('.btn_email').attr('disabled',false); 
            
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
