@extends('layouts.auth')

@section('content')
    @php
    use App\Adinton\StaticVars;
    @endphp
            <!-- Simple login form -->
    <form action="{{ url('/login') }}" role="form" method="post">
        {!! csrf_field() !!}
        <div class="panel panel-body login-form">
            <div class="text-center">
                <div class="icon-object border-slate-300 text-slate-300"><i
                            class="fa "></i></div>
                <h5 class="content-group">Login to your account
                    <small class="display-block">Enter your credentials below</small>
                </h5>
            </div>

            <div class="form-group has-feedback has-feedback-left {{ $errors->has('email') ? ' has-error' : '' }}">
                <input class="form-control" name="email" placeholder="E-mail address" type="email"
                       value="{{old('email')}}">
                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
                </div>
                @if ($errors->has('email'))
                    <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group has-feedback has-feedback-left {{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" name="password" class="form-control" placeholder="Password"
                       value="{{old('password')}}">
                <div class="form-control-feedback">
                    <i class="icon-lock2 text-muted"></i>
                </div>
                @if ($errors->has('password'))
                    <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Sign in <i
                            class="icon-circle-right2 position-right"></i></button>
            </div>

            <div class="text-center">
                <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
            </div>

            <div class="content-divider text-muted form-group"><span>Don't have an account?</span></div>
            <a href="{{ url('register') }}" class="btn btn-default btn-block content-group">Sign up</a>
            <span class="help-block text-center no-margin">By continuing, you're confirming that you've read our <a href="#">Terms &amp; Conditions</a> and <a href="#">Cookie Policy</a></span>

        </div>
    </form>
    <!-- /simple login form -->
@endsection
