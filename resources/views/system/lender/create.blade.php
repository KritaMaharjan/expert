@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Add Lender
@stop

@section('breadcrumb')
    @parent
    <li>Lender</li>
    <li>Add</li>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            {!!Form::open(['class' => 'form-horizontal'])!!}
            <div class="row">
                <div class="box box-primary">
                    @include('system.lender.form')
                    <div class="box-footer col-lg-12 clear-both">
                        <input type="submit" class="btn btn-primary" value="Add Lender"/>
                    </div>
                </div>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop