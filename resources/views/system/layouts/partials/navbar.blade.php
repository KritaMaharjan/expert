<ul class="nav navbar-nav">
    <li class="{{ $controller =='DashboardController' ? 'active' : '' }}">
        <a href="{{url('system')}}" title="Dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>

    @if($current_user->role != 2)
        <li class="dropdown {{ $controller =='LeadController' ? 'active' : '' }}">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                        class="fa fa-dashboard"></i> <span>Leads</span> <span class="caret"></span></a>

            <ul class="dropdown-menu" role="menu">
                <li><a href="{{route('system.lead')}}" title="All Leads"><i class="fa fa-circle-o"></i> View
                        All</a></li>
                <li><a href="{{route('system.lead.add')}}" title="Add Lead"><i class="fa fa-circle-o"></i>
                        Add New</a></li>
                @if($current_user->role == 3)
                    <li><a href="{{route('system.lead.accepted')}}" title="Accepted Leads"><i
                                    class="fa fa-circle-o"></i>
                            Accepted Leads</a></li>
                    <li><a href="{{route('system.lead.pending')}}" title="Pending Leads"><i class="fa fa-circle-o"></i>
                            Pending Leads</a></li>
                @endif
            </ul>
        </li>

        <li class="dropdown {{ $controller =='ClientController' ? 'active' : '' }}">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                        class="fa fa-dashboard"></i> <span>Clients</span> <span class="caret"></span></a>

            <ul class="dropdown-menu" role="menu">
                <li><a href="{{route('system.client')}}" title="All Clients"><i class="fa fa-circle-o"></i> View
                        All</a></li>
                <li><a href="{{route('system.client.add')}}" title="Add Client"><i class="fa fa-circle-o"></i>
                        Add</a></li>
            </ul>
        </li>
    @endif

    @if($current_user->role != 4)
    <li class="dropdown {{ $controller =='ApplicationController' ? 'active' : '' }}">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dashboard"></i>
            <span>Applications</span> <span class="caret"></span></a>

        <ul class="dropdown-menu" role="menu">
            <li><a href="{{route('system.application')}}" title="All Applications"><i class="fa fa-circle-o"></i> View
                    All</a></li>
            @if($current_user->role == 2)
                <li><a href="{{route('system.application.accepted')}}" title="Accepted Applications"><i
                                class="fa fa-circle-o"></i> Accepted Applications</a></li>
                <li><a href="{{route('system.application.pending')}}" title="Pending Applications"><i
                                class="fa fa-circle-o"></i> Pending Applications</a></li>
            @endif
        </ul>
    </li>
    @endif

    @if($current_user->role == 2) {{--admin--}}
    <li class="dropdown {{ $controller =='LenderController' ? 'active' : '' }}">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dashboard"></i>
            <span>Lenders</span> <span class="caret"></span></a>

        <ul class="dropdown-menu" role="menu">
            <li><a href="{{route('system.lender')}}" title="All Lenders"><i class="fa fa-circle-o"></i> View
                    All</a></li>
            <li><a href="{{route('system.lender.add')}}" title="Add Lender"><i class="fa fa-circle-o"></i>
                    Add</a></li>
        </ul>
    </li>
    @endif

    @if($current_user->role == 1) {{-- Super Admin--}}
    <li class="dropdown {{ $controller =='UserController' ? 'active' : '' }}">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dashboard"></i>
            <span>Users</span> <span class="caret"></span></a>

        <ul class="dropdown-menu" role="menu">
            <li><a href="{{route('system.user')}}" title="All Users"><i class="fa fa-circle-o"></i> View
                    All</a></li>
            <li><a href="{{route('system.user.add')}}" title="Add User"><i class="fa fa-circle-o"></i>
                    Add</a></li>
        </ul>
    </li>
    @endif

    {{-- Check for marketing only --}}
    <li class="{{ $controller =='ReportController' ? 'active' : '' }}">
        <a href="{{url('system/report')}}" title="Reports Marketing">
            <i class="fa fa-file-text"></i> <span>Reports</span>
        </a>
    </li>

    @if($current_user->role == 1) {{-- Super Admin --}}
    <li class="dropdown {{ $controller =='SettingController' ? 'active' : '' }}">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dashboard"></i>
            <span>Settings</span> <span class="caret"></span></a>

        <ul class="dropdown-menu" role="menu">
            <li><a href="{{route('system.setting.email')}}" title="Emails"><i class="fa fa-circle-o"></i> Emails</a>
            </li>
            <li><a href="{{route('system.setting.template')}}" title="Templates"><i class="fa fa-circle-o"></i>
                    Templates</a></li>
        </ul>
    </li>
    @endif
</ul>

{{--
<div id="app-content" class="content-wrapper">--}}
