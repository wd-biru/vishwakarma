@extends('layouts.app')


@section('content')
    <div class="main-bg">
    <h1></h1>
    <!-- content -->
    <div class="sub-main-w3">
      <div class="bg-content-w3pvt">
        <div class="top-content-style">
          <img src="{{my_asset('images/logo.png')}}" alt="" style=" height: 152px" />
        </div>
        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
           {{csrf_field()}}
          <p class="legend">Login Here<span class=""></span></p>
          <div class="input{{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="text" class="user" name="email" placeholder="Enter Your Email" value="{{ old('email') }}" required autofocus>
             <span class="fa fa-envelope"></span>
          </div>
             @if ($errors->has('email'))
              <span class="help-block" style="text-align: center;">
              <strong style="font-size: 12px; color:red; font-weight:500;">Your User Id and Password does not match.</strong>
             </span>
             @endif
          <div class="input{{ $errors->has('password') ? ' has-error' : '' }}">
            <input id="password" type="password" class="lock" name="password" placeholder="Password" required>
            <span class="fa fa-unlock"></span>
            <span class="focus-border"></span>
            @if ($errors->has('password'))
            <span class="help-block">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
          </div>
                  
          <button type="SUBMIT" class="btn submit">
            <a href="#"><span class="fa fa-sign-in"></span></a>
          </button>
          <div class="form-group">
          <div class="row">
            <div class="col-sm-12 col-lg-12 col-xs-12 col-md-6">
              <div class="alert alert-success" id="alertURSuccess" style="display:none">
                <strong id="alertURSuccessMsg"></strong>
              </div>
              <div class="alert alert-danger" id="alertURError" style="display:none">
                <strong id="alertURErrorMsg"></strong>
              </div>
            </div>
          </div>
        </div>

        </form>
         <h4 style="padding-bottom: 16px; font-weight: bold; color: #242424; font-size: 11PX;">AN INOVATIVE WAY TO MANAGE YOUR CONSTRUCTION</a>
      </div>
    </div>
    <!-- //content -->
    <!-- copyright -->
    <div class="copyright">
      <h2>  Copyright © 2019</h2>
    </div>
    <!-- //copyright -->
  </div>
 <!-- <div class="body">
  <div class="main-content">
    <div id="page-wrapper" class="Login-Background" style="min-height: 417px;">
      <div class="main-page login-page ">
       <div class="top">
         <img src="{{my_asset('images/logo_new.png')}}" alt="logo" style="height:auto;"><hr>
       </div>
       <div class="widget-shadow" style="background-color:rgb(255, 255, 255) !important;padding-top:0px; padding-bottom: 10px;">
        <div class="login-body">
         <form class="form-horizontal" method="POST" action="{{ route('login') }}">
           {{csrf_field()}}
           <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <div class="col-md-12">
             <input id="email" type="text" class="user" name="email" placeholder="Enter Your Email" value="{{ old('email') }}" required autofocus>
             <span class="focus-border"></span>
             @if ($errors->has('email'))
              <span class="help-block" style="text-align: center;">
          <strong style="font-size: 12px; color:red; font-weight:500;">Your User Id and Password does not match.</strong>
        </span>
        @endif
           </div>
         </div>


         <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

          <div class="col-md-12">
            <input id="password" type="password" class="lock" name="password" placeholder="Password" required>
            <span class="focus-border"></span>
            @if ($errors->has('password'))
            <span class="help-block">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif 
          </div>
        </div>

        <div class="forgot-grid">          

          <div class="clearfix"> </div>
        </div>
        
        <hr>
        <div class="form-group" style="text-align: center;    margin-top: 20px;">
          <button type="SUBMIT" id="btnALogin" class="loginbtn"><i class="fa fa-sign-in"></i> Sign In</button>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-sm-12 col-lg-12 col-xs-12 col-md-6">
              <div class="alert alert-success" id="alertURSuccess" style="display:none">
                <strong id="alertURSuccessMsg"></strong>
              </div>
              <div class="alert alert-danger" id="alertURError" style="display:none">
                <strong id="alertURErrorMsg"></strong>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

</div>
</div>
</div>

</div> -->

@endsection
