@extends('admin.auth')

@section('content')
        <!-- Reset recovery -->
<form role="form" method="POST" action="{{ url('/password/reset') }}">
    {!! csrf_field() !!}

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="panel panel-body login-form">
        <div class="text-center">
            <div class="icon-object border-warning text-warning"><i class="icon-spinner11"></i></div>
            <h5 class="content-group">Reset password
                <small class="display-block">Type a new password here</small>
            </h5>
        </div>

        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
            <input type="email" class="form-control" placeholder="Your email" name="email"
                   value="{{ $email or old('email') }}">
            <div class="form-control-feedback">
                <i class="icon-mail5 text-muted"></i>
            </div>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" class="form-control" placeholder="Password" name="password">
            <div class="form-control-feedback">
                <i class="icon-key text-muted"></i>
            </div>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <input type="password" class="form-control" placeholder="Confirm password" name="password_confirmation">
            <div class="form-control-feedback">
                <i class="icon-key text-muted"></i>
            </div>
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>

        <button type="submit" class="btn bg-blue btn-block">Reset password <i
                    class="icon-arrow-right14 position-right"></i></button>
    </div>
</form>
@endsection
