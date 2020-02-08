    <?php
$imgdata = App\Models\AdminImage::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
?>
<aside class="main-sidebar hidden-print">
    <section class="sidebar">
        <div class="user-panel"><input type="hidden" name="" value="{{$role_type = Auth::user()->user_type}}">

              @if($role_type == 'portal')
            <div class="pull-left image"><img src="{{my_asset('images/logo3.png')}}" alt="User Image" style="height:127px; max-width: none; padding-left: 4px; z-index:999;"></div>
            @elseif($role_type == 'admin')
            <!-- getAdminImageUrl($imgdata->image_name) -->
            <div class="pull-left image"><img src="{{my_asset('images/logo3.png')}}" alt="User Image" style="height:127px; max-width: none; padding-left: 4px; z-index:999;"></div>
            @elseif($role_type == 'employee')
            <div class="pull-left image"><img src="{{my_asset('images/logo3.png')}}" alt="User Image" style="height:127px; max-width: none; padding-left: 4px; z-index:999;"></div> 
            @elseif($role_type == 'vendor')
            <div class="pull-left image"><img src="{{my_asset('images/logo3.png')}}" alt="User Image" style="height:127px; max-width: none; padding-left: 4px; z-index:999;"></div>
            @endif
            <br>
            <!-- <div class="pull-center info">

            &nbsp;&nbsp;&nbsp;&nbsp;<strong style="font-size: 19px;"><em>{{ucfirst(Auth::user()->name)}}</em></strong><br>
            &nbsp;&nbsp;&nbsp;&nbsp;<small style="font-size: 12px;"><em>(&nbsp;{{ucfirst(Auth::user()->user_type)}}&nbsp;)</em></small>

            </div> -->

        </div>
      <!-- Sidebar Menu-->
        <ul class="sidebar-menu" style="margin-top:none !important;">
            @switch(Auth::user()->user_type)
                @case('admin')
                    @include('layout.partials.admin.sidebar')
                @break
                @case('portal')
                    @include('layout.partials.portal.sidebar')
                @break
                @case('employee')
                    @include('layout.partials.employee.sidebar')
                @break
                @case('vendor')
                    @include('layout.partials.vendor.sidebar')
                @break
            @endswitch
        </ul>
    </section>
</aside>
