<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="" class="navbar-brand"><strong>Expert</strong></a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <div class="navbar-collapse pull-left collapse" id="navbar-collapse" aria-expanded="false"
                 style="height: 1px;">
                @include('system.layouts.partials.navbar')
            </div>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="">{{$current_user->given_name . ' ' . $current_user->surname}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{route('system.user.profile')}}" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{route('system.logout')}}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
</header>

<div id="app-content" class="content-wrapper">