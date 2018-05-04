@extends('layouts.user.app')
@section('content')

    <div class="main-wrapper">
        <div class="container">
            <div class="banner-page hidden-xs">
                <img src="{{asset("images/banner-default.png")}}">
            </div>
            <div class="section-breadcrumb">
                <div class="breadcrumb">
                    <a href="{{ url('/') }}">Home</a>
                    <span>Login</span>
                </div>
            </div>
            <div class="main-container">
                <div class="kt-login-register">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div id="login-div" class="show">
                                <form action="{{ route('login') }}" class="login-form text-center" method="POST">
                                    {{ csrf_field() }}
                                    <div class="container title-form" style="padding: 0px">
                                        <div class="col-sm-6" style="padding: 0px">
                                            <h3 class="loggin">Login</h3>
                                        </div>
                                        <div class="col-sm-6" style="padding: 0px">
                                            <h4><a href="{{ url('/register')}}" class="register">Register</a></h4>
                                        </div>
                                    </div>


                                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label>EMAIL ADDRESS <span class="special-digit">*</span></label>
                                        <input class="form-control" type="text" placeholder="" id="email"
                                               name="email" value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <span class="help-block" style="text-align: left">
                                                <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                        {{-- <input type="text" value="{{ old('email') }}">--}}
                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label>PASSWORD <span class="special-digit">*</span></label>

                                        <input class="form-control" type="password" placeholder=""
                                               id="password"
                                               name="password">
                                        @if ($errors->has('password'))
                                            <span class="help-block" style="text-align: left">
                                                <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                            <div class="group-checkbox">
                                                <input id="remember" type="checkbox" name="remember">
                                                <label for="remember">Keep me logged in</label>
                                            </div>
                                            <div class="form-submit"><input type="submit" value="Login"></div>
                                    <div class="text-small">Forgot your password?
                                        <a href="{{ url('password/reset')}}" class="lost-password ">Reset here</a>
                                    </div>
                                    {{--<div style="text-align: right">--}}
                                        {{--<span class="special-digit">*</span> Indicates required field--}}
                                    {{--</div>--}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

