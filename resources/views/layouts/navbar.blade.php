
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
              
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <div class="image">
                    <img src="{{asset('assets/img/user2-160x160.jpg')}}" class="img-size-32 img-circle mr-2" alt="User Image">
                    {{ Auth::user()->name }}
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                <a class="dropdown-item" href="?page=profil">
                    <span class="fa fa-user"></span> My Account
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="fas fa-power-off"></span> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
        
        <!-- Theme -->
        <li class="nav-item">
            <div class="theme-switch-wrapper nav-link">
              <label class="theme-switch" for="checkbox">
                <input type="checkbox" id="checkbox" />
                <span class="slider round"></span>
              </label>
            </div>
        </li>
        
    </ul>
  </nav>
  <!-- /.navbar -->