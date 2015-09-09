@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Clients
@stop

@section('breadcrumb')
    @parent
    <li>Clients</li>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="box box-solid">
                <p class="align-right btn-inside">
                    <a class="btn btn-primary" href="{{route('system.client.add')}}">
                        <i class="fa fa-plus"></i> Add new client
                    </a>
                </p>
                <div class="box-body table-responsive">
                    <table id="table-client" class="table table-hover table-bill">
                        <thead>
                        <tr>
                            <th>Preferred Name</th>
                            <th>Full Name</th>
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
    {{EX::js('assets/js/system/client.js')}}

@stop