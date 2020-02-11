<header class="main-header hidden-print">
    @switch(Auth::user()->user_type)
        @case('admin')
        <a class="logo" href="{{route('admin.dashboard')}}"> <img src="{{my_asset('images/headlogo.png')}}"></a>
        @break
        @case('portal')
        <a class="logo" href="{{route('portal.dashboard')}}"> <img src="{{my_asset('images/headlogo.png')}}"></a>
        @break
        @case('employee')
        <a class="logo" href="{{route('employee.dashboard')}}"> <img src="{{my_asset('images/headlogo.png')}}"></a>
        @break
        @case('vendor')
        <a class="logo" href="{{route('vendor.dashboard')}}"> <img src="{{my_asset('images/headlogo.png')}}"></a>
        @break
    @endswitch

    <nav class="navbar navbar-static-top">
        <span class="span-img"><img src="{{my_asset('images/nirmanmantra.png')}}" alt="vishwakarmaTagline"/></span>
        <!-- Sidebar toggle button-->
        <a class="sidebar-toggle" href="#" data-toggle="offcanvas"></a>
        <div class="header-top text-center "></div>



        <!-- Navbar Right Menu-->
        <div class="navbar-custom-menu">
            <div class="navbar navbar-default navbar-top">
                <!--NOTIFICATIONS START-->
                <div class="menu">

                    <div class="notifications-header"><p>{{__('Notifications')}}</p></div>
                    <!-- Menu -->
                    <ul>
                        <?php $notifications = auth()->user()->unreadNotifications; ?>

                        @foreach($notifications as $notification)

                            <a href="{{ route('notification.read', ['id' => $notification->id])  }}"
                               onClick="postRead({{ $notification->id }})">
                                <li>
                                    <img src="/{{ auth()->user()->avatar }}" class="notification-profile-image">
                                    <p>{{ $notification->data['message']}}</p></li>
                            </a>
                        @endforeach
                    </ul>
                </div>

                <div class="dropdown" id="nav-toggle">
                    <a id="notification-clock" role="button" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-bell"><span id="notifycount">{{ $notifications->count() }}</span></i>
                    </a>
                </div>
                @push('scripts')
                    <script>
                        $('#notification-clock').click(function (e) {
                            e.stopPropagation();
                            $(".menu").toggleClass('bar')
                        });
                        $('body').click(function (e) {
                            if ($('.menu').hasClass('bar')) {
                                $(".menu").toggleClass('bar')
                            }
                        })
                        id = {};

                        function postRead(id) {
                            $.ajax({
                                type: 'post',
                                url: '{{url('/notifications/markread')}}',
                                data: {
                                    id: id,
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                        }

                    </script>
            @endpush
            <!--NOTIFICATIONS END-->
                <button type="button" id="mobile-toggle" class="navbar-toggle mobile-toggle" data-toggle="offcanvas"
                        data-target="#myNavmenu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <ul class="top-nav pull-right" style="height: 25px;">










                <li class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false" style="    margin-top:34px;  ">
                        <i class="fa fa-user fa-lg">&nbsp;&nbsp;{{ucfirst(Auth::user()->name)}}</i>
                    </a>
                    <ul class="dropdown-menu settings-menu" style="background-color: #d8322c; color:#333;">
                        <!-- User image -->
                        <input type="hidden" name="" value="{{$role_type = Auth::user()->user_type}}">
                        <!-- HEADER DROPDOWN -->
                        @switch(Auth::user()->user_type)
                            @case('admin')
                            <li class="user-header">
                                <?php
                                $imgdata = App\Models\AdminImage::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
                                ?>
                                @if($imgdata!=null && getAdminImageUrl($imgdata->image_name))
                                    <img src="{{getAdminImageUrl($imgdata->image_name)}}" class="img-circle" style=""
                                         alt="User Image"/>
                                @else
                                <!-- <img src="{{my_asset('images/default.png')}}" class="img-circle" style="" alt="User Image"/> -->
                                @endif
                                <p>
                                    <a style="color: white; font-size:15px;" href="{{route('admin.profile')}}">

                                        <strong>{{ucfirst(Auth::user()->name)}}</strong>
                                    <!-- <small>{{ucfirst(Auth::user()->user_type)}}</small> -->
                                    </a>
                                </p>
                            </li>
                        @break
                        @case('portal')
                        @include('layout.partials.portal.header')
                        @break
                        @case('employee')
                        @include('layout.partials.employee.header')
                        @break
                        @case('vendor')
                        @include('layout.partials.vendor.header')
                        @break
                    @endswitch

                    <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn" data-toggle="modal" data-target="#ChangePassword"
                                   style="color:#fff"><i class="fa fa-key"></i> Change Password</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                   class="btn" style="color:#fff">
                                    <i class="fa fa-power-off"></i>Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>

    </nav>

</header>


<!-- CHANGE PASSWORD MODAL -->

<div class="modal" id="ChangePassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" style="    padding-left: 135px;">x</button>
                <h4><i class="fa fa-key"></i><span>Change Password</span></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{route('login.passwordChange')}}" method="post"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-4">Email&nbsp;<span style="color: #f70b0b">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" value="{{Auth::user()->email}}" name="email"
                                   placeholder="xxxxx@xxx.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Password</label>
                        <div class="col-md-8">
                            <input class="form-control" id="password" type="password" value="{{Auth::user()->password}}"
                                   autocomplete="off" class="effect-2" name="password" placeholder="Password" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <input class="btn btn-primary" type="submit" name="save" value="save">
            </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL CHANGE PASSWORD -->
