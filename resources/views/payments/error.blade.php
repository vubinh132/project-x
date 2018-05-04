@extends('layouts.payment')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box text-center" style="margin:100px 0 200px;">
                <h3>{{ __('payment.error.title') }}</h3>
                @if(isset($message))
                    <h4>{{ $message }}</h4>
                @endif
                @if(isset($errorUrl))
                    <h3>{{ __('payment.error.back_message') }} <span id="textSecond">5</span>s...</h3>
                    <form method="get" action="{{ $errorUrl }}" id="formError">
                        <input type="hidden" name="success" value="false">
                        <input type="hidden" name="message" value="{{ $message }}">
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
                if (second == 1) {
                    clearInterval(timer);
                    $('#formError').submit();
                }
            }, 1000);
        });
    </script>
@endsection
