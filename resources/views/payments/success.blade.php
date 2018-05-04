@extends('layouts.payment')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box text-center">
                <h2>{{ __('payment.success.title') }}</h2>
                @if(isset($successUrl))
                    <h3>{{ __('payment.success.back_message') }} <span id="textSecond">5</span>s</h3>
                    <form method="get" action="{{ $successUrl }}" id="formSuccess">
                        <input type="hidden" name="success" value="true">
                        <button type="submit" class="btn">{{ __('payment.back_button') }}</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var second = 5;

            var timer = setInterval(function () {
                second = second - 1;
                $('#textSecond').html(second);
                if (second == 0) {
                    clearInterval(timer);
                    $('#formSuccess').submit();
                }
            }, 1000);
        });
    </script>
@endsection