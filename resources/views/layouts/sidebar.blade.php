@php
    $controller = strtolower(request()->route()->getAction()['controller']);
    $userMenuSelected = strpos($controller, 'users') > -1 || strpos($controller, 'roles') > -1;
    $settingMenuSelected = strpos($controller, 'settings') > -1 || strpos($controller, 'logs') > -1;
    $businessMenuSelected = strpos($controller, 'products') > -1 || strpos($controller, 'orders') > -1;
    $storageMenuSelected = strpos($controller, 'diary') > -1 || strpos($controller, 'notes') > -1;
    $externalApisMenuSelected = strpos($controller, 'lazada') > -1 || strpos($controller, 'google') > -1;
    $financeMenuSelected = strpos($controller, 'finance') > -1;


@endphp

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                <div class="input-group custom-search-form">
                    <button class="btn btn-secondary" type="button"><i class="fa fa-search"></i></button>
                </div>
            </li>
            <li class="user-pro">
                <a href="javascript:void(0)" class="waves-effect">
                    <img src="{{ Auth::user()->imageUrl() }}" alt="user-img" class="img-circle">
                    <span class="hide-menu">{{ Auth::user()->full_name }}</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="waves-effect {{ $userMenuSelected ? 'active' : '' }}">
                    <div style="display: inline-block; width: 20px"><i class="fa fa-users" aria-hidden="true"></i></div>
                    <span class="hide-menu">Users Management<i class="fa arrow"></i></span>
                </a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('/users') }}">Users</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:void(0);" class="waves-effect {{ $businessMenuSelected ? 'active' : '' }}">
                    <div style="display: inline-block; width: 20px"><i class="fa fa-cubes" aria-hidden="true"></i></div>
                    <span class="hide-menu">Business<i class="fa arrow"></i></span>
                </a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('/admin/orders') }}">Orders</a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/products') }}">Products</a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/product-checking') }}">Product Checking</a>
                    </li>
                    <li>
                        <a href="{{ url('/rom') }}">ROM</a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/volume-adjustment') }}">Volume Adjustment</a>
                    </li>
                </ul>
            </li>


            <li>
                <a href="javascript:void(0);" class="waves-effect {{ $financeMenuSelected ? 'active' : '' }}">
                    <div style="display: inline-block; width: 20px"><i class="fa fa-dollar" aria-hidden="true"></i>
                    </div>
                    <span class="hide-menu">Finance<i class="fa arrow"></i></span>
                </a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{url('/finance/import')}}">Import</a>
                    </li>
                    <li>
                        <a href="{{url('/finance/export')}}">Export</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javascript:void(0);" class="waves-effect {{ $externalApisMenuSelected ? 'active' : '' }}">
                    <div style="display: inline-block; width: 20px"><i class="fa fa-feed" aria-hidden="true"></i></div>
                    <span class="hide-menu">External APIs<i class="fa arrow"></i></span>
                </a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{url('/external-api/lazada')}}">Lazada</a>
                    </li>
                    <li>
                        <a href="{{url('/external-api/google')}}">Google</a>
                    </li>


                </ul>
            </li>

            <li>
                <a href="javascript:void(0);" class="waves-effect {{ $storageMenuSelected ? 'active' : '' }}">
                    <div style="display: inline-block; width: 20px"><i class="fa fa-archive" aria-hidden="true"></i>
                    </div>
                    <span class="hide-menu">Storage<i class="fa arrow"></i></span>
                </a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('/diary') }}">Diary</a>
                    </li>
                    <li>
                        <a href="{{ url('/notes') }}">Notes</a>
                    </li>
                    <li>
                        <a href="#">Projects</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:void(0);" class="waves-effect {{ $settingMenuSelected ? 'active' : '' }}">
                    <div style="display: inline-block; width: 20px"><i class="fa fa-cogs" aria-hidden="true"></i></div>
                    <span class="hide-menu">Settings<i
                                class="fa arrow"></i></span>
                </a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{url('logs')}}">Log Storage</a>
                    </li>
                    <li>
                        <a href="{{url('general-settings')}}">General Settings</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
