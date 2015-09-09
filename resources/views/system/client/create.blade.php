@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Add Client
@stop

@section('breadcrumb')
    @parent
    <li>Clients</li>
    <li>Add</li>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            {{--<div class="box box-solid col-lg-12">--}}
                {!!Form::open()!!}
                    @include('system.client.form')
                    <div class="box-footer col-lg-12 clear-both">
                        <input type="submit" class="btn btn-primary" value="Add Client" />
                    </div>
                {!!Form::close()!!}
            {{--</div>--}}
        </div>
    </div>
    {{EX::js('assets/js/client/client-form.js')}}
@stop