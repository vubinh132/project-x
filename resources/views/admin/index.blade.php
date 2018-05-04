@extends('layouts.admin.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">HOME PAGE</h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li>Admin</li>
                <li class="active">HOME PAGE</li>
            </ol>
        </div>
    </div>
    <div class="white-box">
        <div class="row row-in">
            <div class="col-lg-3 col-sm-6 row-in-br">
                <div class="col-in row">
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <i class="linea-icon linea-ecommerce fa-fw text-danger" data-icon="U"></i>
                        <h5 class="text-muted vb">PROFIT</h5>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <h3 class="counter text-right m-t-15 text-danger">{{$profit}}</h3>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="progress">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40"
                                 aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">40% Complete (success)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 row-in-br  b-r-none">
                <div class="col-in row">
                    <div class="col-md-6 col-sm-6 col-xs-6"><i
                                class="linea-icon linea-ecommerce fa-fw text-primary" data-icon="Z"></i>
                        <h5 class="text-muted vb">P. VALUE</h5></div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <h3 class="counter text-right m-t-15 text-primary">{{$productValue}}</h3>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="progress">
                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="40"
                                 aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">40% Complete (success)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 row-in-br">
                <div class="col-in row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <i class="linea-icon linea-basic fa-fw text-info" data-icon="V"></i>
                        <h5 class="text-muted vb">LỊCH KHÁM</h5></div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <h3 class="counter text-right m-t-15 text-info">0</h3></div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="progress">
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40"
                                 aria-valuemin="0" aria-valuemax="100" style="width: 40%"><span class="sr-only">40% Complete (success)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6  b-0">
                <div class="col-in row">
                    <div class="col-md-6 col-sm-6 col-xs-6"><i class="fa fa-building fa-fw text-success"></i>
                        <h5 class="text-muted vb">KHÁCH SẠN</h5></div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <h3 class="counter text-right m-t-15 text-success">0</h3>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                 aria-valuemin="0" aria-valuemax="100" style="width: 40%"><span class="sr-only">40% Complete (success)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center text-info" style="padding-top: 50px; padding-bottom: 70px">
            <span style="font-size: 90px;"> <b>{{$days}}</b></span><span style="font-size: 50px"><b>天</b></span>
        </div>
    </div>
@endsection
