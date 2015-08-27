<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="{{ $controller =='DashboardController' ? 'active' : '' }}">
                <a href="{{url('system')}}" title="Dashboard">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="{{ $controller =='ClientController' ? 'active' : '' }}">
                <a href="{{url('system/client')}}" title="Clients">
                    <i class="fa fa-users"></i> <span>Clients</span>
                </a>
            </li>

            <li class="treeview {{ $controller =='LeadController' ? 'active' : '' }}">
                <a href="#" title="Lead">
                    <i class="fa fa-dashboard"></i> <span>Leads</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @if($current_user->role == 4)
                    <li><a href="{{route('system.lead')}}" title="All Leads"><i class="fa fa-circle-o"></i> View
                            All</a></li>
                    <li><a href="{{route('system.lead.add')}}" title="Add Lead"><i class="fa fa-circle-o"></i>
                            Add</a></li>
                    @elseif($current_user->role == 3)
                    <li><a href="{{route('system.lead.accepted')}}" title="Accepted Leads"><i class="fa fa-circle-o"></i> Accepted Leads</a></li>
                    <li><a href="{{route('system.lead.pending')}}" title="Pending Leads"><i class="fa fa-circle-o"></i> Pending Leads</a></li>
                    @endif
                </ul>
            </li>

            <li class="treeview {{ $controller =='ApplicationController' ? 'active' : '' }}">
                <a href="#" title="Application">
                    <i class="fa fa-dashboard"></i> <span>Applications</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('system.application')}}" title="All Applications"><i class="fa fa-circle-o"></i> View
                            All</a></li>
                    <li><a href="{{route('system.application.add')}}" title="Add Application"><i class="fa fa-circle-o"></i>
                            Add</a></li>
                </ul>
            </li>

            <li class="treeview {{ $controller =='UserController' ? 'active' : '' }}">
                <a href="#" title="User">
                    <i class="fa fa-dashboard"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('system.user')}}" title="All Users"><i class="fa fa-circle-o"></i> View
                            All</a></li>
                    <li><a href="{{route('system.user.add')}}" title="Add User"><i class="fa fa-circle-o"></i>
                            Add</a></li>
                </ul>
            </li>

            {{-- Check for marketing only --}}
            <li class="{{ $controller =='ReportController' ? 'active' : '' }}">
                <a href="{{url('system/report')}}" title="Reports Marketing">
                    <i class="fa fa-file-text"></i> <span>Reports</span>
                </a>
            </li>

            <li class="treeview {{ $controller =='SettingController' ? 'active' : '' }}">
                <a href="#" title="Settings">
                    <i class="fa fa-dashboard"></i> <span>Settings</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('system.setting.email')}}" title="Emails"><i class="fa fa-circle-o"></i> Emails</a>
                    </li>
                    <li><a href="{{route('system.setting.template')}}" title="Templates"><i class="fa fa-circle-o"></i>
                            Templates</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<div id="app-content" class="content-wrapper">