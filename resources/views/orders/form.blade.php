<input type="hidden" value="1" id="numOfProducts" name="numOfProducts">
<div class="form-group row {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Status', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-5 col-sm-5">
        {!! Form::select('status', \App\Services\CommonService::mapStatus(\App\Models\Order::STATUS, \App\Models\Order::STATUS_TEXT, [\App\Models\Order::STATUS['ORDERED'],\App\Models\Order::STATUS['PAID'],\App\Models\Order::STATUS['INTERNAL']]), null, ['class' => 'form-control', 'required' => 'required', 'id' =>'status']) !!}
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('selling_web') ? 'has-error' : ''}}" id="selling-web-group">
    {!! Form::label('selling_web', 'Selling Web', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-5 col-sm-5">
        {!! Form::select('selling_web', \App\Services\CommonService::mapStatus(\App\Models\Order::SELLING_WEB, \App\Models\Order::SELLING_WEB_TEXT), null, ['class' => 'form-control', 'required' => 'required', 'id'=>'selling-web']) !!}
        {!! $errors->first('selling_web', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group row {{ $errors->has('code') ? 'has-error' : ''}}col-md-4 col-sm-2">
        {!! Form::text('code', null, ['id' => 'order-code-group', 'placeholder' =>'order code', 'class' => 'form-control' ]) !!}
    </div>
</div>

<div style="margin-top: 20px; padding-bottom: 75px" class="order-details">
    <div class="text-center" style="margin-bottom: 20px; font-size: 17px"><b>Order Details</b></div>
    <div id="products">
        <div class="row">
            <div class="col-md-2">
                <select class="form-control" id="operation_1" name="operation_1">
                    <option value="1">OUT</option>
                    <option value="2">IN</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-control product-selector" id="product_id_1" name="product_id_1">
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control unit-price-selector" placeholder="unit price"
                       id="unit_1"
                       name="unit_1" required>
            </div>
            <div class="col-md-2">
                <input type="number" min="0" max="100" class="form-control quantity-selector" placeholder="quantity"
                       id="quantity_1"
                       name="quantity_1" required>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control total-price-selector" placeholder="total price" id="price_1"
                       name="price_1" required readonly>
            </div>
        </div>

    </div>
    <div class="row" style="margin-top: 15px">
        <div class="col-md-8"></div>
        <div class="col-md-2 text-center" style="margin-top: 10px">
            <span><b class="text-info" style="font-size: 20px">TOTAL PRICE</b></span>
        </div>
        <div class="col-md-2 text-center" style="margin-top: 10px">
            <span><b class="text-info" id="total-price" style="font-size: 20px"></b></span>
        </div>
    </div>
    <button type="button" id="btn_add" class="pull-right btn btn-info" style="margin-top: 20px">Add Product</button>
</div>
<div class="form-group row {{ $errors->has('name') ? 'has-error' : ''}} customer-input-group">
    {!! Form::label('name', 'Customer Full Name', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('provider') ? 'has-error' : ''}} provider-input-group">
    {!! Form::label('provider', 'Provider', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! Form::select('provider', \App\Models\User::getProviders(), null, ['class' => 'form-control', 'required' => 'required', 'id'=>'selling-web']) !!}
        {!! $errors->first('provider', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('phone') ? 'has-error' : ''}} customer-input-group">
    {!! Form::label('phone', 'Customer Phone Number', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! Form::text('phone', null, ['class' => 'form-control']) !!}
        {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('email') ? 'has-error' : ''}} customer-input-group">
    {!! Form::label('email', 'Customer Email', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('address') ? 'has-error' : ''}} customer-input-group">
    {!! Form::label('address', 'Shopping Address', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! Form::text('address', null, ['class' => 'form-control']) !!}
        {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('note') ? 'has-error' : ''}}">
    {!! Form::label('note', 'Note', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
        {!! Form::textarea('note', null, ['class' => 'form-control summernote']) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-12 text-right">
        <a href="{{url('/orders')}}" class="btn btn-secondary">Cancel</a>
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-success']) !!}
    </div>
</div>

@section('extra_scripts')
    <script type="text/javascript">
        var products = {!! $products !!};
        var firstId = products[Object.keys(products)[0]];
        var count = 2;
        $(document).ready(function () {

            //add product for product 1
            addElementsForProduct(1);

            //unit price for product 1
            setUnitPrice($('#unit_1').parent().parent(), firstId);

            //set status, selling wb, operation
            setStatus();
            setSellingWeb();
            setOperation();

            //change status event
            $("#status").change(function () {
                setStatus();
                setOperation();
            });

            //change selling web event
            $("#selling-web").change(function () {
                setSellingWeb();
            });


            //add product
            $('#btn_add').click(function () {
                $('#products').append('<div class="row" style="margin-top: 15px"><div class="col-md-2"><select class="form-control" id="operation_' + count + '" name="operation_' + count + '"><option value="1">OUT</option> <option value="2">IN</option></select></div><div class="col-md-4"><select class="form-control product-selector" id="product_id_' + count + '" name="product_id_' + count + '"></select></div><div class="col-md-2"><input type="text" class="form-control unit-price-selector" placeholder="unit price" id="unit_' + count + '" name="unit_' + count + '" required></div><div class="col-md-2"><input type="number" min = "0" max = "100" class="form-control quantity-selector" placeholder="quantity" id="quantity_' + count + '" name="quantity_' + count + '" required></div><div class="col-md-2"><input type="text" class="form-control total-price-selector" placeholder="total price" id="price_' + count + '" name="price_' + count + '" required readonly></div></div>');
                addElementsForProduct(count);
                setUnitPrice($('#unit_' + count).parent().parent(), firstId)
                $('#numOfProducts').val(count);
                if ($("#status").val() != '{{\App\Models\Order::STATUS['INTERNAL']}}') {
                    $('#operation_' + count).hide();
                } else {
                    $('#operation_' + count).val(2)
                }
                count++;
            });

            //change product
            $('.order-details').on('change', '.product-selector', function () {
                var parent = $(this).parent().parent();
                var id = $(this).val();
                setUnitPrice(parent, id);
            })

            //change unit price or quantity
            $('.order-details').on('keyup', 'input.quantity-selector, input.unit-price-selector', function () {
                var parent = $(this).parent().parent();
                //format unit price
                var unitPrice = parent.find('input.unit-price-selector');
                unitPrice.val($.number(unitPrice.val()))
                setTotalPrice(parent);
                var totalPrice = 0;
                $('input.total-price-selector').each(function (index) {
                    totalPrice += parseInt($(this).val().replace(/,/g, ''));
                })
                if (totalPrice || totalPrice == 0) {
                    $('#total-price').html($.number(totalPrice));
                } else {
                    $('#total-price').html('');
                }
            })

        });

        //end document ready

        //start function

        //set unit price
        function setUnitPrice(selector, id) {
            selector.find('input.quantity-selector').val('');
            selector.find('input.total-price-selector').val('');
            $('#total-price').html('');
            selector.find('input.quantity-selector').attr('disabled', true);
            var url = window.location.origin + '/products/' + id + '/unit-price';
            $.get(url, function (data, status) {
                var unitPrice = data.data.price;
                selector.find('input.unit-price-selector').val($.number(unitPrice));
                //enable quantity when unit price is loaded
                selector.find('input.quantity-selector').attr('disabled', false);
            });
        }

        //set status
        function setStatus() {
            if ($("#status").val() == '{{\App\Models\Order::STATUS['INTERNAL']}}') {
                $('#selling-web-group').hide();
                $('.customer-input-group').hide();
                $('.provider-input-group').show();
            } else {
                $('#selling-web-group').show();
                $('.customer-input-group').show();
                $('.provider-input-group').hide();
            }
        }

        //set selling web
        function setSellingWeb() {

            if ($("#selling-web").val() == 1) {

                $('#order-code-group').hide();
            } else {

                $('#order-code-group').show();
            }
        }

        //set operation
        function setOperation() {
            if ($("#status").val() == '{{\App\Models\Order::STATUS['INTERNAL']}}') {
                for (var i = 1; i < count; i++) {
                    $('#operation_' + i).show();
                    $('#operation_' + i).val(2);
                }
            } else {
                for (var i = 1; i < count; i++) {
                    $('#operation_' + i).hide();
                }
            }
        }

        //add products for drop-down
        function addElementsForProduct(id) {
            for (var key in products) {
                $('#product_id_' + id).append('<option value="' + products[key] + '">' + key + '</option>');
            }
        }

        //set total price
        function setTotalPrice(parentSelector) {
            var totalPriceSelector = parentSelector.find('input.total-price-selector');
            var unitPrice = parseInt(parentSelector.find('input.unit-price-selector').val().replace(/,/g, ''));
            var quantity = parentSelector.find('input.quantity-selector').val();
            if ((unitPrice || unitPrice == 0) && quantity) {
                totalPriceSelector.val($.number(unitPrice * quantity));
            }
            else {
                totalPriceSelector.val('');
            }
        }
    </script>
@endsection
