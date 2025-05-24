<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <img style="width: 35px;" src="{{ asset('logo.png') }}" alt="">
            <span class="demo menu-text fw-bolder ms-2" style="font-size: 20px;">{{ __('messages.panel_name') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1" >
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('admin') ? 'active' : '' }}">
            <a href="/" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-dashboard'></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        @can('user_management_access')
            <li
                class="menu-item {{ request()->is('admin/users') || request()->is('admin/users/*') || request()->is('admin/roles') || request()->is('admin/roles/*') || request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-user-circle'></i>
                    <div data-i18n="Layouts">User Management</div>
                </a>

                <ul class="menu-sub">
                    @can('permission_access')
                        <li
                            class="menu-item {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.permissions.index') }}" class="menu-link">
                                <div data-i18n="Without menu">Permission</div>
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li
                            class="menu-item {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.roles.index') }}" class="menu-link">
                                <div data-i18n="Without menu">Roles</div>
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li
                            class="menu-item {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active open' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class="menu-link">
                                <div data-i18n="Without menu">Users</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan


        <li class="menu-item {{ request()->is('admin/currency-rates') ? 'active' : '' }}">
            <a href="{{ route('admin.currency-rates.index') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-dollar-circle'></i>
                <div data-i18n="Analytics">Currency Rate</div>
            </a>
        </li>

         {{-- delivery system  --}}
         @php
            $stateActive = Request::is('admin/delivery-management/*') ? 'active open' : '';
        @endphp

        <li class="menu-item {{ $stateActive }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-truck"></i>
                <div data-i18n="Account Settings">Delivery Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/delivery-management/states') || request()->is('admin/delivery-management/states/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.states.index')}}" class="menu-link">
                        <div data-i18n="Connections">State</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/delivery-management/cities') || request()->is('admin/delivery-management/cities/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.cities.index')}}" class="menu-link">
                        <div data-i18n="Connections">City</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- career  --}}
        @php
            $careerActive = Request::is('admin/career-management/*') ? 'active open' : '';
        @endphp

        <li class="menu-item {{ $careerActive }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-briefcase'></i>
                <div data-i18n="Account Settings">Career Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/career-management/departments') || request()->is('admin/career-management/departments/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.departments.index')}}" class="menu-link">
                        <div data-i18n="Connections">Department</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->is('admin/career-management/positions') || request()->is('admin/career-management/positions/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.positions.index')}}" class="menu-link">
                        <div data-i18n="Connections">Position</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->is('admin/career-management/careers') || request()->is('admin/career-management/careers/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.careers.index')}}" class="menu-link">
                        <div data-i18n="Connections">Career</div>
                    </a>
                </li>

            </ul>
        </li>

        {{-- content  --}}
        @php
            $contentActive = Request::is('admin/content-management/*') ? 'active open' : '';
        @endphp

        <li class="menu-item {{ $contentActive }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bx-credit-card-front'></i>
                <div data-i18n="Account Settings">Content Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/content-management/slider') || request()->is('admin/content-management/slider/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.slider.index')}}" class="menu-link">
                        <div data-i18n="Connections">Slider</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/content-management/promotions') || request()->is('admin/content-management/promotions/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.promotions.index')}}" class="menu-link">
                        <div data-i18n="Connections">Promotions</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/content-management/partners') || request()->is('admin/content-management/partners/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.partners.index')}}" class="menu-link">
                        <div data-i18n="Connections">Our Partners</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- order  --}}
        @php
            $orderActive = Request::is('admin/order-management/*') ? 'active open' : '';
        @endphp

        <li class="menu-item {{ $orderActive }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-cart'></i>
                <div data-i18n="Account Settings">Order Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/order-management/pending-orders') || request()->is('admin/order-management/pending-orders/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.pending-orders.index')}}" class="menu-link">
                        <div data-i18n="Connections">Pending Orders</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/order-management/confirmed-orders') || request()->is('admin/order-management/confirmed-orders/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.confirmed-orders.index')}}" class="menu-link">
                        <div data-i18n="Connections">Confirmed Orders</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/order-management/cancelled-orders') || request()->is('admin/order-management/cancelled-orders/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.cancelled-orders.index')}}" class="menu-link">
                        <div data-i18n="Connections">Cancelled Orders</div>
                    </a>
                </li>
            </ul>
        </li>


        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Products</span>
        </li>

        {{-- product  --}}
        @php
            $productActive = Request::is('admin/product-management/*') ? 'active open' : '';
        @endphp

        <li class="menu-item {{ $productActive }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-cube-alt"></i>
                <div data-i18n="Account Settings">Product Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/product-management/products') || request()->is('admin/product-management/products/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.products.index')}}" class="menu-link">
                        <div data-i18n="Connections">Product</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->is('admin/product-management/brands') || request()->is('admin/product-management/brands/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.brands.index')}}" class="menu-link">
                        <div data-i18n="Account">Brand</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/product-management/series') || request()->is('admin/product-management/series/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.series.index')}}" class="menu-link">
                        <div data-i18n="Notifications">Series</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/product-management/categories') || request()->is('admin/product-management/categories/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.categories.index')}}" class="menu-link">
                        <div data-i18n="Notifications">Category</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/product-management/attributes') || request()->is('admin/product-management/attributes/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.attributes.index')}}" class="menu-link">
                        <div data-i18n="Notifications">Attribute</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- xp pen  --}}
        @php
            $xppenActive = Request::is('admin/xppen/*') ? 'active open' : '';
        @endphp

        <li class="menu-item {{ $xppenActive }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bx-pencil'></i>
                <div data-i18n="Account Settings">XP Pen</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/xppen/xppen-categories') || request()->is('admin/xppen/xppen-categories/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.xppen-categories.index')}}" class="menu-link">
                        <div data-i18n="Connections">XP Pen Category</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/xppen/xppen-series') || request()->is('admin/xppen/xppen-series/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.xppen-series.index')}}" class="menu-link">
                        <div data-i18n="Connections">XP Pen Series</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/xppen/xppen-products') || request()->is('admin/xppen/xppen-products/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.xppen-products.index')}}" class="menu-link">
                        <div data-i18n="Connections">XP Pen Product</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- adreamer  --}}
        @php
            $adreamerActive = Request::is('admin/adreamer/*') ? 'active open' : '';
        @endphp

        <li class="menu-item {{ $adreamerActive }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-cube-alt"></i>
                <div data-i18n="Account Settings">CHUWI</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/adreamer/adreamer-products') || request()->is('admin/adreamer/adreamer-products/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.adreamer-products.index')}}" class="menu-link">
                        <div data-i18n="Connections">Product</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/adreamer/adreamer-categories') || request()->is('admin/adreamer/adreamer-categories/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.adreamer-categories.index')}}" class="menu-link">
                        <div data-i18n="Notifications">Category</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/adreamer/adreamer-attributes') || request()->is('admin/adreamer/adreamer-attributes/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.adreamer-attributes.index')}}" class="menu-link">
                        <div data-i18n="Notifications">Attribute</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- globe solar  --}}
        @php
            $solarActive = Request::is('admin/solar/*') ? 'active open' : '';
        @endphp

        <li class="menu-item {{ $solarActive }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-square"></i>
                <div data-i18n="Account Settings">Globe Solar</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/solar/solar-products') || request()->is('admin/solar/solar-products/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.solar-products.index')}}" class="menu-link">
                        <div data-i18n="Connections">Globe Solar Products</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/solar/solar-categories') || request()->is('admin/solar/solar-categories/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.solar-categories.index')}}" class="menu-link">
                        <div data-i18n="Notifications">Category</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/solar/solar-attributes') || request()->is('admin/solar/solar-attributes/*') ? 'active open' : '' }}">
                    <a href="{{route('admin.solar-attributes.index')}}" class="menu-link">
                        <div data-i18n="Notifications">Attribute</div>
                    </a>
                </li>
            </ul>
        </li>


    </ul>
</aside>
