@extends('layouts.admin.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12">
            <h4 class="page-title">Edit Profile</h4>
        </div>
        <div class="col-lg-8 col-sm-7 col-md-7 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/admin') }}">Admin</a></li>
                @if ($isMyProfile)
                    <li><a href="{{ url('admin/my-profile') }}">My Profile</a></li>
                @else
                    <li>
                        <a href="{{ url($user->isAdmin() ? 'admin/users?is_admin=true' : 'admin/users') }}">{{ $user->isAdmin() ? 'Staffs' : 'Users' }}</a>
                    </li>
                    <li><a href="{{ url('admin/users/' .$user->id) }}">Profile</a></li>
                @endif
                <li class="active">Edit Profile</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 text-center">
            <img class="col-sm-12" src="{{ $user->imageUrl() }}">
            @if ($isMyProfile)
                {!! Form::model($user, ['method' => 'POST', 'url' => url('admin/change-profile-image'), 'files' => true]) !!}
            @elseif (!$isMyProfile)
                {!! Form::model($user, ['method' => 'POST', 'url' => url("admin/users/$user->id/change-profile-image"), 'files' => true]) !!}
            @endif
            {{Form::file('user_photo', ['id' => 'user_photo', 'onchange' => 'uploadFileWithLimit(this, 2);', 'style' => 'display: none', 'accept' => config('constants.ACCEPT_IMAGE_TYPES')])}}
            {{Form::button('Change avatar', ['onclick' => "document.getElementById('user_photo').click();", 'class' => 'btn btn-info m-t-20'])}}
            {{--<label class="small">(Dùng ảnh có kích thước vuông và dung lượng tối đa 2Mb)</label>--}}
            {!! Form::close() !!}
        </div>
        <div class="col-sm-9">
            <div class="white-box">
                {!! Form::model($user, ['method' => 'PATCH', 'url' => $isMyProfile ? '/admin/my-profile' : ['/admin/users', $user->id], 'class' => 'form-horizontal', 'files' => true]) !!}
                @include ('admin.users.form', ['submitButtonText' => 'Update'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection
