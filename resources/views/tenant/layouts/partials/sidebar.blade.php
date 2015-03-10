  <aside class="main-sidebar">
        <section class="sidebar">          


          <ul class="sidebar-menu">


            <li class="treeview">
              <a href="#" title="Settings">
                <i class="fa fa-dashboard"></i> <span>My Desk</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#" title="Emails"><i class="fa fa-circle-o"></i> Emails</a></li>
                <li><a href="#" title="To-do lists"><i class="fa fa-circle-o"></i> To-do lists</a></li>
              </ul>
            </li>

            @if(FB::can_view('Customer'))
            <li>
              <a href="{{route('tenant.customer.index')}}" title="Customers">
                <i class="fa fa-users"></i> <span>Customers</span>
              </a>
            </li>
            @endif

            @if(FB::can_view('Invoice'))
            <li class="treeview">
              <a href="#" title="Invoices">
                <i class="fa fa-file"></i> <span>Invoices</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#" title="Bills"><i class="fa fa-circle-o"></i> Bills</a></li>
                <li><a href="#" title="Offers"><i class="fa fa-circle-o"></i> Offers</a></li>
              </ul>
            </li> 
            @endif 

            @if(FB::can_view('Collections'))       
            <li>
              <a href="#" title="Collections">
                <i class="fa fa-files-o"></i> <span>Collections</span>
              </a>
            </li>
            @endif

            @if(FB::can_view('Accounting')) 
            <li>
              <a href="#" title="Accounting">
                <i class="fa fa-book"></i> <span>Accounting</span>
              </a>
            </li>
            @endif 

            @if(FB::can_view('Inventory'))
            <li>
              <a href="#" title="Inventory" class="treeview">
                <i class="fa fa-list-alt"></i> <span>Inventory</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
                 <ul class="treeview-menu">
                  <li><a data-push="true" href="{{route('tenant.inventory.index')}}" title="Manage Inventory"><i class="fa fa-circle-o"></i>Inventory</a></li>
                  <li><a data-push="true" href="{{route('tenant.inventory.product.index')}}" title="Add Product"><i class="fa fa-circle-o"></i>Product</a></li>
                </ul>
            </li> 
            @endif

            @if(FB::can_view('Statistics'))
            <li>
              <a href="#" title="Statistics">
                <i class="fa fa-bar-chart-o"></i> <span>Statistics</span>
              </a>
            </li> 
            @endif

            @if(FB::can_view('Users'))
            <li class="treeview">
              <a href="#" title="Users">
                <i class="fa fa-dashboard"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{route('tenant.users')}}" data-push="true" title="Emails"><i class="fa fa-circle-o"></i> Manage Users</a></li>
              </ul>
            </li>
            @endif

            @if(FB::can_view('Settings'))
            <li class="treeview">
              <a href="#" title="Users">
                <i class="fa fa-cog"></i> <span>Settings</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{route('tenant.setting.system')}}" data-push="true" title="Emails"><i class="fa fa-circle-o"></i> System</a></li>
                <li><a href="{{route('tenant.setting.user')}}" data-push="true" title="Templates"><i class="fa fa-circle-o"></i> Profile</a></li>
                <li><a href="{{route('tenant.setting.email')}}" data-push="true" title="Templates"><i class="fa fa-circle-o"></i> Email</a></li>
              </ul>
            </li> 
            @endif           
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

<div id="app-content" class="content-wrapper">