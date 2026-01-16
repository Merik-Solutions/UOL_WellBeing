<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">
{{--
        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle waves-effect" data-toggle="dropdown" href="#" role="button"
               aria-haspopup="false" aria-expanded="false">
                <i class="fe-bell noti-icon"></i>
                <span class="badge badge-danger rounded-circle noti-icon-badge">9</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5 class="m-0">
                                    <span class="float-right">
                                        <a href="" class="text-dark">
                                            <small>Clear All</small>
                                        </a>
                                    </span>Notification
                    </h5>
                </div>

                <div class="slimscroll noti-scroll">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item active">
                        <div class="notify-icon">
                            <img src="{!! asset(auth()->guard('admin')->user()->img) !!}"
                                 class="img-fluid rounded-circle" alt=""/></div>
                        <p class="notify-details">Cristina Pride</p>
                        <p class="text-muted mb-0 user-msg">
                            <small>Hi, How are you? What about our next meeting</small>
                        </p>
                    </a>


                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon">
                            <img src="{!! assets('dashboard/dark') !!}/assets/images/users/user-4.jpg"
                                 class="img-fluid rounded-circle" alt=""/></div>
                        <p class="notify-details">Karen Robinson</p>
                        <p class="text-muted mb-0 user-msg">
                            <small>Wow ! this admin looks good and awesome design</small>
                        </p>
                    </a>


                </div>

                <!-- All-->
                <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                    View all
                    <i class="fi-arrow-right"></i>
                </a>

            </div>
        </li>
 --}}
        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#"
               role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{!! assets('dashboard/logo.png') !!}" alt="user-image"
                     class="rounded-circle">
                <span class="pro-user-name ml-1">
                                {!! auth()->guard('admin')->user()->name !!} <i class="mdi mdi-chevron-down"></i>
                            </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">{!! __("Welcome !") !!}</h6>
                </div>

                <!-- item-->
                <a href="{!! route('admin.admins.edit',auth()->id()) !!}" class="dropdown-item notify-item">
                    <i class="fe-user"></i>
                    <span> {!! __("My Account") !!}</span>
                </a>


                <div class="dropdown-divider"></div>



                    <!-- item-->
                <a class="dropdown-item notify-item" href="{{ route('admin.logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="fe-log-out"></i>
                    <span>{!!  __("Logout")!!}</span>
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    {!! csrf_field() !!}
                </form>
            </div>
        </li>
        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#"
               role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{!! assets('dashboard/logo.png') !!}" alt="user-image"
                     class="rounded-circle">
                <span class="pro-user-name ml-1">{{ __('Languages') }}<i class="mdi mdi-chevron-down"></i>
                            </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                @php
                    $thisUrl = url()->current().'/';
                @endphp
                <!-- item-->
                    <a href="{{ str_replace('/en/', '/ar/', $thisUrl) }}" class="dropdown-item notify-item" @if (app()->getLocale() == 'ar') style="font-weight: bold; text-decoration: underline" @endif>العربية
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ str_replace('/ar/', '/en/', $thisUrl) }}" class="dropdown-item notify-item" @if (app()->getLocale() == 'en') style="font-weight: bold; text-decoration: underline" @endif> English
                    </a>
            </div>
        </li>


    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="{!! route('admin.dashboard') !!}" class="logo text-center">
                        <span class="logo-lg">
                            <img src="{!! assets('dashboard/logo.png') !!}" alt="" width="150" >
                        </span>
            <span class="logo-sm">
                            <!-- <span class="logo-sm-text-dark">X</span> -->
                            <img src="{!! assets('dashboard/logo.png') !!}" alt=""width="100"  >
                        </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile disable-btn waves-effect">
                <i class="fe-menu"></i>
            </button>
        </li>

        <li>
            <h4 class="page-title-main"> @yield('title') </h4>
        </li>

    </ul>
</div>
