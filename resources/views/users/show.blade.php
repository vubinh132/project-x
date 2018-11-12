@extends('layouts.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Profile</h4>
        </div>
        <div class="col-lg-8 col-md-9 col-sm-7 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/admin') }}">Admin</a></li>
                @if ($isMyProfile)
                    <li class="active">My Profile</li>
                @else
                    <li>
                        <a href="{{ url($user->isAdmin() ? 'admin/users?is_admin=true' : 'admin/users') }}">{{ $user->isAdmin() ? 'Staffs' : 'Users' }}</a>
                    </li>
                    <li class="active">Hồ sơ cá nhân</li>
                @endif
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 text-center">
            <img class="col-sm-12" src="{{ $user->imageUrl() }}">
        </div>
        <div class="col-sm-9">
            <div class="white-box">
                <div class="form-horizontal">
                    <div class="form-group row">
                        <label class="col-md-3 col-sm-5 col-form-label">
                            Full Name
                        </label>
                        <div class="col-md-9 col-sm-7">
                            {{$user->full_name}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-sm-5 col-form-label">
                            Email
                        </label>
                        <div class="col-md-9 col-sm-7">
                            {{$user->email}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-sm-5 col-form-label">
                            Phone Number
                        </label>
                        <div class="col-md-9 col-sm-7">
                            {{$user->phone }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-sm-5 col-form-label">
                            Day Of Birth
                        </label>
                        <div class="col-md-9 col-sm-7">
                            {{$user->birth_day}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-sm-5 col-form-label">
                            Address
                        </label>
                        <div class="col-md-9 col-sm-7">
                            {{$user->address}}
                        </div>
                    </div>
                    @if (!$isMyProfile)
                        <div class="form-group row">
                            <label class="col-md-3 col-sm-5 col-form-label">
                                Status:
                            </label>
                            <div class="col-md-9 col-sm-7">
                                {{$user->status() }}
                            </div>
                        </div>
                    @endif
                    <div class="m-t-20">
                        @if ($isMyProfile)
                            <a href="{{ url('admin/my-profile/edit') }}" class="btn btn-info">
                                Edit Profile
                            </a>
                        @else
                            <a href="{{ URL::previous() }}"
                               class="btn btn-secondary">
                                Quay Lại
                            </a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
