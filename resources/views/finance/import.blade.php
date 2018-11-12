@extends('layouts.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">IMPORT</h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">IMPORT</li>
            </ol>
        </div>
    </div>
    <div class="white-box">
        {{--<div style="font-size: 20px; padding-bottom: 20px">--}}
        {{--Total Price: {{\App\Services\CommonService::formatPrice($totalPrice)}}--}}
        {{--</div>--}}
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Provider Name</th>
                <th scope="col">Num Of Orders</th>
                <th scope="col">Total Value</th>
                <th scope="col">Actions</th>

            </tr>
            </thead>
            <tbody>
            @foreach($providers as $provider)
                <tr>
                    <td>{{ \App\Models\Order::PROVIDER_TEXT[array_keys(\App\Models\Order::PROVIDER, 1)[0]] }}</td>
                    <td>{{$provider->num_of_orders}}</td>
                    <td>{{\App\Services\CommonService::formatPrice($provider->total_value)}}</td>
                    <td><a href="{{ url('/finance/import/' . $provider->provider) }}"
                           data-toggle="tooltip" title="See details" data-animation="false">
                            <i class="fa fa-eye text-inverse m-l-5 m-r-5"></i>
                        </a></td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection

