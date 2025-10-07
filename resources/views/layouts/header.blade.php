<div class="app-header header-shadow">
    <div class="app-header__logo">
        <div class="logo-src">
            <div style="margin-top:-25px;">
            <img src="{{ url('logo.png') }}" width="172">
            </div>

        </div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="app-header__content">

        <div class="app-header-right">
            <div class="header-dots">


                <!-- <div class="dropdown">
                    <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                        <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                            <span class="icon-wrapper-bg bg-danger"></span>
                            <i class="icon text-danger icon-anim-pulse ion-android-notifications"></i>
                            <span class="badge badge-dot badge-dot-sm badge-danger">Pesan</span>
                        </span>
                    </button>
                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                        <div class="dropdown-menu-header mb-0">
                            <div class="dropdown-menu-header-inner bg-deep-blue">
                                <div class="menu-header-image opacity-1" style="background-image: url('assets/images/dropdown-header/city3.jpg');"></div>
                                <div class="menu-header-content text-dark">
                                    <h6 class="menu-header-subtitle">Terdapat <b><span class="labelTotalChat"></span></b> Pesan</h6>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-events-header" role="tabpanel">
                                <div class="scroll-area-sm">
                                    <div class="scrollbar-container">
                                        <div class="p-3">
                                            <div class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column">

                                                <div class="labelListChat"></div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item-divider nav-item"></li>
                            <li class="nav-item-btn text-center nav-item">
                                <a href="{{ url('chat') }}" class="btn-shadow btn-wide btn-pill btn btn-focus btn-sm">Daftar Pesan</a>
                            </li>
                        </ul>
                    </div>
                </div> -->

            </div>

            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    <img width="42" class="rounded-circle" src="assets/images/user.png" alt="">
                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-info">
                                            <div class="menu-header-image opacity-2" style="background-image: url('assets/images/dropdown-header/city3.jpg');"></div>
                                            <div class="menu-header-content text-left">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">

                                                        <div class="widget-content-left">
                                                            <div class="widget-heading">
                                                            </div>
                                                            <div class="widget-subheading opacity-8">

                                                            </div>
                                                        </div>
                                                        <div class="widget-content-right mr-2">

                                                            <a class="btn-pill btn-shadow btn-shine btn btn-focus" href="{{ route('logout') }}"
                                                                onclick="event.preventDefault();
                                                                                document.getElementById('logout-form').submit();">
                                                                {{ __('Logout') }}
                                                            </a>

                                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                                @csrf
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="scroll-area-xs" style="height: 100px;">
                                        <div class="scrollbar-container ps">
                                            <ul class="nav flex-column">


                                                <!-- <li class="nav-item">
                                                    <a href="{{ url('panduan') }}" class="nav-link" target="blank">Panduan Aplikasi

                                                    </a>
                                                </li> -->
                                                <li class="nav-item">
                                                    <a href="{{ url('profil') }}" class="nav-link">Profil

                                                    </a>
                                                </li>
                                                <!-- <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">Messages
                                                        <div class="ml-auto badge badge-warning">512
                                                        </div>
                                                    </a>
                                                </li> -->
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

          </div>
    </div>
</div>
