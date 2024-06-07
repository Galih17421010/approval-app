
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-dark">
    <div class="container">
      <span class="navbar-brand brand-text font-weight-light">
        <i class="fa fa-globe"></i>
        {{ config('app.name') }} - @yield('title')
      </span>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
          <!-- Notifications Dropdown Menu -->
          @guest
          
          @else     
          <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                      {{ Auth::user()->name }}
              </a>
              <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                  {{-- <div class="dropdown-divider"></div> --}}
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <span class="fas fa-power-off"></span> Logout
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
              </div>
          </li>
          @endguest
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->