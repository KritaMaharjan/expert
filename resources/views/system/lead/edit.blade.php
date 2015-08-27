@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Update Lead
@stop

@section('breadcrumb')
    @parent
    <li>Lead</li>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="box box-solid">
                <div class="box box-body">
                    @include('system.lead.formEdit')
                </div>
            </div>
        </div>
    </div>
@stop
