@extends('system.layouts.main')

@section('heading')
    Pending Applications
@stop

@section('content')
    @include('system.application.pendingTable')
@stop