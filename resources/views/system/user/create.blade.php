@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Add User
@stop

@section('breadcrumb')
    @parent
    <li>Users</li>
    <li>Add</li>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            {{--<div class="box box-solid col-lg-12">--}}
                {!!Form::open()!!}
                    @include('system.user.form')
                    <div class="box-footer col-lg-12 clear-both">
                        <input type="submit" class="btn btn-primary" value="Add User" />
                    </div>
                {!!Form::close()!!}
            {{--</div>--}}
        </div>
    </div>
@stop