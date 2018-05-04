@extends('layouts.user.app')

@section('content')
    <section id="wrapper" class="">
        <div class="container">
            <div class="banner-page hidden-xs" >
                <img src="{{asset("images/banner-default.png")}}">
            </div>
            <div class="section-breadcrumb">
                <div class="breadcrumb">
                    <a href="{{ url('/') }}">Home</a>
                    <li class="active">Reset password</li>
                </div>
            </div>
        </div>

        <div class="login-box">
            <div class="white-box">
                <div class="main-container">
                    <div class="kt-login-register">
                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-4">
                                <div class="show">
                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    <form class="form-horizontal" role="form" method="POST"
                                          action="{{ route('password.request') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <div class="form-group ">
                                            <div class="col-xs-12">
                                                <h3>Reset Password</h3>

                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label for="email" class="col-xs-12">E-Mail Address *</label>
                                            <div class="col-xs-12">
                                                <input id="email" type="text" class="form-control" name="email"
                                                       value="{{ old('email') }}">
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label for="password" class="col-xs-12">Password *</label>
                                            <div class="col-xs-12">
                                                <input id="password" type="password" class="form-control"
                                                       name="password"
                                                >
                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password-confirm" class="col-xs-12">Confirm
                                                Password *</label>

                                            <div class="col-xs-12">
                                                <input id="password-confirm" type="password" class="form-control"
                                                       name="password_confirmation">
                                            </div>
                                        </div>
                                        <div class="form-group text-center m-t-20">
                                            <div class="col-xs-12">
                                                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light"
                                                        type="submit">Confirm
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
@endsection
