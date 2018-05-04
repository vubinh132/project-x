@extends('layouts.admin.app')

@section('content')
    <div class="row bg-title">
        <div class="col-md-4 col-xs-12">
            <h4 class="page-title">UPDATE ORDER</h4>
        </div>
        <div class="col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/admin') }}">Admin</a></li>
                <li><a href="{{ url('/admin/orders') }}">Orders</a></li>
                <li class="active">Update Order</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                {!! Form::model($order, ['method' => 'PATCH', 'url' => ['/admin/orders', $order->id], 'class' => 'form-horizontal', 'files' => true]) !!}
                @include ('admin.orders.update_form', ['submitButtonText' => 'Update'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
