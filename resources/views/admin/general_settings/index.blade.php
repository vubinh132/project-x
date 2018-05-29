@extends('layouts.admin.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">GENERAL SETTINGS</h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li>Admin</li>
                <li class="active">General Settings</li>
            </ol>
        </div>
    </div>
    <div class="white-box">
        <form action="{{url('admin/general-settings')}}" method="PUT">
            <div class="form-group row ">
                {!! Form::label('name', 'Start Date', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
                <div class="col-md-9 col-sm-7">
                    {!! Form::text('name', $startDate, ['class' => 'form-control text-center', 'required' => 'required', 'disabled'=>'disabled']) !!}
                </div>
            </div>
            <div class="form-group row ">
                {!! Form::label('name', 'Version', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
                <div class="col-md-9 col-sm-7">
                    {!! Form::text('name', "Current Version: $version[0] | Last Update: $version[2]", ['class' => 'form-control text-center', 'required' => 'required', 'disabled'=>'disabled']) !!}
                </div>
            </div>
            <div class="form-group row ">
                {!! Form::label('email', 'Send Mail Testing', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
                <div class="col-md-3 col-sm-3">
                    {!! Form::text('mailServer', $mailServer, ['class' => 'form-control', 'required' => 'required', 'disabled' => 'disabled']) !!}
                </div>
                <div class="col-md-4 col-sm-2">
                    {!! Form::email('email', "", ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Email address for testing...', 'id' => 'email']) !!}
                </div>
                <div class="col-md-2 col-sm-2">
                    <button type="button" class="form-control" id="send"><span id="ui-button-text">SEND</span></button>
                </div>
            </div>
        </form>

    </div>
@section('extra_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#send").click(function () {
                $("#ui-button-text").text('SENDING...');
                $("#send").attr('disabled', true);
                $.ajax({
                    url: "{{url('/admin/general-settings/send-email?email=')}}" + $("#email").val(),
                    type: 'GET',
                    success: function (res) {

                        if (res.success) {
                            $.alert({
                                backgroundDismiss: true,
                                title: 'Success',
                                content: 'An email sent successfully',
                            });
                        } else {
                            $.alert({
                                backgroundDismiss: true,
                                title: 'Fail',
                                content: res.massage,
                            });
                        }
                        $("#ui-button-text").text('SEND');
                        $("#send").attr('disabled', false);
                    }
                })
            });
        });
    </script>
@endsection
@endsection