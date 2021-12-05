<div class="bg-white position-relative" style="z-index: 1022">
    <div class="container-fluid px-lg-5 px-3 py-lg-3 py-2">
        <nav class="navbar navbar-expand-md navbar-light justify-content-between flex-nowrap p-0">
            <button id="drawer-toggler" class="navbar-toggler p-2 d-flex d-lg-none d-inline-block" type="button">
                <i class="fa fa-bars"></i>
            </button>
            <div class="d-lg-flex align-items-center flex-grow-1 text-center">
                <a class="navbar-brand ml-0 ml-lg-3" href="{{ url('/') }}">
                    <span class="d-lg-none">{{ getOption('site_information.website_name',config('settings.website_name')) }}</span>
                    @if(getOption('site_information.logo'))
                        <img class="d-none d-lg-inline-block" src="{{ getImageSrc(getOption('site_information.logo')) }}"
                             style="height: 65px;"
                             title="{{ getOption('site_information.website_name',config('settings.website_name')) }}"
                             alt="{{ getOption('site_information.website_name',config('settings.website_name')) }}"/>
                    @else
                        <span class="d-none d-lg-inline-block">{{ getOption('site_information.website_name',config('settings.website_name')) }}</span>
                    @endif
                </a>
                <div class="d-none d-lg-inline-block flex-grow-1 px-3" style="max-width: 600px">
                    @include('components.search')
                </div>
            </div>
            @guest
                <div class="d-inline-block d-lg-none">
                    <a class="nav-link text-dark" href="{{ route('login') }}">
                        <i class="far fa-user fa-2x fa-fw"></i>
                    </a>
                </div>
                <div class="d-none d-lg-inline-block">
                    <a class="btn btn-success rounded-pill" href="{{ route('login') }}">
                        <span><i class="far fa-user"></i> وارد شوید</span>
                        <span>/</span>
                        <span><i class="far fa-user-plus"></i> ثبت نام</span>
                    </a>
                </div>
            @else
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="btn btn-outline-dark rounded-2 bg-white text-dark"
                           href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="far fa-user-alt" style="font-size: 20px"></i>
                            <span class="d-none d-lg-inline mr-2">سلام، {{ Auth::user()->getName() }}</span>
                        </a>

                        <div class="dropdown-menu position-absolute dropdown-menu-left" style="z-index: 1022;" aria-labelledby="navbarDropdown">
                            @can('view panel')
                                <a class="dropdown-item px-3"
                                   href="{{ route('panel.dashboard') }}">
                                    <i class="fad fa-fw fa-tachometer-alt ml-2"></i>
                                    پنل مدیریت
                                </a>
                                <div class="dropdown-divider"></div>
                            @endcan
                            <a class="dropdown-item px-3 {{ checkActive(['user.dashboard']) ? 'active' : ''}}"
                               href="{{ route('user.dashboard') }}">
                                <i class="fad fa-fw fa-tachometer-alt ml-2"></i>
                                داشبورد
                            </a>
                            <a class="dropdown-item px-3 {{ checkActive([
                                        'user.profile.index',
                                        'user.profile.edit'
                                    ]) ? 'active' : ''}}"
                               href="{{ route('user.profile.index') }}">
                                <i class="fad fa-fw fa-user ml-2"></i>
                                حساب کاربری
                            </a>
                            <a class="dropdown-item px-3 {{ checkActive([
                                        'user.orders.index',
                                        'user.orders.edit',
                                        'user.orders.show',
                                    ]) ? 'active' : ''}}"
                               href="{{ route('user.orders.index') }}">
                                <i class="fad fa-fw fa-shopping-basket ml-2"></i>
                                سفارشات
                            </a>
                            <a class="dropdown-item px-3 {{ checkActive(['user.notifications']) ? 'active' : ''}}"
                               href="{{ route('user.notifications') }}">
                                <i class="fad fa-fw fa-bell ml-2"></i>
                                اعلان ها
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item px-3" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="fad fa-fw fa-power-off ml-2"></i>
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            @endguest
            <div class="d-none d-lg-inline-block">
                @include('components.cart.button')
            </div>
        </nav>
        <div class="d-flex flex-row d-lg-none mt-2 pt-2 border-top">
            <div class="pl-3 flex-grow-1">
                @include('components.search')
            </div>
            @include('components.cart.button')
        </div>
    </div>
</div>
<div class="bg-light text-dark shadow-sm position-sticky sticky-top" style="z-index: 1021">
    <div class="container-fluid px-lg-5 px-3">
        <div class="d-flex flex-nowrap align-items-center position-relative">
            @widget('menu',['name' => 'mainmenu'])
        </div>
    </div>
</div>
