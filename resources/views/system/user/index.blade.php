@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Users
@stop

@section('breadcrumb')
    @parent
    <li>Users</li>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="box box-solid">
                <p class="align-right btn-inside">
                    <a class="btn btn-primary" href="{{route('system.user.add')}}">
                        <i class="fa fa-plus"></i> Add new user
                    </a>
                </p>
                <div class="box-body table-responsive">
                    <table id="table-user" class="table table-hover table-bill">
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>User role</th>
                            <th>Email</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
    {{EX::js('assets/js/user/user.js')}}

@stop