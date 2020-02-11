<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>Vishwakrama! Nirman Mantra!!</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    {{--<script type="text/javascript" src=" {{my_asset('')}}"></script>--}}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <!-- Styles -->
    <link href="{{ my_asset('css/app.css') }}" rel="stylesheet" >
    <link href="{{ my_asset('css/login-style.css') }}" rel="stylesheet" media="all">
    <link href="{{ my_asset('css/plugins/font-awesome.min.css') }}" rel="stylesheet">
     
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

        <!-- web-fonts -->
    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
     rel="stylesheet">
    <!-- //web-fonts -->

    <style>
        body{
            color: #222;
            overflow-x: hidden;
        }
        .btn-primary {
            color: #fff;
            background-color: #007d71;
            border-color: #007d71;
        }
        .btn-primary:hover  {
            color: #fff;
            background-color: #02ceba;
            border-color: #02ceba;
        }
        .navbar-static-top {
            border-radius: 0;
            background: #007d71;
        }
       .logo {
            display: block;
            width: 230px;
            height: 50px;
            font-size: 24px;
            font-weight: 600;
            line-height: 50px;
            padding: 0 15px;
            float: left;
            overflow: hidden;
           color: #fff;

        }
        .panel-default>.panel-heading {
            color: #fff;
            background-color: #007d71;
            border-color: #007d71;
        }
        .panel-default {
            border-color: #007d71;
        }
       .logo:hover{
           text-decoration: none;
       }
        a:hover{
            color: #fff;
        }
    </style>
    <link rel="icon" href="{{ my_asset('images/favicon.ico') }}" type="image/x-icon">
</head>
<body>
    <div id="app">
        

             
         

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                           <!-- <li><a href="{{ route('login') }}">Login</a></li> -->
                           <!-- <li><a href="{{ route('register') }}">Register</a></li> -->
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ my_asset('js/app.js') }}"></script>


   

</body>
</html>
