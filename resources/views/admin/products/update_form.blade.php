<div class="form-group row {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Status', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-5 col-sm-5">
        {!! Form::select('status', \App\Services\CommonService::mapStatus(\App\Models\Product::STATUS, \App\Models\Product::STATUS_TEXT,[2,3]), null, ['class' => 'form-control simple-dropdown', 'required' => 'required']) !!}
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group row {{ $errors->has('sku') ? 'has-error' : ''}}">
    {!! Form::label('sku', 'SKU', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! Form::text('sku', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('sku', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('price') ? 'has-error' : ''}}">
    {!! Form::label('price', 'Price', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! Form::text('price', null, ['class' => 'form-control', 'required' => 'required','min' => 0]) !!}
        {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('old_price') ? 'has-error' : ''}}">
    {!! Form::label('old_price', 'Old Price', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! Form::text('old_price', null, ['class' => 'form-control', 'min' => 0]) !!}
        {!! $errors->first('old_price', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Description', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! Form::text('description', null, ['class' => 'form-control']) !!}
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group row {{ $errors->has('content') ? 'has-error' : ''}}">
    {!! Form::label('content', 'Content', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
        {!! Form::textarea('content', null, ['class' => 'form-control summernote']) !!}
    </div>
</div>

<div class="form-group row">
    <div class="col-sm-12 text-right">
        <a href="{{ url("admin/products")  }}" class="btn btn-secondary">Cancel</a>
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-success']) !!}
    </div>
</div>
