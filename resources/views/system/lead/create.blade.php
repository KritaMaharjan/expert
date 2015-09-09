@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Add Lead
@stop

@section('breadcrumb')
    @parent
    <li>Lead</li>
    <li>Add</li>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="box box-solid">
                {{--<div class="box box-solid col-lg-12">--}}
                <div class="box box-body">
                    @include('system.lead.form')
                </div>
            </div>
            {{--</div>--}}
        </div>
    </div>
@stop