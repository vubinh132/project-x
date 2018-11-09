@extends('layouts.admin.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">VOLUME ADJUSTMENT</h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li>Admin</li>
                <li class="active">VOLUME ADJUSTMENT</li>
            </ol>
        </div>
    </div>
    <div class="white-box">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">SKU</th>
                <th scope="col">Product Name</th>
                <th scope="col">Volume</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->products as $product)
                <tr>
                    <th scope="row">{{$product->id}}</th>
                    <td>{{$product->sku}}</td>
                    <td>{{$product->name}}</td>
                    <td style="padding:7px 0px 0px 0px">
                        <button type="button" class="btn btn-success increase volume-adjustment"
                                style="border-radius: 20px">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <div id='{{$product->id}}' style="display: inline-block; width: 30px"
                             class="text-center">{{abs($product->pivot->quantity)}}</div>
                        <button type="button" class="btn btn-success decrease volume-adjustment"
                                style="border-radius: 20px">
                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('extra_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('button.volume-adjustment').click(function () {
                var isIncreasing = $(this).hasClass('increase');
                var id = $(this).parent().find('div').attr('id');
                console.log(id);
                console.log(isIncreasing);

                $.post("{{url('admin/volume-adjustment?XDEBUG_SESSION_START=11253')}}",
                    {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        isIncreasing: isIncreasing
                    },
                    function (data, status) {
                        if (data.success) {
                            $('div#' + id).text(data.quantity);
                            console.log('update successfully!');
                        }
                    });
            });
        });
    </script>
@endsection
