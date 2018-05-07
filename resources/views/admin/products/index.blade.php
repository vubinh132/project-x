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
    <div class="white-box" ng-app="myApp" ng-controller="productIndexCtrl">
        <div class="table-responsive">
            <div class="dataTables_wrapper no-footer">
                <div class="dataTables_length">
                    <label>
                        <a href="{{ url('/admin/products/create') }}" class="btn btn-success pull-left">
                            <i class="fa fa-plus"></i> Add Product
                        </a>
                    </label>
                </div>
                <div id="loader" style="height: 410px; text-align: center; margin-right: 100px">
                    <img src="{{asset('images/loader.gif')}}" style="margin-top: 100px">
                </div>

                <table class="table table-hover" id="table" style="display: none">
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
                    <tr ng-repeat="x in products" on-finish-render="ngRepeatFinished">
                        <td ng-bind="$index + 1"></td>
                        <td ng-bind="x.sku"></td>
                        <td ng-bind="x.status"></td>
                        <td ng-bind-html="trustAsHtml(x.quantity)"></td>
                        <td ng-bind-html="trustAsHtml(x.avgValue)"></td>
                        <td>-</td>
                        <td>-</td>
                        <td class="text-center text-nowrap">
                            <a ng-href="{%x.editLink%}"
                               data-toggle="tooltip" title="Update" data-animation="false">
                                <i class="fa fa-pencil-square-o text-inverse m-l-5 m-r-5"></i>
                            </a>

                            <form method="POST" action="{%x.deleteLink%}"
                                  style="display:inline ">
                                <input type="hidden" class="csrf" name="_token">
                                <a href="javascript:void(0);" data-toggle="tooltip" title="Delete"
                                   data-animation="false"
                                   onclick="confirmSubmit(event, this, 'Delete this product?', 'Do you want to delete?')">
                                    <i class="fa fa-close text-inverse m-l-5 m-r-5"></i>
                                </a>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@section('extra_scripts')
    <script type="text/javascript">
        var csrf = "{{ csrf_token() }}";
        var products = {!! $products !!};
        setCSRF();

        function setCSRF() {
            $('.csrf').val(csrf);
        }

    </script>
@endsection
@endsection
