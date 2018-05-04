@extends('emails.app_vi')

@section('content')
    Welcome {{ $params['full_name'] }},
    <br/>
    <br/>
    Welcome {{ config('app.name') }}.
    Please, click on link as below to reset password.
    <br/>
    <br/>
    <div style="text-align: center">
        <a href="{{ $params['reset_password_url'] }}" target="_blank"
           style="margin:20px 0px; text-decoration:none !important; border: solid 1px #CCC; display: inline-block; background-color: rgb(28, 184, 65) !important;color: white !important; padding: 6px 10px;font-size: 20px; font-weight: 700">
           Reset Password
        </a>
    </div>
    <br/>
    <br/>
    This link will be expired in 1 hour. Let recover password as soon as possible.
    <br/>
    <br/>
    Best regards,
    <br/>
    {{ config('app.name') }}
@endsection
