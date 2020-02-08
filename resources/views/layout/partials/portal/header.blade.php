<li class="user-header">
	<img src="{{getPortalImageUrl(Auth::user()->getImage->logo_img)}}" class="img-circle" style="" alt="User Image"/>
	<p>
		<a style="color: white;" href="{{route('portal.profile')}}">
	   		<i class=" fa fa-address-card-o"  style="font-size:24px"></i>&nbsp;&nbsp;&nbsp;
			<strong>{{ucfirst(Auth::user()->name)}}</strong>
            <small>{{ucfirst(Auth::user()->user_type)}}</small>
 		</a>
 	</p>
</li>

