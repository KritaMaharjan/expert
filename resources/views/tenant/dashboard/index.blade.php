@extends('tenant.layouts.main')

@section('heading')
Dashboard
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
                Dashboard
        </div>
    <div>

@if($first_time == TRUE)
	@include('tenant.dashboard.onboarding')
@endif

@stop