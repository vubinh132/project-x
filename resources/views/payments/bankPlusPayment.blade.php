@extends('layouts.payment')

@section('content')
    <div class="row">
        <div class="col-sm-12 text-center">Loading...</div>
        <div class="col-sm-12">
            <form action="{{ $payUrl }}" method="post" id="formBankPlus"></form>
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#formBankPlus').submit();
        });
    </script>
@endsection
