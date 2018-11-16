@extends('layouts.app')

@section('content')
    <div class="row bg-title">
        <div class="col-md-4 col-xs-12">
            <h4 class="page-title">UPDATE PRODUCT</h4>
        </div>
        <div class="col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/products') }}">Products</a></li>
                <li class="active">Update Product</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2 text-center">
            <img src="{{ $product->imageUrl() }}" style="max-width: 150px;">
            {!! Form::model($product, ['method' => 'POST', 'url' => url('products/'.$product->id.'/change-image'), 'files' => true]) !!}
            {{Form::file('product_image', ['id' => 'product_image', 'onchange' => 'uploadFileWithLimit(this, 2);', 'style' => 'display: none', 'accept' => config('constants.ACCEPT_IMAGE_TYPES')])}}
            {{Form::button('Chang Image', ['onclick' => "document.getElementById('product_image').click();", 'class' => 'btn btn-info m-t-20'])}}
            {!! Form::close() !!}
        </div>
        <div class="col-sm-10">
            <div class="white-box">
                {!! Form::model($product, ['method' => 'PATCH', 'url' => ['/products', $product->id], 'class' => 'form-horizontal', 'files' => true]) !!}
                @include ('products.update_form', ['submitButtonText' => 'Update'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
