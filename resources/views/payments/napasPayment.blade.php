@extends('layouts.payment')

@section('content')
    @include ('payments.form')
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <form id="merchant-form" action="{{ $postUrl }}" method="POST">
                    <div id="napas-widget-container"></div>
                    <script type="text/javascript"
                            id="napas-widget-script"
                            src="{{ config('constants.NAPAS.URL') . '/api/restjs/resources/js/napas.hostedform.min.js' }}"
                            merchantId="{{ config('constants.NAPAS.MERCHANT') }}"
                            clientIP="{{ $payData['clientIp'] }}"
                            deviceId="{{ $payData['deviceId'] }}"
                            environment="WebApp"
                            cardScheme="{{ $payData['cardScheme'] }}"
                            enable3DSecure="false"
                            apiOperation="PAY"
                            orderAmount="{{ $payData['amount'] }}"
                            orderCurrency="VND"
                            orderReference="{{ $payData['orderRef'] }}"
                            orderId="{{ $payData['orderId'] }}"
                            channel="7399"
                            sourceOfFundsType="CARD"
                            dataKey="{{ $dataKey }}"
                            napasKey="{{ $napasKey }}">
                    </script>
                </form>
            </div>
        </div>
    </div>
@endsection
