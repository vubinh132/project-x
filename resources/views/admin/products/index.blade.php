@extends('layouts.admin.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">PRODUCTS [ {{$total}} ] </h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/admin') }}">Admin</a></li>
                <li class="active">Products</li>
            </ol>
        </div>
    </div>
    <div class="white-box">
        <div class="table-responsive">
            <div class="dataTables_wrapper no-footer">
                <div class="dataTables_length">
                    <label>
                        <a href="{{ url('/admin/products/create') }}" class="btn btn-success pull-left">
                            <i class="fa fa-plus"></i> Add Product
                        </a>
                    </label>
                </div>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>SKU</th>
                        <th>Status</th>
                        <th>Quantity</th>
                        <th>AVG Value</th>
                        <th>AVG Profit</th>
                        <th>Selling Speed</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->sku }}</td>
                            <td>{{ $item->statusText() }}</td>
                            {!! \App\Services\HTMLService::getProductQuantity($item) !!}
                            {!! \App\Services\HTMLService::getAVGPrice($item) !!}
                            <td>-</td>
                            <td>-</td>
                            <td class="text-center text-nowrap">
                                <a href="{{ url('/admin/products/' . $item->id . '/edit') }}"
                                   data-toggle="tooltip" title="Update" data-animation="false">
                                    <i class="fa fa-pencil-square-o text-inverse m-l-5 m-r-5"></i>
                                </a>

                                {!! Form::open([
                                    'method'=>'DELETE',
                                    'url' => ['/admin/products', $item->id],
                                    'style' => 'display:inline'
                                ]) !!}
                                <a href="javascript:void(0);" data-toggle="tooltip" title="Delete"
                                   data-animation="false"
                                   onclick="confirmSubmit(event, this, 'Delete this product?', 'Do you want to delete?')">
                                    <i class="fa fa-close text-inverse m-l-5 m-r-5"></i>
                                </a>
                                {!! Form::close() !!}

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
