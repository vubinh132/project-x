@extends('layouts.admin.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">LOGS</h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/admin') }}">Admin</a></li>
                <li class="active">Logs</li>
            </ol>
        </div>
    </div>
    <div class="white-box">
        <div class="table-responsive">
            <div class="dataTables_wrapper no-footer">
                {{--<div class="dataTables_length">--}}
                {{--<label>--}}
                {{--<a href="{{ url('/admin/orders/create') }}" class="btn btn-success pull-left">--}}
                {{--<i class="fa fa-plus"></i> Add Order--}}
                {{--</a>--}}
                {{--</label>--}}
                {{--</div>--}}

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Datetime</th>
                        <th>Category</th>
                        <th class="text-center">Content</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($logs as $item)
                        <tr>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->categoryText() }}</td>
                            <td class="">{{ $item->content }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
