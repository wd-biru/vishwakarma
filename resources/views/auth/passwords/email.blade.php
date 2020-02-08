@extends('layouts.app')

@section('content')
<section class="main-wrapp">
    <div class="login-wrapper">
       <div class="login-section">
         <div class="formtitle">
          <h3>Reset Password</h3>
        </div>
         @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
         <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input id="email" type="email" class="effect-2" name="email" value="{{ old('email') }}" placeholder="E-Mail Address" required>
                     <span class="focus-border"></span>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
               </div>
               
                     <div class="form-group btnlogin">
            <input type="submit" value=" Send Password Reset Link" class="btn btn-success">
          </div>
        </form>
       </div>
    </div>
  
  </section>
@endsection
