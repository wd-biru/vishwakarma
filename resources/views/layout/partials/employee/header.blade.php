<li class="user-header">

    <img src="{{getEmployeeImageUrl(Auth::user()->getImageEmp->profile_image)}}" class="img-circle" style="" alt="User Image">
   	<p>
    	<a style="color: white;" href="{{route('employee.profile')}}">
        	<i class=" fa fa-address-card-o" style="font-size:24px"> </i>&nbsp;&nbsp;&nbsp;
    		<strong>{{ucfirst(Auth::user()->name)}}</strong>
            <small>{{ucfirst(Auth::user()->user_type)}}</small>
     	</a>
   	</p>
</li>
