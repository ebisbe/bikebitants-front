@extends('layouts.auth')

@section('content')

    <form role="form" method="POST" action="{{ url('/register') }}">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <div class="panel registration-form">
                    <div class="panel-body">
                        <div class="text-center">
                            <div class="icon-object border-success text-success"><i class="icon-plus3"></i></div>
                            <h5 class="content-group">Create account
                                <small class="display-block">All fields are required</small>
                            </h5>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-feedback  {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                           placeholder="Your Name">
                                    <div class="form-control-feedback">
                                        <i class="icon-user-check text-muted"></i>
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="help-block text-danger"><i
                                                    class="icon-cancel-circle2 position-left"></i> {{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-feedback  {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                           placeholder="Your email">
                                    <div class="form-control-feedback">
                                        <i class="icon-mention text-muted"></i>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="help-block text-danger"><i
                                                    class="icon-cancel-circle2 position-left"></i> {{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-feedback  {{ $errors->has('company') ? ' has-error' : '' }}">
                                    <input type="text" class="form-control" name="company" value="{{ old('company') }}"
                                           placeholder="Company">
                                    <div class="form-control-feedback">
                                        <i class="icon-office text-muted"></i>
                                    </div>
                                    @if ($errors->has('company'))
                                        <span class="help-block text-danger"><i
                                                    class="icon-cancel-circle2 position-left"></i> {{ $errors->first('company') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-feedback  {{ $errors->has('telephone') ? ' has-error' : '' }}">
                                    <input type="text" class="form-control" name="telephone"
                                           value="{{ old('telephone') }}"
                                           placeholder="Telephone">
                                    <div class="form-control-feedback">
                                        <i class="icon-mobile3 text-muted"></i>
                                    </div>
                                    @if ($errors->has('telephone'))
                                        <span class="help-block text-danger"><i
                                                    class="icon-cancel-circle2 position-left"></i> {{ $errors->first('telephone') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-feedback  {{ $errors->has('web') ? ' has-error' : '' }}">
                                    <input type="text" class="form-control" name="web" value="{{ old('web') }}"
                                           placeholder="Website">
                                    <div class="form-control-feedback">
                                        <i class="fa fa-globe text-muted"></i>
                                    </div>
                                    @if ($errors->has('web'))
                                        <span class="help-block text-danger">
                                            <i class="icon-cancel-circle2 position-left"></i> {{ $errors->first('web') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="content-divider text-muted form-group"><span>Your privacy</span></div>

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group has-feedback  {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <input type="password" class="form-control" name="password"
                                           value="{{ old('password') }}"
                                           placeholder="Your Password">
                                    <div class="form-control-feedback">
                                        <i class="icon-user-lock text-muted"></i>
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="help-block text-danger"><i
                                                    class="icon-cancel-circle2 position-left"></i> {{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <input type="password" class="form-control" name="password_confirmation"
                                           value="{{ old('password_confirmation') }}"
                                           placeholder="Repeat your password">
                                    <div class="form-control-feedback">
                                        <i class="icon-user-lock text-muted"></i>
                                    </div>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block text-danger"><i
                                                    class="icon-cancel-circle2 position-left"></i> {{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                       {{-- <div class="content-divider text-muted form-group"><span>Additions</span></div>

                        <div class="form-group">

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="styled">
                                    Accept <a href="#">terms of service</a>
                                </label>
                            </div>
                        </div>--}}

                        <button type="submit" class="btn bg-teal btn-block btn-lg">Register <i
                                    class="icon-circle-right2 position-right"></i></button>
                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection
