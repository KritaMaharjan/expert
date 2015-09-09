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

@if($current_user->first_time === 1)
	@include('tenant.dashboard.onboarding')
@endif

@stop