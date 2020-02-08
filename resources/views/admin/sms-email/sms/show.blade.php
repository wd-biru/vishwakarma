@extends('layout.app')
@section('title')
<div class="page-title">
    <div class="div">
        <h1><i class="fa fa-laptop"></i>Sms Setting</h1>
    </div>
    <div class="div">
        <ul class="breadcrumb">
            <li><i class="fa fa-home fa-lg"></i></li>
            <li><a href="#">Sms Setting</a></li>
        </ul>
    </div>
</div>
@endsection
@section('content')
@include('includes.msg')
<h1>under work</h1>
@endsection

@section('script')

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#show-message-box').hide();
        jQuery('#sms_id').on('change',function(){
            var id = jQuery('#sms_id :selected').data('id');console.log(id);
            jQuery('#show-message-box').show();
            jQuery('#client_id').val(id);
        });
    });
   
</script>
@endsection
