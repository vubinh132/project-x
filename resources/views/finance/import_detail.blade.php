@extends('layouts.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">IMPORT [ {{$total}} ]</h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li>Admin</li>
                <li class="active">IMPORT</li>
            </ol>
        </div>
    </div>
    <div class="white-box">
        <div style="font-size: 20px; padding-bottom: 20px">
            Total Price: {{\App\Services\CommonService::formatPrice($totalPrice)}}
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Code</th>
                <th scope="col">Name</th>
                <th scope="col">Total Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Note</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <th scope="row">{{$order->id}}</th>
                    <td>{{$order->name}}</td>
                    <td>{{ \App\Services\CommonService::formatPrice($order->total_price)}}</td>
                    <td>{{$order->quantity}}</td>
                    <td>{!! $order->note !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection

