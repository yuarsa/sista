<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
        <span class="logo-mini"><img src="{{ asset('img/logo_small.png') }}" class="top-logo-mini" width="35"></span>
        <span class="logo-lg"><img src="{{ asset('img/logo_small.png') }}" class="top-logo-lg" width="35" alt="SMART SISTA">
            <b>JASA MARGA</b>
        </span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                {{-- Access Menu Top Right Nav --}}
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if(Auth::user()->picture)
                            <img src="{{ Storage::url(Auth::user()->picture) }}" class="user-image" alt="User Image">
                        @else
                            <img src="{{ asset('img/no_image_user.jpeg') }}" class="user-image" alt="User Image">
                        @endif                        
                        <span class="hidden-xs">{{ Auth::user()->email }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <ul class="menu">
                                <li class="footer">
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Keluar</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>