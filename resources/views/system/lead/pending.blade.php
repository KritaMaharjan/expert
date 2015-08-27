@extends('system.layouts.main')

@section('heading')
    Pending Leads
@stop

@section('content')
    @include('system.lead.pendingTable')
@stop