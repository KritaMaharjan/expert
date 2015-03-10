 <aside class="main-sidebar">
        <section class="sidebar">          
          <ul class="sidebar-menu">
           <li>
              <a href="{{url('system')}}" data-push="true" title="Dashboard">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
            <li>
              <a data-push="true" href="{{url('system/client')}}" title="Clients">
                <i class="fa fa-users"></i> <span>Clients</span>
              </a>
            </li>

             <li class="treeview">
              <a href="#" title="Settings">
                <i class="fa fa-dashboard"></i> <span>Settings</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{route('system.setting.email')}}" data-push="true" title="Emails"><i class="fa fa-circle-o"></i> Emails</a></li>
                <li><a href="{{route('system.setting.template')}}" data-push="true" title="Templates"><i class="fa fa-circle-o"></i> Templates</a></li>
              </ul>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      <div id="app-content" class="content-wrapper">