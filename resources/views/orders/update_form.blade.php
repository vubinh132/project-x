<div class="form-group row {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Status', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-5 col-sm-5">
        {!! Form::select('status', $statusList, null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-md-4 col-sm-2 text-center" style="background-color: #e6e6e6;">
        <div style="padding-top: 5px; font-size: 20px;">
            <b>{{$order->getCode()}}</b>
        </div>
    </div>
</div>
@if($order->status != \App\Models\Order::STATUS['INTERNAL'])

    <div class="form-group row {{ $errors->has('name') ? 'has-error' : ''}}">
        {!! Form::label('name', 'Customer Full Name', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
        <div class="col-md-9 col-sm-7">
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
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

@endif

<div class="form-group row {{ $errors->has('note') ? 'has-error' : ''}}">
    {!! Form::label('note', 'Note', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
        {!! Form::textarea('note', null, ['class' => 'form-control summernote']) !!}
    </div>
</div>

<div class="form-group row">
    <div class="col-sm-12 text-right">
        <a href="{{ url("/orders")  }}" class="btn btn-secondary">Cancel</a>
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-success']) !!}
    </div>
</div>
