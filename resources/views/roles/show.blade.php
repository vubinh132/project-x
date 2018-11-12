@extends('layouts.index.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Phân quyền</h4>
        </div>
        <div class="col-lg-8 col-md-9 col-sm-7 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/admin') }}">Admin</a></li>
                <li><a href="{{ url('/admin/roles') }}">Phân Quyền</a></li>
                <li class="active">Chi Tiết</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="form-horizontal">
                    <div class="form-group row">
                        <label class="col-md-3 col-sm-5 col-form-label">
                            Tên quyền
                        </label>
                        <div class="col-md-9 col-sm-7">
                            {{$role->name}}
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3 col-sm-5 col-form-label">
                            Mã quyền
                        </label>
                        <div class="col-md-9 col-sm-7">
                            {{$role->code}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="white-box">
                <h3 class="text-success">Danh sách quyền của nhóm {{$role->name}}</h3>
                <div class="row">
                    @foreach($permissionGroups as $groupName => $permissions)
                        <div class="col-md-{{$loop->iteration < 7 ? '2' : '3'}} col-sm-4">
                            <h3 class="box-title m-b-0 m-t-20">{{$groupName}}</h3>
                            @foreach($permissions as $permissionKey => $permissionName)
                                <div>
                                    @if(in_array($permissionKey, $permissionList))
                                        <i class="fa fa-check-circle text-success"></i>
                                    @else
                                        <i class="fa fa-ban text-danger"></i>
                                    @endif
                                    <label for="{{$permissionKey}}">{{$permissionName}}</label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="white-box">
                <h3 class="text-success">Danh sách Người Dùng [ {{ $role->users->count() }} ]</h3>
                <table class="table table-borderless table-hover">
                    <thead>
                    <tr>
                        <th>Họ Tên</th>
                        <th>Email</th>
                        <th class="text-center">Điên Thoại</th>
                        <th class="text-center">Ngày sinh</th>
                        <th class="text-center">Quyền</th>
                        <th class="text-center">Trạng thái</th>
                    </tr>
                    </thead>
                    <tbody>
                    <div class="row">
                        @foreach($role->users as $user)
                            <tr>
                                <td>{{$user->full_name}}</td>
                                <td>{{$user->email}}</td>
                                <td class="text-center">{{$user->phone}}</td>
                                <td class="text-center">{{$user->birth_day}}</td>
                                <td class="text-center">{{$role->name}}</td>
                                <td class="text-center">{{$user->status()}}</td>
                            </tr>
                        @endforeach
                    </div>
                    </tbody>
                </table>
            </div>

            <div class="m-t-20">
                <a href="{{ URL::previous() }}" class="btn btn-secondary">
                    Quay Lại
                </a>
            </div>
        </div>
    </div>
@endsection
