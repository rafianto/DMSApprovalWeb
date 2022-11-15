
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <!--  <img src="{{asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">-->
      <span class="brand-text font-weight-light">DMS V.2021 3.0.1 </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('assets/images/person.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ strstr(Auth::user()->email, '@', true) }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

            <!-- Dashboard -->
            <li class="nav-item">
                <a href="/home"
                    class="nav-link {{ request()->segment(1) == 'home' ? 'active' : ''}}"
                >
                    <i class="nav-icon fas fa-th"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <!-- Overview Branch -->
            @if ( \Auth::user()->isbranc == 'Y' )
            <li class="nav-item">
                <a href="/branch"
                    class="nav-link {{ request()->segment(1) == 'branch' ? 'active' : ''}}"
                >
                    <i class="fas fa-warehouse"></i>
                    <p>&nbsp;&nbsp;&nbsp;Overview Branch</p>
                </a>
            </li>
            @endif

            <!-- Overview Sent -->
            @if ( \Auth::user()->isprinc == 'Y' )
            <li class="nav-item">
                <a href="/overview"
                    class="nav-link {{ request()->segment(1) == 'overview' ? 'active' : ''}}"
                >
                    <i class="fas fa-share-square"></i>
                    <p>&nbsp;&nbsp;&nbsp;Overview Sent</p>
                </a>
            </li>
            @endif

            <!-- Overview History -->
            @if ( \Auth::user()->ishisto == 'Y' )
            <li class="nav-item">
                <a href="/history"
                    class="nav-link {{ request()->segment(1) == 'history' ? 'active' : ''}}"
                >
                    <i class="fas fa-history"></i>
                    <p>&nbsp;&nbsp;&nbsp;Overview History</p>
                </a>
            </li>
            @endif

            <!-- Reporting -->
            @if ( \Auth::user()->isrept == 'Y' )
            <li class="nav-item has-treeview {{ request()->segment(1) == 'report' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->segment(1) == 'report' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>
                      Reporting
                      <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="/report/hna"
                            class="nav-link {{ request()->segment(2) == 'hna' ? 'active' : ''}}"
                        >
                          <i class="far fa-circle nav-icon"></i>
                          <p>HNA</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/report/cbp"
                            class="nav-link {{ request()->segment(2) == 'cbp' ? 'active' : ''}}"
                        >
                          <i class="far fa-circle nav-icon"></i>
                          <p>CBP</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

             <!-- Change Password -->
             <li class="nav-item">
                <a href="/changepassword"
                    class="nav-link {{ request()->segment(1) == 'changepassword' ? 'active' : ''}}"
                >
                    <i class="fas fa-unlock-alt"></i>
                    <p>&nbsp;&nbsp;&nbsp;Change Password</p>
                </a>
            </li>

            <!-- Administrator -->
            @if ( \Auth::user()->isadmin == 'Y' )
            <li class="nav-item">
                <a href="/admin"
                    class="nav-link {{ request()->segment(1) == 'admin' ? 'active' : ''}}"
                >
                    <i class="fas fa-users-cog"></i>
                    <p>&nbsp;&nbsp;&nbsp;Administrator</p>
                </a>
            </li>
            @endif

            {{-- Logout --}}
            <li class="nav-item">
                <a href="{{ route('logout') }}"
                    class="nav-link {{ request()->segment(1) == 'logout' ? 'active' : ''}}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                >
                    <i class="fas fa-door-open"></i>
                    <p>&nbsp;&nbsp;&nbsp;Logout</p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                    <input type="hidden" value="{{ Auth::user()->email }}" name="email">
                </form>
            </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
