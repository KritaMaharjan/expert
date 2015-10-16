@extends('system.layouts.main')
@section('title')
    Application
@stop
@section('heading')
    Application
@stop

@section('breadcrumb')
    @parent
    <li><a href="{{url('system/application/accepted')}}">Application</a></li>
    <li>View</li>
@stop

@section('content')

    <div class="box box-solid">
        @include('system.application.overview.steps')
        @include('system.application.overview.general')
        @include('system.application.overview.lead')
        @include('system.application.overview.attachment')
        @include('system.application.overview.logs')
        <div class="box-footer">
            <input class="btn btn-primary" Type="button" VALUE="Back" onClick="history.go(-1);return true;">
        </div>
    </div>
@stop