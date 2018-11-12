@extends('layouts.index.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Phân Quyền [ {{$total}} ]</h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/admin') }}">Admin</a></li>
                <li class="active">Phân Quyền</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="table-responsive">
                    <div class="dataTables_wrapper no-footer">
                        <div class="dataTables_length">
                            @if($canManageRoles)
                                <label>
                                    <a href="{{ url('/admin/roles/create') }}" class="btn btn-success pull-left"
                                       title="Add New Role">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Thêm Quyền
                                    </a>
                                </label>
                            @endif
                        </div>
                        <div class="dataTables_filter">
                            {!! Form::open(['method' => 'GET', 'url' => '/admin/roles', 'class' => '', 'role' => 'search'])  !!}
                            <div class="input-group">
                                <input type="text" class="form-control search-text" name="q"
                                       value="{{ Request::get('q') }}" placeholder="Tìm theo tên hoặc mã">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="submit">
                                        Tìm <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <table class="table table-borderless table-striped">
                            <thead>
                            <tr>
                                <th>Tên Quyền</th>
                                <th>Mã Quyền</th>
                                <th class="text-center">Số Thành Viên</th>
                                <th class="text-center" style="width: 100px; padding-right: 70px">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $item)
                                <tr>
                                    <td>
                                        {{ $item->name }}
                                    </td>
                                    <td>
                                        {{ $item->code }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->users->count() }}
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <a href="{{ url('/admin/roles/' . $item->id) }}" data-toggle="tooltip"
                                           title="Xem" data-animation="false">
                                            <i class="fa fa-eye text-inverse m-l-5 m-r-5"></i>
                                        </a>
                                        @if($canManageRoles)
                                            <a href="{{ url('/admin/roles/' . $item->id . '/edit') }}"
                                               data-toggle="tooltip" title="Sửa" data-animation="false">
                                                <i class="fa fa-pencil-square-o text-inverse m-l-5 m-r-5"></i>
                                            </a>
                                            @if($item->users()->count() > 0)
                                                <a href="javascript:void(0);" data-toggle="tooltip"
                                                   title="Không thể xóa vì có người dùng thuộc quyền này!"
                                                   data-animation="false" data-placement="left">
                                                    <i class="fa fa-close text-inverse m-l-5 m-r-5"></i>
                                                </a>
                                            @elseif(($item->code)==\App\Models\Role::DTV_ROLE)
                                                <a href="javascript:void(0);" data-toggle="tooltip"
                                                   title="Không thể xóa quyền này!"
                                                   data-animation="false" data-placement="left">
                                                    <i class="fa fa-close text-inverse m-l-5 m-r-5"></i>
                                                </a>
                                            @else
                                                {!! Form::open([
                                                    'method'=>'DELETE',
                                                    'url' => ['/admin/roles', $item->id],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                                <a href="javascript:void(0);" data-toggle="tooltip" title="Xoá"
                                                   data-animation="false"
                                                   onclick="confirmSubmit(event, this, 'Xoá phân quyền', 'Bạn có muốn xoá phân quyền này hay không?')">
                                                    <i class="fa fa-close text-inverse m-l-5 m-r-5"></i>
                                                </a>
                                                {!! Form::close() !!}
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="dataTables_paginate paging_simple_numbers">
                            {!! $roles->appends(['q' => Request::get('q')])->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

