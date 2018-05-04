@extends('emails.app_vi')

@section('content')
    Hi, {{ $params['full_name'] }},
    <br/>
    <br/>
    Welcome {{ config('app.name') }}.
    Please, click on link as below to see your order.
    <br/>
    <br/>
    <div style="text-align: center">
        <a href="{{ $params['url'] }}" target="_blank"
           style="margin:20px 0px; text-decoration:none !important; border: solid 1px #CCC; display: inline-block; background-color: rgb(28, 184, 65) !important;color: white !important; padding: 6px 10px;font-size: 20px; font-weight: 700">
            Your Order
        </a>
    </div>
    <br/>
    <br/>
    Feedback message: {{$params['feedback_message']}}.
    <br/>
    <br/>
    Best regards,
    <br/>
    {{ config('app.name') }}
@endsection
