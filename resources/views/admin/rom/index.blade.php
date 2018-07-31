@extends('layouts.admin.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">RETURNED ORDERS MANAGEMENT</h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li>Admin</li>
                <li class="active">ROM</li>
            </ol>
        </div>
    </div>
    <div class="white-box" ng-app="myApp" ng-controller="romIndexCtrl">

        <div class="table-responsive">
            <div class="dataTables_wrapper no-footer">
                <div class="dataTables_length" style="margin-bottom: 10px !important;">
                    <label>
                        <a href="{{ url('/admin/rom/commit') }}" class="btn btn-success pull-left">
                            <i class="fa fa-check"></i> Commit
                        </a>
                    </label>
                    <div>
                        <b>{{$notification}}</b>
                    </div>
                </div>

                <div class="dataTables_filter">

                    <div class="input-group">
                        <label style="margin-right: 20px;">
                            <input type="checkbox" name="not-received" value="1" id="not-received" checked>
                            Not Received Yet
                        </label>
                        <label style="margin-right: 20px;">
                            <input type="checkbox" name="received" value="1" id="received">
                            Received
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
                        <th class="text-center" style="width: 100px;">Returned</th>
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
                            <input type="checkbox" ng-model="x.returned"
                                   ng-change="changeReturnStatus(x.id, x.returned)">
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