@extends('layouts.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Users[{{$total}}]</h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/admin') }}">Admin</a></li>
                <li class="active">Users</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="table-responsive">
                    <div class="dataTables_wrapper no-footer">
                        <div class="dataTables_filter">
                            {!! Form::open(['method' => 'GET', 'url' => '/admin/users', 'class' => '', 'role' => 'search'])  !!}
                            <div class="input-group">
                                <label style="margin-right: 20px;">
                                    <input type="checkbox" name="is_user" value="1"
                                           onchange="this.form.submit()" {{ $isUser ? 'checked' : '' }}>
                                    Users
                                </label>
                                <label style="margin-right: 20px;">
                                    <input type="checkbox" name="is_admin" value="1"
                                           onchange="this.form.submit()" {{ $isAdmin ? 'checked' : '' }}>
                                    Staffs
                                </label>
                                <input type="text" class="form-control search-text" name="q"
                                       value="{{ Request::get('q') }}"
                                       placeholder="Search by name, email, phone number...">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="submit">
                                        Search <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            {!! Form::close() !!}
                        </div>

                        <table class="table table-borderless table-striped">
                            <thead>
                            <tr>
                                <th class="hidden-xs"></th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th class="text-center">Day Of Birth</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $item)
                                <tr>
                                    <td class="hidden-xs">
                                        <img src="{{ $item->imageUrl() }}" width="40" height="40" class="img-circle"
                                             style="border: 1px solid #ddd;">
                                    </td>
                                    <td>
                                        {{ $item->full_name }}
                                        <div class="small">{{ $item->fb_uid || $item->google_uid ? "(".$item->loginType().")" : '' }}</div>
                                    </td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td class="text-center">{{ $item->birth_day }}</td>
                                    <td class="text-center">{{ $item->roleName()}}</td>
                                    <td class="text-center">{{ $item->status() }}</td>
                                    <td class="text-center text-nowrap">
                                        <a href="{{ url('/admin/users/' . $item->id) }}"
                                           data-toggle="tooltip"
                                           title="Xem" data-animation="false">
                                            <i class="fa fa-eye text-inverse m-l-5 m-r-5"></i>
                                        </a>
                                        <a href="{{ url('/admin/users/' . $item->id . '/edit') }}"
                                           data-toggle="tooltip" title="Sửa" data-animation="false">
                                            <i class="fa fa-pencil-square-o text-inverse m-l-5 m-r-5"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="dataTables_paginate paging_simple_numbers">
                            {!! $users->appends(['q' => Request::get('q'), 'is_user' => $isUser, 'is_admin' => $isAdmin])->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
