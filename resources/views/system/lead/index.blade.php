@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Leads
@stop

@section('breadcrumb')
    @parent
    <li>Leads</li>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="box box-solid">
                <p class="align-right btn-inside">
                    <a class="btn btn-primary" href="{{route('system.lead.add')}}">
                        <i class="fa fa-plus"></i> Add new lead
                    </a>
                </p>
                <div class="box-body table-responsive">
                    <table id="table-lead" class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client Name</th>
                            <th>Email</th>
                            <th>Loan Amount</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
    {{EX::js('assets/js/lead/lead.js')}}

@stop