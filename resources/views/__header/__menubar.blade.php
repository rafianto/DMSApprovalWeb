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
          <a href="#" class="d-block">{{ strstr(\Auth::user()->email, '@', true) }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if ( \Auth::user()->isbranc == 'Y' )
                <li class="nav-item">
                  <a href="{{ route('branch') }}" class="nav-link {{ $pilih=='branch' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Overview Branch</p>
                  </a>
                </li>
              @endif

              @if ( \Auth::user()->isprinc == 'Y' )
                <li class="nav-item">
                  <a href="{{ route('overview') }}" class="nav-link {{ $pilih=='overview' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Overview Sent</p>
                  </a>
                </li>
              @endif

              @if ( \Auth::user()->ishisto == 'Y' )
                <li class="nav-item">
                  <a href="{{ route('history') }}" class="nav-link {{ $pilih=='history' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Overview History</p>
                  </a>                
                </li>
              @endif

              @if ( \Auth::user()->isrept == 'Y' )
                <li class="nav-item"> 
                  <a href="./reporting.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Reporting</p>
                  </a>
                </li>
              @endif

              <li class="nav-item">
                <a href="{{ route('changepassword') }}" class="nav-link {{ $pilih=='change' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Change Password</p>
                </a>
              </li>
              
              @if ( \Auth::user()->isadmin == 'Y' )
                  <li class="nav-item">                
                    <a href="{{ route('admin') }}" class="nav-link {{ $pilih=='admin' ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Administrator </p>
                    </a>
                  </li>    
              @endif
              
              <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Logout</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
