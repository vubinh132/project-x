@extends('layouts.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">ORDERS [ {{$total}} ] </h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Orders</li>
            </ol>
        </div>
    </div>
    <div class="white-box" ng-app="myApp" ng-controller="orderIndexCtrl">
        <div class="table-responsive">
            <div class="dataTables_wrapper no-footer">
                <div class="dataTables_length">
                    <label>
                        <a href="{{ url('/admin/orders/create') }}" class="btn btn-success pull-left">
                            <i class="fa fa-plus"></i> Add Order
                        </a>
                    </label>
                </div>

                <div class="dataTables_filter">

                    <div class="input-group">
                        <label style="margin-right: 20px;">
                            <input type="checkbox" name="processing" value="1" id="processing" checked>
                            Processing ({{$processing}})
                        </label>
                        <label style="margin-right: 20px;">
                            <input type="checkbox" name="done" value="1" id="done">
                            Done ({{$done}})
                        </label>
                        <label style="margin-right: 20px;">
                            <input type="checkbox" name="canceled" value="1" id="canceled">
                            Canceled & Returned ({{$canceled}})
                        </label>
                        <span class="input-group-btn btn btn-secondary" ng-bind="filteredOrders.length"
                              style="width: 50px">
                        </span>
                        <input type="text" class="form-control search-text" id="keyWord"
                               placeholder="Search by order code..." style="margin-left: 0 !important;">

                    </div>

                </div>


                <table class="table table-hover" id="table">
                    <thead>
                    <tr>
                        <th><span style="margin-left: 50px">Code</span></th>
                        <th>Status</th>
                        <th>Total Price</th>
                        <th>Name</th>
                        <th>Selling Web</th>
                        <th>Created Date</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr ng-repeat="x in filteredOrders|orderBy:'created_at' : true">
                        <td ng-bind="x.code"></td>
                        <td ng-bind="x.statusText"></td>
                        <td><span ng-bind-html="trustAsHtml(x.totalPrice)" data-toggle='tooltip'
                                  ng-attr-title="{%x.orderDetail%}" data-html="true" data-animation="false"
                                  bs-tooltip></span></td>
                        <td ng-bind="x.name"></td>
                        <td ng-bind="x.sellingWeb"></td>
                        <td ng-bind="x.created_at"></td>
                        <td class="text-center text-nowrap">
                            <a ng-href="{%x.editLink%}"
                               data-toggle="tooltip" title="Update" data-animation="false" bs-tooltip>
                                <i class="fa fa-pencil-square-o text-inverse m-l-5 m-r-5"></i>
                            </a>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


@section('extra_scripts')
    <script type="text/javascript">

        var orders = {!! $orders !!};

    </script>
@endsection
@endsection
