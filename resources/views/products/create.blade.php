@extends('layouts.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-xs-12">
            <h4 class="page-title">ADD PRODUCT</h4>
        </div>
        <div class="col-lg-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/products') }}">Products</a></li>
                <li class="active">Add Product</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                {!! Form::open(['url' => '/products', 'class' => 'form-horizontal', 'files' => true]) !!}

                @include ('products.form')

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
