<div class="form-group row {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Status', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::select('status', $statusList, null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-md-3 text-center" style="background-color: #e6e6e6;">
        <div style="padding-top: 5px; font-size: 20px;">
            <b>{{$order->getCode()}}</b>
        </div>
    </div>
    <div class="col-md-2" style="">
        {!! Form::button('History', ['class' => 'btn btn-info form-control', 'style' => 'color:white', 'data-target'=>'#historyModal', 'data-toggle' => 'modal']) !!}
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

<div class="form-group row {{ $errors->has('is_special') ? 'has-error' : ''}}">
    {!! Form::label('is_special', 'Is Special Order', ['class' => 'col-md-3 col-sm-5 col-form-label']) !!}
    <div class="col-md-9 col-sm-7">
        {!! $errors->first('is_special', '<p class="help-block">:message</p>') !!}
        {!! Form::checkbox('is_special', 1, (isset($order) && $order->is_special) ? true :  false,['class' => '']) !!}
    </div>
</div>

<div class="form-group row">
    <div class="col-sm-12 text-right">
        <a href="{{ url("/orders")  }}" class="btn btn-secondary">Cancel</a>
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-success']) !!}
    </div>
</div>

<div id="historyModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Order History</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">Creation Time</th>
                        <th>From Status</th>
                        <th>To Status</th>
                        <th>Made By</th>
                        <th class="text-center">Period</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($logs) ; $i++)
                        <tr>
                            <td class="text-center">{{$logs[$i]->creation_time}}</td>
                            <td>{{\App\Models\Order::statusTextByCode($logs[$i]->from)}}</td>
                            <td>{{\App\Models\Order::statusTextByCode($logs[$i]->to)}}</td>
                            <td>{{\App\Models\User::find($logs[$i]->entity_id)->username}}</td>
                            <td class="text-center">{{$i == 0 ? '' : \App\Services\CommonService::getStringDuration((new \Carbon\Carbon($logs[$i]->creation_time))->diffInSeconds((new \Carbon\Carbon($logs[$i -1]->creation_time))))}}</td>
                            </td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>