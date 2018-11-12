<nav class="navbar navbar-default navbar-static-top m-b-0">
    <div class="navbar-header">
        <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)"
           data-toggle="collapse" data-target=".navbar-collapse">
            <i class="ti-menu"></i>
        </a>
        <div class="top-left-part">
            <a class="logo" href="{{ url('/') }}">
                <b>
                    {{--<img src="{{ asset('images/logo1.png') }}" alt="home" />--}}
                </b>
                {{--<span class="hidden-xs">{{ config('app.name') }}</span>--}}
            </a>
        </div>
        <ul class="nav navbar-top-links navbar-left hidden-xs">
            <li>
                <a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light">
                    <i class="icon-arrow-left-circle ti-menu"></i>
                </a>
            </li>
        </ul>
        <ul class="nav navbar-top-links navbar-right pull-right">


            {{--<li class="dropdown">--}}
            {{--<a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#">--}}
            {{--<i class="icon-bell"></i>--}}
            {{--</a>--}}
            {{--<ul class="dropdown-menu mailbox animated bounceInDown">--}}
            {{--<li>--}}
            {{--<div class="drop-title">Thông báo</div>--}}
            {{--</li>--}}

            {{--</ul>--}}
            {{--<!-- /.dropdown-messages -->--}}
            {{--</li>--}}

            <li class="dropdown">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
                    <img src="{{ Auth::user()->imageUrl() }}" alt="user-img" width="36" class="img-circle">
                    <b class="hidden-xs">{{ Auth::user()->full_name }}</b>
                </a>
                <ul class="dropdown-menu dropdown-user animated flipInY">
                    <li>
                        <a href="{{ url('/') }}">
                            <i class="fa fa-home p-r-10"></i> Home Page
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('my-profile') }}">
                            <i class="ti-user p-r-10"></i> My Profile
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="logout(event)">
                            <i class="fa fa-power-off p-r-10"></i> Log out
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>