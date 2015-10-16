@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Update Lender
@stop

@section('breadcrumb')
    @parent
    <li>Lenders</li>
    <li>Update</li>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="box box-solid">
                {!!Form::model($lender, ['class' => 'form-horizontal'])!!}
                <div class="row">
                    <div class="box box-primary">
                        @include('system.lender.form')
                        <div class="box-footer col-lg-12 clear-both">
                            <input type="submit" class="btn btn-primary" value="Update"/>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
@stop
