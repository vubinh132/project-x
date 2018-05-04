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
                    <span>Register</span>
                </div>
            </div>
            <div class="main-container">
                <div class="kt-login-register">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div id="login-div" class="show">
                                <form action="{{ route('register') }}" class="login-form text-center" method="POST">
                                    {{ csrf_field() }}
                                    <div class="container title-form" style="padding: 0px">
                                        <div class="col-sm-6" style="padding: 0px">
                                            <h3 class="loggin">Register</h3>
                                        </div>
                                        <div class="col-sm-6" style="padding: 0px">
                                            <h4><a href="{{ url('/login')}}" class="register">Login</a></h4>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('full_name') ? ' has-error' : '' }}">
                                        <label>Name <span class="special-digit">*</span></label>
                                        <input class="form-control" type="text" id="full_name"
                                               name="full_name" value="{{ old('full_name') }}">
                                        @if ($errors->has('full_name'))
                                            <span class="help-block" style="text-align: left">
                                                <strong>{{ $errors->first('full_name') }}</strong>
                                        </span>
                                        @endif
                                        {{-- <input type="text" value="{{ old('email') }}">--}}
                                    </div>
                                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label>EMAIL <span class="special-digit">*</span></label>
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
                                        <input class="form-control" type="password" id="password" name="password">
                                        @if ($errors->has('password'))
                                            <span class="help-block" style="text-align: left">
                                                <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>CONFIRM PASSWORD <span class="special-digit">*</span></label>
                                        <input class="form-control" type="password" id="password-confirm"
                                               name="password_confirmation">
                                    </div>
                                    <div class="form-submit"><input type="submit" value="Register"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
