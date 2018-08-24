@extends('layouts.admin.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">PRODUCT CHECKING</h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/admin') }}">Admin</a></li>
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
                        <th width="10%">SKU</th>
                        <th width="10%">Repository</th>
                        <th width="10%">Ms. La</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{!! $product->SKU !!}</td>
                            <td>{!! $product->available !!}</td>
                            <td>
                                <div style="width:50px; display: inline-block;">
                                    {{$product->l}}
                                </div>
                                <div style="display: inline-block;">
                                    @if(is_numeric($product->l))
                                        <button class="btn btn-success btn-sm btn-quantity-update"
                                                style="padding: 3px 10px; font-size: 10px; border-radius: 5px"
                                                id="{{'btn_'.$product->sku}}">update
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="table-responsive">
            <div class="dataTables_wrapper no-footer">
                <table class="table table-hover" id="table">
                    <thead style="background-color: #c9e5df">
                    <tr>
                        <th width="10%">SKU</th>
                        <th width="10%">Repository</th>
                        <th width="10%">Ms. La</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($LProducts as $key => $value)
                        <tr>
                            <td>{{$key}}</td>
                            <td></td>
                            <td>{{$value}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Update Quantity Modal -->
    <div id="quantity-updating" class="modal" role="dialog">
        <div class="modal-dialog modal-md">

            <!-- Modal content-->
            <div class="modal-content" style="border-radius: 10px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title" style="display: inline-block"><b>Quantity Updating</b></h5>  <span id="sku" class="pull-right" style="padding-right: 10px"></span>
                </div>
                <div class="modal-body">
                    <div>
                        <span>Remaining quantity: </span> <span id='remaining-quantity'></span>
                    </div>
                    <div style="padding-top: 20px">
                        <div class="row">
                            <div class="col-xs-5"> Lazada</div>
                            <div class="col-xs-3">
                                <input style="text-align: right;" type="number" value="0" class="modal-lazada-quanity">
                            </div>
                            <div class="col-xs-4">
                                <input type="button" value="update" class="modal-update">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


@section('extra_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.btn-quantity-update').click(function () {

                //reset data to 0
                $(".modal-body input[type='number']").val("0")

                $('#quantity-updating').modal('show');
                var sku = $(this).attr('id').split("_")[1];
                var quantityId = 'remain_' + sku;
                var remainingQuantity = $('#' + quantityId).text();
                $('#remaining-quantity').text(remainingQuantity);
                $('#sku').text(sku);

                //set id for modal button and input
                $(".modal-body .modal-update").attr('id', 'modal-update_' + sku);
                $(".modal-body .modal-lazada-quanity").attr('id', 'modal-lazada-quanity_' + sku);
            })
            $('.modal-lazada-quanity').on('keyup scroll change', function() {
                var sku = $(this).attr('id').split("_")[1];
                var remain = $('#remain_' + sku).text();
                $('#remaining-quantity').text(parseInt(remain) - $(this).val());
            });
            $('.modal-update').click(function () {
                var sku = $(this).attr('id').split("_")[1];
                console.log(sku);
            })
        });
    </script>
@endsection
@endsection
