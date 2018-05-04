<header class="header header-style3">
    <div class="section-main-header">
        <div class="kt-mainmenu">
            <div class="container">
                <div class="mainmenu-content">
                    <div class="left-mainmenu">
                        <div class="logo">
                            <a class="" title="Handmade logo" href="{{ url('/') }}">
                                <img alt="Logo" src="{{asset('images/virtus cutom-fit shoes black.png')}}">
                            </a>
                        </div>
                    </div>
                    <div class="right-mainmenu">
                        <span class="togole-menu-mobile"><i class="fa fa-bars"></i></span>
                        <nav class="navigation">
                            <ul class="main-menu">
                                <li class="menu-item menu-parent menu-header">
                                    <a class="p-0" href="#" title="">SHOP <span class="caret caret-header"></span></a>
                                    <ul class="sub-menu">
                                        @php
                                            $shoesTypes=\App\Models\ShoeTypes::all()
                                        @endphp
                                        @foreach($shoesTypes as $shoesType)
                                            <li class="menu-item">
                                                <a href="{{url('shoes-style/'.\Illuminate\Support\Str::lower($shoesType->name) )}}">{{ $shoesType ->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="menu-item menu-parent menu-header">
                                    <a class="p-0" href="{{ url('how-it-works') }}" title="">HOW IT WORKS</a>
                                </li>
                                <li class="menu-item menu-parent menu-header">
                                    <a class="p-0" href="#" title="">BLOG</a>
                                </li>
                                <li class="menu-item menu-parent menu-header">
                                    <a class="p-0" href="{{ url('contact') }}" title="">CONTACT</a>
                                </li>
                                <li class="menu-item menu-parent">
                                    <ul class="no-padding">
                                        <li class="menu-item menu-parent menu-header-login">
                                            <a class="p-0" href="{{url('/login')}}" data-toggle="tooltip"
                                               data-placement="top"
                                               title="">
                                                @if(!\Illuminate\Support\Facades\Auth::check())
                                                    LOGIN
                                                @endif
                                            </a>
                                            @if(\Illuminate\Support\Facades\Auth::check()) {{ \Illuminate\Support\Facades\Auth::user()->full_name}}@endif
                                                @if(\Illuminate\Support\Facades\Auth::check())
                                                    <ul class="sub-menu user-sub-menu">
                                                    <li class="menu-item">
                                                        <a href="{{url('/user/my-profile')}}">Profile</a>
                                                    </li>
                                                    <li class="menu-item">
                                                        <a href="javascript:void(0)" onclick="logout(event)">LogOut</a>
                                                    </li>
                                                </ul>
                                            @endif
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
