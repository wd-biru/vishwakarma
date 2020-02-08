@if(Session::has('error_message'))
<p class="alert alert-danger"  style="font-size: 16px;">{{ Session::get('error_message') }}</p>
@endif
@if(Session::has('success_message'))
<p class="alert alert-success"  style="font-size: 16px;">{{ Session::get('success_message') }}</p>
@endif
@if(Session::has('message'))
<p class="alert alert-info" style="font-size: 16px;">{{ Session::get('message') }}</p>
@endif