@extends('layouts.admin.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">LOGS</h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/admin') }}">Admin</a></li>
                <li class="active">Logs</li>
            </ol>
        </div>
    </div>
    <div class="white-box" ng-app="myApp" ng-controller="logIndexCtrl">
        <div class="table-responsive">
            <div class="dataTables_wrapper no-footer">
                <div class="col-md-5 col-sm-5" style="margin-bottom: 20px">
                    {!! Form::select('category', $categories, null, ['id' => 'category','class' => 'form-control', 'required' => 'required']) !!}
                </div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th style="width: 150px; text-align: center">Datetime</th>
                        <th>Category</th>
                        <th class="text-center">Content</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="x in data|orderBy:'created_at':true">
                            <td ng-bind-html="trustAsHtml(x.created_at + '</br>' + getTime(x.created_at))"></td>
                            <td ng-bind="x.categoryText"></td>
                            <td ng-bind="x.content"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
