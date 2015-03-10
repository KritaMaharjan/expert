<header class="main-header">
    <a href="{{url('system')}}" data-push="true" class="logo"><strong>Fast</strong>Books</a>
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
          
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have  new client</li>
              <li>
                <ul class="menu">
                 
                  <li>
                    <a href="">
                      <h4>
                       
                       {{--  <small><i class="fa fa-clock-o"></i> </small> --}}
                      </h4>
                      <p></p>
                    </a>
                  </li>
                 


                </ul>
              </li>
              <li class="footer"><a href="{{url('system/client')}}">See All Clients</a></li>
            </ul>
          </li>

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs">System Admin</span>
            </a>
            <ul class="dropdown-menu fix-width">
              <!-- User image -->
              <li class="footer">
                   <a href="{{url('system/profile')}}" data-push="true" >Profile</a>
              </li>
                          <li class="footer">

                  <a href="{{url('system/logout')}}" >Sign out</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>