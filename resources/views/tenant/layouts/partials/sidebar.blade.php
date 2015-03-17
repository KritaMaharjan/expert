  <aside class="main-sidebar">
        <section class="sidebar">          
          <ul class="sidebar-menu">
            <li class="treeview <?php echo (strpos($current_path, 'desk') !==false)? 'active' : '';?>">
              <a href="#" title="My Desk">
                <i class="fa fa-dashboard"></i> <span>My Desk</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{tenant_route('desk.email')}}" title="Emails"><i class="fa fa-circle-o"></i> Emails</a></li>
                <li><a href="#" title="To-do lists"><i class="fa fa-circle-o"></i> To-do lists</a></li>
              </ul>
            </li>
            @if(FB::can_view('Customer'))
            <li class="<?php echo (strpos($current_path, 'customer') !==false)? 'active' : '';?>">
              <a href="{{tenant_route('tenant.customer.index')}}" title="Customers">
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
                <li><a data-push="true" href="{{tenant_route('tenant.invoice.bill.index')}}" title="Manage Bills"><i class="fa fa-money"></i >Bills</a></li>
                <li><a href="#" title="Offers"><i class="fa fa-circle-o"></i> Offers</a></li>
              </ul>
            </li> 
            @endif 

         {{--   @if(FB::can_view('Collections'))
            <li>
              <a href="#" title="Collections">
                <i class="fa fa-files-o"></i> <span>Collections</span>
              </a>
            </li>
            @endif--}}

      {{--      @if(FB::can_view('Accounting'))
            <li>
              <a href="#" title="Accounting">
                <i class="fa fa-book"></i> <span>Accounting</span>
              </a>
            </li>
            @endif --}}

            @if(FB::can_view('Inventory'))
            <li class="<?php echo (strpos($current_path, 'inventory') !==false)? 'active' : '';?>">
              <a href="#" title="Inventory" class="treeview ">
                <i class="fa fa-list-alt"></i> <span>Inventory</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
                 <ul class="treeview-menu">
                  <li><a data-push="true" href="{{tenant_route('tenant.inventory.index')}}" title="Manage Inventory"><i class="fa fa-circle-o"></i>Inventory</a></li>
                  <li><a data-push="true" href="{{tenant_route('tenant.inventory.product.index')}}" title="Add Product"><i class="fa fa-circle-o"></i>Product</a></li>
                </ul>
            </li> 
            @endif

          {{--  @if(FB::can_view('Statistics'))
            <li>
              <a href="#" title="Statistics">
                <i class="fa fa-bar-chart-o"></i> <span>Statistics</span>
              </a>
            </li> 
            @endif--}}

            @if(FB::can_view('Users'))
            <li class="<?php echo ($current_path =='users')? 'active' : '';?>">
              <a href="{{tenant_route('tenant.users')}}" title="@lang('menu.user')">
                <i class="fa fa-dashboard"></i> <span>@lang('menu.users')</span>
              </a>
            </li>
            @endif

            @if(FB::can_view('Settings'))
            <li class="treeview <?php echo (strpos($current_path, 'setting') !==false)? 'active' : '';?>">
              <a href="#" title="Settings">
                <i class="fa fa-cog"></i> <span>Settings</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{tenant_route('tenant.setting.system')}}" data-push="true" title="System"><i class="fa fa-circle-o"></i> System</a></li>
                <li><a href="{{tenant_route('tenant.setting.email')}}" data-push="true" title="Email"><i class="fa fa-circle-o"></i> Email</a></li>
              </ul>
            </li> 
            @endif           
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
<div id="app-content" class="content-wrapper">