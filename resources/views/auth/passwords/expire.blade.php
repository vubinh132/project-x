@extends('layouts.empty')

@section('content')
    <section id="wrapper" class="login-register">
        <div class="login-box">
            <div class="white-box">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="form-group ">
                    <div class="col-xs-12">
                        <h3>Khôi phục mật khẩu</h3>
                        <p class="text-muted">Đường dẫn đã hết hạn. Vui lòng gửi lại yêu cầu khôi phục mật khẩu</p>
                    </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <a href="{{ url('password/reset')}}"
                           class="btn btn-secondary btn-lg btn-block text-uppercase waves-effect waves-light">
                            GỬI LẠI YÊU CẦU
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
