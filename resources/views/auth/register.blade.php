@extends('layouts.app')


@section('content')<br><br>
<section class="main-wrapp">
    <div class="login-wrapper">
       <div class="login-section">
         <div class="formtitle">
          <h3>Register</h3>
        </div>
         <form class="form-horizontal" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <input id="name" type="text" class="effect-2" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>
                                <span class="focus-border"></span>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                        </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                         <input id="email" type="email" class="effect-2" name="email" value="{{ old('email') }}" placeholder="E-Mail Address" required>
                         <span class="focus-border"></span>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" type="password" class="effect-2" name="password" placeholder="Password" required>
                    <span class="focus-border"></span>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                </div>

                  <div class="form-group">
                    <input id="password-confirm" type="password" class="effect-2" name="password_confirmation" placeholder="Confirm Password" required>
                    <span class="focus-border"></span>
                  </div>
 <div class="form-group btnlogin">
            <input type="submit" value="Register" class="btn btn-success">
          </div>
        </form>
       </div>
    </div>
  
  </section>

@endsection
