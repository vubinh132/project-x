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
                <div class="dataTables_filter">

                    <div class="input-group">
                        <label style="margin-right: 20px;">
                            <input type="checkbox" name="in" value="1" id="in" checked>
                            In Business
                        </label>
                        <label style="margin-right: 20px;">
                            <input type="checkbox" name="research" value="1" id="research">
                            Research
                        </label>
                        <label style="margin-right: 20px;">
                            <input type="checkbox" name="out" value="1" id="out">
                            Out Of Business
                        </label>

                        <input type="text" class="form-control search-text" id="keyWord" placeholder="Search by SKU...">
                        <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="button" id="btnSearch">
                                        Search <i class="fa fa-search"></i>
                                    </button>
                                </span>
                    </div>

                </div>

                <table class="table table-hover" id="table">
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
                    <tr ng-repeat="x in filteredProducts|orderBy:'sku'">
                        <td ng-bind="$index + 1"></td>
                        <td ng-bind="x.sku"></td>
                        <td ng-bind="x.statusText"></td>
                        <td ng-bind-html="trustAsHtml(x.quantity)"></td>
                        <td ng-bind-html="trustAsHtml(x.avgValue)"></td>
                        <td><span  ng-bind-html="trustAsHtml(x.avgProfit)" data-toggle='tooltip' ng-attr-title="{%x.getAVGProfitDetails%}" data-html="true" data-animation="false" bs-tooltip></span></td>
                        <td>-</td>
                        <td class="text-center text-nowrap">
                            <a ng-href="{%x.editLink%}"
                               data-toggle="tooltip" title="Update" data-animation="false" bs-tooltip>
                                <i class="fa fa-pencil-square-o text-inverse m-l-5 m-r-5"></i>
                            </a>

                            <form method="POST" action="{%x.deleteLink%}"
                                  style="display:inline ">
                                <input type="hidden" class="csrf" name="_token">
                                <a href="javascript:void(0);" data-toggle="tooltip" title="Delete"
                                   data-animation="false"
                                   onclick="confirmSubmit(event, this, 'Delete this product?', 'Do you want to delete?')" bs-tooltip>
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
