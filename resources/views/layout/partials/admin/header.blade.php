
<li class="user-header">
	<?php
$imgdata = App\Models\AdminImage::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
?>
    <img src="{{my_asset('images/default.png')}}" class="img-circle" style="" alt="User Image"/>
    <p>
        <a style="color: white;" href="{{route('admin.profile')}}">
            <i class=" fa fa-address-card-o" style="font-size:24px"> </i>&nbsp;&nbsp;&nbsp;
            <strong>{{ucfirst(Auth::user()->name)}}</strong>

            <small>{{ucfirst(Auth::user()->user_type)}}</small>
        </a>
    </p>
 </li>
