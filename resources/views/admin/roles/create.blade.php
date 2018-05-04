@extends('layouts.index.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-xs-12">
            <h4 class="page-title">Thêm Quyền</h4>
        </div>
        <div class="col-lg-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/admin') }}">Admin</a></li>
                <li><a href="{{ url('/admin/roles') }}">Phân Quyền</a></li>
                <li class="active">Thêm Quyền</li>
            </ol>
        </div>
    </div>

    {!! Form::open(['url' => '/admin/roles', 'class' => 'form-horizontal', 'files' => true]) !!}
    @include ('admin.roles.form')
    {!! Form::close() !!}
@endsection
