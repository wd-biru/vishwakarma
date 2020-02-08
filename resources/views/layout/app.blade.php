<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!--bootstrap default css-->
  <link href="{{ my_asset('css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- CSS-->
  <link rel="stylesheet" type="text/css" href="{{my_asset('css/main.css')}}">
  <link href="{{my_asset('css/style.css')}}" type="text/css" rel="stylesheet">

  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
      span.select2.select2-container.select2-container--default.select2-container--above{
         width: 100%!important;
      }
      .select2-container {
        width: 100% ;
      }
      .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #211d1d !important;
      }
    </style>
    <style type="text/css">
      .addmore{
        margin-bottom: 2px;
        padding: 9px 21px !important;
        text-transform: none;
        font-size: 13px !important;
      }

button.dt-button, div.dt-button, a.dt-button {

background-image: linear-gradient(to bottom, #8a0f0a 0%, #de3d38 100%)!important;
filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,StartColorStr='white', EndColorStr='#00786a') ;
-webkit-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
user-select: none;
text-decoration: none;
outline: none;
color:white!important;
}
.dt-buttons {
float: left!important;
</style>
  <link rel="icon" href="{{ my_asset('images/logo1.png') }}" type="image/x-icon">
  @yield('header')
  <title>Vishwakrama! Nirman Mantra!!</title>
</head>
  <body class="sidebar-mini fixed">
  <div class="wrapper">
    @include('layout.header')
    @include('layout.left-sidebar')
      <div class="content-wrapper">
      	@yield('pmo_title')
      	@yield('title')
        @include('flash::message')
        @yield('content')
      </div>
     @include('layout.footer')
  </div>

  <script>
      $(document).ready(function() {
          $('.search-table').DataTable({
            "language": {
      "emptyTable": "No data available"
    }

          });


          $('#searchlast').DataTable({
            "language": {
      "emptyTable": "No data available"
    }

          });
      } );


      $(document).ready(function() {

$('.selectable').select2();
});
  </script>
  <script type="text/javascript">
      var url = window.location;
      // for sidebar menu entirely but not cover treeview
      $('ul.sidebar-menu a').filter(function () {
          return this.href == url;
      }).parent().addClass('active');

      // for treeview
      $('ul.treeview-menu a').filter(function () {
          return this.href == url;
      }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');
  </script>
	@yield('script')
  </body>
</html>
