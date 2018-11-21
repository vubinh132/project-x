@extends('layouts.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-xs-12">
            <h4 class="page-title">ADD ORDER</h4>
        </div>
        <div class="col-lg-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/orders') }}">Orders</a></li>
                <li class="active">Add Order</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                {!! Form::open(['url' => '/orders', 'class' => 'form-horizontal', 'files' => true]) !!}

                @include ('orders.form')

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
