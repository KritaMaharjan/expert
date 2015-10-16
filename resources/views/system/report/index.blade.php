@extends('system.layouts.main')

@section('heading')
    Reports
@stop

@section('breadcrumb')
    @parent
    <li>Reports</li>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="box box-solid">
                <div class="box-body">
                    
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
@stop