@extends('layouts.admin.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">PRODUCT CHECKING</h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/admin') }}">Admin</a></li>
                <li class="active">Product Checking</li>
            </ol>
        </div>
    </div>
    <div class="white-box" ng-app="myApp" ng-controller="productIndexCtrl">

        <div style="padding-bottom: 20px">
            <b>remaining quantity < 0: {{$remainUnder0}}</b>
        </div>
        <div class="table-responsive">
            <div class="dataTables_wrapper no-footer">
                <table class="table table-hover" id="table">
                    <thead style="background-color: #c9e5df">
                    <tr>
                        <th width="10%">SKU</th>
                        <th width="10%">Repository</th>
                        <th width="10%">Ms. La</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{!! $product->sku !!}</td>
                            <td>{!! $product->available !!}</td>
                            <td>{{$product->l}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="table-responsive">
            <div class="dataTables_wrapper no-footer">
                <table class="table table-hover" id="table">
                    <thead style="background-color: #c9e5df">
                    <tr>
                        <th width="10%">SKU</th>
                        <th width="10%">Repository</th>
                        <th width="10%">Ms. La</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($LProducts as $key => $value)
                        <tr>
                            <td>{{$key}}</td>
                            <td></td>
                            <td>{{$value}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
