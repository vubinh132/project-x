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

        <div style="margin-bottom: 20px">
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
