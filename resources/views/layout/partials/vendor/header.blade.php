
<li class="user-header">
    <img src="{{getVendorImageUrl(Auth::user()->getImageVendor->logo_img)}}" class="img-circle" style="" alt="User Image"/>
    <p>
        <a style="color: white;" href="{{route('vendor.profile')}}">
            <i class=" fa fa-address-card-o" style="font-size:24px"> </i>&nbsp;&nbsp;&nbsp;
            <strong>{{ucfirst(Auth::user()->name)}}</strong>

            <small>{{ucfirst(Auth::user()->user_type)}}</small>

        </a>
     </p>
     <p><small>{{ucfirst(Auth::user()->getVendor->company_name)}}</small></p>
   
 </li>




