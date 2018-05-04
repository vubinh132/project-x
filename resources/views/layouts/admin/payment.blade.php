<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ url('/favicon.ico') }}"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Viettel Booking | Payment') }}</title>

    <link href="{{ asset('theme/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/css/payment/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/css/payment/font.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/css/payment/style.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/css/payment/customize.css') }}" rel="stylesheet">

    <style>
        a {
            cursor: pointer;
        }

        html, body {
            font-size: 14px;
            font-weight: 400;
            color: #383838;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            font-family: 'Roboto', sans-serif;
            line-height: 1.2;
        }
    </style>
</head>
<body>

<div id="container">
    <app>
        <layout-header class="ng-trigger-fadeInAnimation">
            <div id="header">
                <div class="header__top">
                    <div class="max__w--1140">
                        <div class="clearfix">
                            <a class="header__logo" href="#">
                                <img alt="" src="{{ url('/logo.png') }}">
                            </a>
                            <div class="city hidden-sm-down">
                                <div class="dropdown">
                                    <a class="val-selected">Hồ Chí Minh <span
                                                class="icon-keyboard_arrow_down"></span></a>
                                    <div class="dropdown-up-style hide">
                                        <div class="dropdown__inner">
                                            <span class="arrow_dropdown"></span>
                                            <div class="scroll__emu">
                                                <ul>
                                                    <li><a>Hà Nội</a></li>
                                                    <li><a>Hồ Chí Minh</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="header__search">
                                <form class="ng-untouched ng-pristine ng-valid"
                                      action="http://sandbox.booking.imt-soft.com:8080/" novalidate="">
                                    <span class="icons icon-search"></span>
                                    <input type="text" placeholder="Tìm kiếm địa điểm, tên khách sạn...">
                                    <div class="search__btn">
                                        <button class="btn__search--header"><span class="icons icon-search-2"></span>Tìm
                                            kiếm
                                        </button>
                                        <a class="close__search" href="http://sandbox.booking.imt-soft.com:8080/"><span
                                                    class="icon-close"></span></a>
                                    </div>
                                </form>
                            </div>
                            <div class="user__auth hidden-sm-down">
                                <div class="dropdown header__lang">
                                    <a class="val-selected"><span class="icons icon-lang icon-vi"></span></a>
                                    <div class="dropdown-up-style hide">
                                        <div class="dropdown__inner">
                                            <span class="arrow_dropdown"></span>
                                            <ul>
                                                <li>
                                                    <a>Tiếng Việt</a>
                                                </li>
                                                <li>
                                                    <a>English</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="dropdown dropdown__auth">
                                    <a class="val-selected"><span class="icons icon-user"></span> Tài khoản <span
                                                class="icons icon-dropdown-1"></span></a>
                                    <div class="dropdown-up-style hide">
                                        <div class="dropdown__inner">
                                            <span class="arrow_dropdown"></span>
                                            <ul>
                                                <li><a>Đăng nhập</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="header__bottom hidden-sm-down">
                    <div class="max__w--1140">
                        <ul class="clearfix">
                            <li><a class="active" routerlink="/" ng-reflect-router-link="/" href="#"><span
                                            class="icons icon-home"></span> Trang chủ</a></li>
                            <li><a routerlink="/air-ticket" ng-reflect-router-link="/air-ticket" href="#"><span
                                            class="icons icon-fly-1"></span> Vé máy bay</a></li>
                            <!-- <li><<li><a><span class="icons icon-food"></span> Nhà hàng</a></li>
                            <li><a><span class="icons icon-medical"></span> Đặt lịch khám</a></li> -->
                            <li><a routerlink="/news" ng-reflect-router-link="/news"
                                   href="http://sandbox.booking.imt-soft.com:8080/news"><span
                                            class="icons icon-news"></span>Tin tức</a></li>
                            <li><a><span class="icons icon-promo"></span>Khuyến mãi</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </layout-header>

        <app-booking-payment class="ng-tns-c12-7 ng-trigger ng-trigger-fadeInAnimation">
            <div class="bg__eeeeee ticket__infor--page">
                <div class="max__w--1140">
                    <div class="box__shadow process__booking hidden-sm-down">
                        <ul class="clearfix">
                            <li><a><span>1</span>Nhập thông tin booking</a><span class="icon-angle-right"></span></li>
                            <li><a><span>2</span>Kiểm tra đơn đặt</a><span class="icon-angle-right"></span></li>
                            <li><a class="active"><span>3</span>Thanh toán</a><span class="icon-angle-right"></span>
                            </li>
                            <li><a><span>4</span>Xuất vé điện tử</a></li>
                        </ul>
                    </div>

                    @yield('content')
                </div>
            </div>
        </app-booking-payment>
        <layout-footer _ngcontent-c0="" class="ng-tns-c2-1 ng-trigger ng-trigger-fadeInAnimation">
            <div id="footer">
                <div class="footer__copyright">
                    <p class="ng-tns-c2-1">Copyright © 2016 Viettel. All right reserved.</p>
                </div>
            </div>
        </layout-footer>

    </app>
</div>

<script src="{{ asset('theme/js/jquery.min.js') }}"></script>

@yield('extra_scripts')
</body>
</html>
