@extends('layouts.user.app')

@section('content')
    <section id="wrapper" class="login-register">
        <div class="container">
            <div class="banner-page hidden-xs">
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
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4">
                        <div class="show">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="main-container">
                    <div class="kt-login-register">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div id="login-div" class="show">
                                    <form action="{{ route('password.email') }}" class="login-form text-center"
                                          method="POST">
                                        {{ csrf_field() }}
                                        <div class="container title-form" style="padding: 0px">
                                            <div class="col-sm-6" style="padding: 0px">
                                                <h3 class="loggin">Reset Password</h3>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <input class="form-control" type="text" id="email"
                                                   placeholder="Enter your email"
                                                   name="email" value="{{ old('email') }}">
                                            @if ($errors->has('email'))
                                                <span class="help-block" style="text-align: left">
                                                <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                            @endif
                                            {{-- <input type="text" value="{{ old('email') }}">--}}
                                        </div>
                                        <div class="form-submit">
                                            <div class="submit-btn"><input type="submit" value="Confirm"></div>
                                            <a href="{{ url('/')}}">
                                                <div class=" back-btn">Back</div>
                                            </a>
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
