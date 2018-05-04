<div class="form-group row {{ $errors->has('sku') ? 'has-error' : ''}}">
    {!! Form::label('sku', 'SKU', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! Form::text('sku', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('sku', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group row">
    <div class="col-sm-12 text-right">
        <a href="{{url('admin/products')}}" class="btn btn-secondary">Cancel</a>
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-success']) !!}
    </div>
</div>
