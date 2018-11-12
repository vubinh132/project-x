@extends('layouts.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">LAZADA</h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">External APIs</li>
            </ol>
        </div>
    </div>
    <div class="white-box">
        <div class="form-group row ">
            {!! Form::label('auth', 'Auth', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
            <div class="col-md-3 col-sm-3">

            </div>
            <div class="col-md-4 col-sm-2">

            </div>
            <div class="col-md-2 col-sm-2">
                <button type="button" class="form-control" id="auth">
                    <span id="sync-text">AUTH</span>
                </button>
            </div>
        </div>


        <div class="form-group row ">
            {!! Form::label('sync', 'Sync Orders', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
            <div class="col-md-3 col-sm-3">

            </div>
            <div class="col-md-4 col-sm-2">

            </div>
            <div class="col-md-2 col-sm-2">
                <button type="button" class="form-control" id="sync">
                    <span id="sync-text">SYNC</span>
                </button>
            </div>
        </div>


    </div>
@section('extra_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#sync").click(function () {
                $("#sync-text").text('SYNCING..');
                $("#sync").attr('disabled', true);
                $.ajax({
                    url: "{{url('/admin/external-api/lazada/sync-orders')}}",
                    type: 'GET',
                    success: function (res) {
                        $.alert({
                            backgroundDismiss: true,
                            title: 'Success',
                            content: JSON.stringify(res),
                        });
                        $("#sync-text").text('SYNC');
                        $("#sync").attr('disabled', false);
                    }
                })
            });

            $("#auth").click(function () {
                window.location.href = '{!! config('lazada.AUTH_URL') !!}';
            })
        });
    </script>
@endsection
@endsection