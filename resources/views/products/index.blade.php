@extends('layouts.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">PRODUCTS [ {{$total}} ] </h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Products</li>
            </ol>
        </div>
    </div>
    <div class="white-box" ng-app="myApp" ng-controller="productIndexCtrl">
        <div class="table-responsive">
            <div class="dataTables_wrapper no-footer">
                <div class="dataTables_length">
                    <label>
                        <a href="{{ url('/products/create') }}" class="btn btn-success pull-left">
                            <i class="fa fa-plus"></i> Add Product
                        </a>
                    </label>
                </div>
                <div class="dataTables_filter">

                    <div class="input-group">
                        <label style="margin-right: 20px;">
                            <input type="checkbox" name="in" value="1" id="in" checked>
                            In Business ({{$in}})
                        </label>
                        <label style="margin-right: 20px;">
                            <input type="checkbox" name="research" value="1" id="research">
                            Research ({{$research}})
                        </label>
                        <label style="margin-right: 20px;">
                            <input type="checkbox" name="out" value="1" id="out">
                            Out Of Business ({{$out}})
                        </label>

                        <span class="input-group-btn btn btn-secondary" ng-bind="filteredProducts.length"
                              style="width: 50px">
                        </span>
                        <input type="text" class="form-control search-text" id="keyWord"
                               placeholder="Search by order code..." style="margin-left: 0 !important;">
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
                        <td><span ng-bind-html="trustAsHtml(x.avgProfit)" data-toggle='tooltip'
                                  ng-attr-title="{%x.avgProfitDetails%}" data-html="true" data-animation="false"
                                  bs-tooltip></span></td>
                        <td><span ng-bind="x.sellingSpeed" data-toggle='tooltip'
                                  ng-attr-title="{%x.sellingSpeedDetails%}" data-html="true" data-animation="false"
                                  bs-tooltip></span></td>
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
                                   onclick="confirmSubmit(event, this, 'Delete this product?', 'Do you want to delete?')"
                                   bs-tooltip>
                                    <i class="fa fa-close text-inverse m-l-5 m-r-5"></i>
                                </a>
                            </form>
                            <span class="quantity-checking" id="{%'check-' + x.id%}" data-toggle="tooltip" title="Check"
                                  data-animation="false"
                                  bs-tooltip>
                                <i class="fa fa-check-circle text-inverse m-l-5 m-r-5"></i>
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('extra_scripts')
    <script type="text/javascript">

        var products = {!! $products !!};

        app.controller("productIndexCtrl", function ($scope, $sce) {

            $scope.products = products;

            filter();

            $('#in, #out, #research').change(function () {
                filter();
                $scope.$apply();
            });
            $(function () {
                $('#keyWord').keyup(function () {
                    filter();
                    $scope.$apply();
                });
            });

            function filter() {
                $scope.filteredProducts = [];

                var keyWord = $('#keyWord').val().toLowerCase();

                //validate

                if (!keyWord.match(/^[a-zA-Z0-9_.-]*$/)) {
                    keyWord = keyWord.substring(0, keyWord.length - 1);
                    $('#keyWord').val(keyWord);
                }

                var filterArray = [];

                if ($('#in').is(':checked')) {
                    filterArray.push(2);
                }
                if ($('#out').is(':checked')) {
                    filterArray.push(3);
                }
                if ($('#research').is(':checked')) {
                    filterArray.push(1);
                }

                for (var i = 0; i < $scope.products.length; i++) {
                    if (filterArray.indexOf($scope.products[i].status) != -1 && (!keyWord || $scope.products[i].sku.toLowerCase().match(keyWord))) {
                        $scope.filteredProducts.push($scope.products[i]);
                    }
                }

            }

            $scope.trustAsHtml = function (html) {
                return $sce.trustAsHtml(html);
            }

        });

        $(document).ready(function () {
            $('.csrf').val('{{ csrf_token() }}');
            $('.quantity-checking').click(function () {
                let id = $(this).attr('id').substr(6);
                $.post("{{url('/quantity-checking')}}" + '/' + id,
                    {
                        _token: "{{ csrf_token() }}"
                    },
                    (data) => {
                        if (data.success) {
                            $.alert({
                                backgroundDismiss: true,
                                title: 'Success',
                                content: 'Check quantity successfully',
                            });
                        } else {
                            $.alert({
                                backgroundDismiss: true,
                                title: 'Fail',
                                content: data.massage,
                            });
                        }

                    });
            });
        });

    </script>
@endsection
