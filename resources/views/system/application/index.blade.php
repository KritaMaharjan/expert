@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Applications
@stop

@section('breadcrumb')
    @parent
    <li>Applications</li>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="box box-solid">
                <div class="box-body table-responsive">
                    <table id="table-application" class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Created By</th>
                            <th>Lead ID</th>
                            <th>Submitted</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
    {{EX::js('assets/js/application/index.js')}}

@stop