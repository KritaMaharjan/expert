@extends('system.layouts.main')

@section('heading')
    Dashboard
@stop

@section('content')

    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-file-text"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Applications</span>
                    <span class="info-box-number">0</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-thumbs-up"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Loan Approval</span>
                    <span class="info-box-number">0</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Processed Leads</span>
                    <span class="info-box-number">760</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Unprocessed Leads</h3>

                    <div class="box-tools pull-right">
                        <a class="btn btn-primary" href="{{route('system.lead.add')}}"><i class="fa fa-plus"></i> Add Lead</a>
                    </div>
                </div>
                <div class="box-body">
                    <table id="table-lead" class="table table-hover table-bill">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client Name</th>
                            <th>Preferred Name</th>
                            <th>Client ID</th>
                            <th>Phone Number</th>
                            <th>Loan Type</th>
                            <th>Meeting Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{EX::js('assets/js/dashboard/dashboard.js')}}
@stop