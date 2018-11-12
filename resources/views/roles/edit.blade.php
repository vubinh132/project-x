@extends('layouts.index.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12">
            <h4 class="page-title">Chỉnh sửa quyền</h4>
        </div>
        <div class="col-lg-8 col-sm-7 col-md-7 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/admin') }}">Admin</a></li>
                <li><a href="{{ url('/admin/roles') }}">Phân Quyền</a></li>
                <li class="active">Chỉnh Sửa</li>
            </ol>
        </div>
    </div>

    {!! Form::model($role, ['method' => 'PATCH', 'url' => ['/admin/roles', $role->id], 'class' => 'form-horizontal', 'files' => true]) !!}
    @include ('admin.roles.form', ['submitButtonText' => 'Cập Nhật'])
    {!! Form::close() !!}

@endsection
