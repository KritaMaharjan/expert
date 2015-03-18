<header class="main-header">
    <a href="{{tenant_route('tenant.index')}}" data-push="true" class="logo"><strong>Fast</strong>Books</a>
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
        <li class="dropdown flag">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
             {{--  <i class="fa fa-flag-{{$current_lang}}"></i> --}}

            </a>
            <ul class="dropdown-menu pad-0">
              <li><a href="<?php echo Request::url().'/?lang=no';?>" class="flag_norway"><i class="fa fa-flag-no"></i>Norway</a></li>
              <li><a href="<?php echo Request::url().'/?lang=en';?>" class="flag_english"><i class="fa fa-flag-en"></i>English</a></li>
            </ul>
          </li>
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <ul class="menu">
                  <li>
                    <a href="#">
                      <h4>
                        Customer 1
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </a>
                  </li>
                 


                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>

          <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="">{{ $current_user->fullname }}</span>
              </a>
              <ul class="dropdown-menu fix-width">
                <li class="footer">
                     <a href="{{tenant_route('tenant.profile')}}" data-push="true" >Profile</a>
                </li>
                <li class="footer">

                    <a href="{{tenant_route('tenant.logout')}}" >Sign out</a>
                </li>
              </ul>
            </li>
        </ul>
      </div>
    </nav>
  </header>


