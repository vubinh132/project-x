<input type="hidden" value="1" id="numOfProducts" name = "numOfProducts">
<div class="form-group row {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Status', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-5 col-sm-5">
        {!! Form::select('status', \App\Services\CommonService::mapStatus(\App\Models\Order::STATUS, \App\Models\Order::STATUS_TEXT, [1,2,3]), null, ['class' => 'form-control', 'required' => 'required', 'id' =>'status']) !!}
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

<div style="margin-top: 20px; padding-bottom: 75px">
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
                <select class="form-control" id="product_id_1" name="product_id_1">
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" max="100" class="form-control" placeholder="quantity" id="quantity_1"
                       name="quantity_1" required>
            </div>
            <div class="col-md-4">
                <input type="number" min="1000" class="form-control" placeholder="total price" id="price_1"
                       name="price_1" required>
            </div>
        </div>
    </div>
    <button type="button" id="btn_add" class="pull-right btn btn-info" style="margin-top: 20px">Add Product</button>
</div>
<div class="form-group row {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Customer Full Name', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('phone') ? 'has-error' : ''}}">
    {!! Form::label('phone', 'Customer Phone Number', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! Form::text('phone', null, ['class' => 'form-control']) !!}
        {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', 'Customer Email', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('address') ? 'has-error' : ''}}">
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
        <a href="{{url('admin/orders')}}" class="btn btn-secondary">Cancel</a>
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-success']) !!}
    </div>
</div>

@section('extra_scripts')
    <script type="text/javascript">
        var products = {!! $products !!};
        var count = 2;
        $(document).ready(function () {

            addElementsForProduct(1);

            setStatus();
            setSellingWeb();
            setOperation();

            $("#status").change(function () {
                setStatus();
                setOperation();
            });
            $("#selling-web").change(function () {
                setSellingWeb();
            });

            $('#btn_add').click(function () {
                $('#products').append('<div class="row" style="margin-top: 15px"><div class="col-md-2"><select class="form-control" id="operation_' + count + '" name="operation_' + count + '"><option value="1">OUT</option> <option value="2">IN</option></select></div><div class="col-md-4"><select class="form-control" id="product_id_' + count + '" name="product_id_' + count + '"></select></div><div class="col-md-2"><input type="number" max = "100" class="form-control" placeholder="quantity" id="quantity_' + count + '" name="quantity_' + count + '" required></div><div class="col-md-4"><input type="number" min="1000" class="form-control" placeholder="total price" id="price_' + count + '" name="price_' + count + '" required></div></div>');
                addElementsForProduct(count);
                $('#numOfProducts').val(count);
                if ($("#status").val() != 3) {
                    $('#operation_' + count).hide();
                }else{
                    $('#operation_' + count).val(2)
                }
                count++;
            });
        });

        function setStatus() {
            if ($("#status").val() == 3) {
                $('#selling-web-group').hide();
            } else {
                $('#selling-web-group').show();
            }
        }

        function setSellingWeb() {

            if ($("#selling-web").val() == 1) {

                $('#order-code-group').hide();
            } else {

                $('#order-code-group').show();
            }
        }

        function setOperation() {
            if ($("#status").val() == 3) {
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

        function addElementsForProduct(id) {
            console.log(products);
            for (var key in products) {
                $('#product_id_' + id).append('<option value="' + products[key] + '">' + key + '</option>');
            }
        }
    </script>
@endsection
