@extends('layouts.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">PRODUCT CHECKING</h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Product Checking</li>
            </ol>
        </div>
    </div>
    <div class="white-box">

        <div class="row" style="margin-bottom: 20px">
            <div class="col-lg-4 d-flex flex-column justify-content-center">
                <div><b>
                        <div style="width: 270px; display: inline-block;">Remaining Quantity Less Than 0 :</div>
                        <i class='fa fa-warning text-danger'></i> {{$remainLessThan0}}</b></div>
                <div><b>
                        <div style="width: 270px; display: inline-block;">Remaining Quantity Equal 0 :</div>
                        <i class='fa fa-check-circle text-success'></i> {{$remainEqual0}}</b></div>
                <div><b>
                        <div style="width: 270px; display: inline-block;">Remaining Quantity Greater Than 0 :</div>
                        <i class='fa fa-info-circle text-info'></i> {{$remainGreaterThan0}}</b></div>
            </div>
            <div class="col-lg-4 d-flex flex-row justify-content-center">
                <div style="width: 250px; height: 250px">
                    <canvas id="lazadaChart" width="50" height="50"></canvas>
                </div>
            </div>
            <div class="col-lg-4 d-flex flex-row justify-content-center">
                <div style="width: 250px; height: 250px">
                    <canvas id="shopeeChart" width="50" height="50"></canvas>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <div class="dataTables_wrapper no-footer">
                <table class="table table-hover" id="table">
                    <thead style="background-color: #c9e5df">
                    <tr>
                        <th width="20%">SKU</th>
                        <th width="60%">Quantity Data</th>
                        <th width="20%">Lazada</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{!! $product->SKU !!}</td>
                            <td>{!! $product->quantityData !!}</td>
                            <td>
                                <span data-toggle="tooltip" title="{!! $product->lazadaDetail !!}"
                                      data-animation="false" bs-tooltip data-html="true">
                                    {!! $product->lazada !!}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('extra_scripts')
    <script src="{{ asset('theme/admin/js/Chart.min.js') }}"></script>
    <script>
        let lazadaData = {
            datasets: [{
                data: [{{$chartData['lazada'][2]}}, {{$chartData['lazada'][1]}}, {{$chartData['lazada'][0]}}],
                backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe',]
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: ['Lazada sold-out', 'Common', 'System']
        };
        let shopeeData = {
            datasets: [{
                data: [10, 20, 30],
                backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe',]
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: ['Shopee sold-out', 'Common', 'System']
        };
        let ctxLazada = $("#lazadaChart");
        let ctxShopee = $("#shopeeChart");
        var lazadaChart = new Chart(ctxLazada, {
            type: 'doughnut',
            data: lazadaData,
            options: {legend: {reverse: true}}
        });
        var shopeeChart = new Chart(ctxShopee, {
            type: 'doughnut',
            data: shopeeData,
            options: {legend: {reverse: true}}
        });
    </script>
@endsection
