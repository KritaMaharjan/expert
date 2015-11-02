@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Other Entities - Applications
@stop

@section('breadcrumb')
    @parent
    <li>Applications</li>
    <li>Other Entities</li>
@stop

@section('content')
    @include('system.application.steps')
    <div class="row">
        {!!Form::open(['class' => 'form-horizontal'])!!}
        <div class="col-xs-12 mainContainer">
            @include('flash::message')

            {{-- Car Details --}}
            @include('system.application.other.car')

            {{-- Bank Accounts --}}
            @include('system.application.other.bank')

            {{-- Other Assets --}}
            @include('system.application.other.assets')

            {{-- Credit Card Details --}}
            @include('system.application.other.card')

            {{-- Expense Details --}}
            @include('system.application.expense.main')

            {{-- Income Details --}}
            @include('system.application.income.main')

            {{-- Other Income Details --}}
            @include('system.application.other.income')

        </div>
        {!!Form::close()!!}
    </div>
    {{ EX::js('assets/js/application/other.js') }}
@stop