<header class="main-header">
    <a href="" data-push="true" class="logo">Expert</a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="">System Admin</span>
              </a>
              <ul class="dropdown-menu fix-width">
                <li class="footer">
                     <a href="{{route('system.user.profile')}}" data-push="true" >Profile</a>
                </li>
                <li class="footer">

                    <a href="{{route('system.logout')}}" >Sign out</a>
                </li>
              </ul>
            </li>
        </ul>
      </div>
    </nav>
  </header>


