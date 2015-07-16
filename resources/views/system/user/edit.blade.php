@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Update Client
@stop

@section('breadcrumb')
    @parent
    <li>Clients</li>
    <li>Update</li>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="box box-solid">
                {!!Form::model($product)!!}
                    @include('system.user.form')
                    <div class="box-footer col-lg-6 clear-both">
                        <input type="submit" class="btn btn-primary" value="Update" />
                    </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
@stop
