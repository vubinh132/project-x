<div class="white-box">
    <div class="form-group row {{ $errors->has('name') ? 'has-error' : ''}}">
        {!! Form::label('name', 'Tên', ['class' => 'col-md-2 col-form-label']) !!}
        <div class="col-md-10">
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="row {{ $errors->has('code') ? 'has-error' : ''}}">
        {!! Form::label('code', 'Mã quyền', ['class' => 'col-md-2 col-form-label']) !!}
        <div class="col-md-10">
            {!! Form::text('code', null, ['class' => 'form-control']) !!}
            {!! $errors->first('code', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="white-box">
    <h3 class="text-center text-success">Phân quyền cho nhóm người dùng</h3>
    <div class="row">

        @foreach($permissionGroups as $groupName => $permissions)
            <div class="col-md-{{$loop->iteration < 7 ? '2' : '3'}} col-sm-4">
                <h3 class="box-title m-b-0 m-t-20">{{$groupName}}</h3>
                @foreach($permissions as $permissionKey => $permissionName)
                    <div class="checkbox checkbox-success">
                        <input id="{{$permissionKey}}" type="checkbox" name="{{$permissionKey}}"
                               value="1" {{ (isset($permissionList) && in_array($permissionKey, $permissionList) ) ? 'checked' : '' }}>
                        <label for="{{$permissionKey}}">{{$permissionName}}</label>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>

<div class="form-group row">
    <div class="col-sm-12 text-right">
        <a href="{{ CommonService::getPreviousUrl(request()) }}" class="btn btn-secondary">Huỷ Bỏ</a>
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Tạo Mới', ['class' => 'btn btn-success']) !!}
    </div>
</div>
