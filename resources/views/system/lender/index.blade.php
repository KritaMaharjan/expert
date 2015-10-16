@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Lenders
@stop

@section('breadcrumb')
    @parent
    <li>Lenders</li>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="box box-solid">
                <p class="align-right btn-inside">
                    <a class="btn btn-primary" href="{{route('system.lender.add')}}">
                        <i class="fa fa-plus"></i> Add new lender
                    </a>
                </p>
                <div class="box-body table-responsive">
                    <table id="table-lender" class="table table-hover table-bill">
                        <thead>
                        <tr>
                            <th>Lender ID</th>
                            <th>Company Name</th>
                            <th>Contact Name</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
    {{EX::js('assets/js/lender/index.js')}}

@stop