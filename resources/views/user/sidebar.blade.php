@php
$new_orders_count = auth()->user()->orders()->approved()->paid(false)->count();
$unread_notifications_count = auth()->user()->unreadnotifications()->count();

@endphp

<div class="bg-white rounded shadow-sm overflow-hidden">
    <img src="{{ getImageSrc(auth()->user()->image ?: 'images/users/default.jpg') }}" class="w-100" alt="">
    <div class="p-4 text-center">
        <h5>
            {{ auth()->user()->getName() }}
        </h5>
    </div>
    <!-- END SIDEBAR USER TITLE -->
    <!-- SIDEBAR MENU -->
    <div class="profile-usermenu">
        <ul class="nav flex-column">
            <li class="nav-item shadow-md-hover {{ checkActive(['user.dashboard']) ? 'border-left border-4 border-primary bg-gray-100' : ''}}">
                <a class="nav-link" href="{{ route('user.dashboard') }}">
                    <i class="fad fa-fw fa-tachometer-alt ml-2"></i> داشبورد
                </a>
            </li>
            <li class="nav-item shadow-md-hover {{ checkActive(['user.profile.index','user.profile.edit']) ? 'border-left border-4 border-primary bg-gray-100' : ''}}">
                <a class="nav-link" href="{{ route('user.profile.index') }}">
                    <i class="fad fa-fw fa-user ml-2"></i> حساب کاربری
                </a>
            </li>
            <li class="nav-item shadow-md-hover {{ checkActive([
                'user.orders.index',
                'user.orders.show',
            ]) ? 'border-left border-4 border-primary bg-gray-100' : ''}}">
                <a class="nav-link" href="{{ route('user.orders.index') }}">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span>
                            <i class="fad fa-fw fa-shopping-basket ml-2"></i> سفارشات
                        </span>
                        @if($new_orders_count)
                            <small data-toggle="tooltip" data-placement="top" title="سفارش پرداخت نشده"
                                    class="px-2 rounded-5 bg-primary text-white fa-num">
                                {{ $new_orders_count }}
                            </small>
                        @endif
                    </div>
                </a>
            </li>
            <li class="nav-item shadow-md-hover {{ checkActive(['user.notifications']) ? 'border-left border-4 border-primary bg-gray-100' : ''}}">
                <a class="nav-link" href="{{ route('user.notifications') }}">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span>
                            <i class="fad fa-fw fa-bell ml-2"></i> اعلان ها
                        </span>
                        @if($unread_notifications_count)
                            <small  data-toggle="tooltip" data-placement="top" title="اعلان های جدید"
                                    class="px-2 rounded-5 bg-primary text-white fa-num">
                                {{ $unread_notifications_count }}
                            </small>
                        @endif
                    </div>
                </a>
            </li>
            <li class="nav-item shadow-md-hover {{ checkActive(['user.comments.index']) ? 'border-left border-4 border-primary bg-gray-100' : ''}}">
                <a class="nav-link" href="{{ route('user.comments.index') }}">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span>
                            <i class="fad fa-fw fa-bell ml-2"></i>  نظرات
                        </span>
                    </div>
                </a>
            </li>
            <li class="nav-item shadow-md-hover">
                <a class="nav-link" href="#"
                   onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                    <i class="fad fa-fw fa-power-off ml-2"></i> خروج از حساب
                </a>
                <form id="sidebar-logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    <!-- END MENU -->
</div>
