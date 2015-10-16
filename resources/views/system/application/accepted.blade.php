@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Accepted Applications
@stop

@section('breadcrumb')
    @parent
    <li>Applications</li>
    <li>Accepted</li>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="box box-solid">
                <div class="box-body table-responsive">
                    <table id="table-lead" class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client Name</th>
                            <th>Email</th>
                            <th>Loan Type</th>
                            <th>Assigned Lender</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
    {{EX::js('assets/js/application/accepted.js')}}

@stop