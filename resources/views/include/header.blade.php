<!-- Navbar-->
<header class="app-header"><a class="app-header__logo d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}"><img src="{{ URL('images/logo.png') }}" style="height: 40px;"></a>
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"><i class="fas fa-bars fa-lg"></i>

    </a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">

        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fas fa-user fa-lg"></i></a>
            <ul class="dropdown-menu settings-menu dropdown-menu-left text-lang-dir">
                <!--    <li><a class="dropdown-item" href="page-user.html"><i class="fas fa-cog fa-lg"></i>  الأعدادات</a></li> -->
                <!--    <li><a class="dropdown-item" href=" route('profile', auth()->user()->id) "><i class="fas fa-user fa-lg"></i>  الملف الشخصي</a></li>-->
                <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt fa-lg margin-x5-by-lang"></i>  {{ __('main.logout') }}</a></li>
            </ul>
        </li>
    </ul>
</header>
