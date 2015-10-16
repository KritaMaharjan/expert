@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Assign Lender
@stop

@section('breadcrumb')
    @parent
    <li>Lender</li>
    <li>Assign</li>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Application Details</h3>
                        </div>
                        <div class="box-body">
                            <ul class="list-unstyled">
                                <li><strong>{{ $application->given_name .' '. $application->surname }}</strong></li>
                                <li><strong>Preferred Name:</strong> {{ $application->preferred_name }}</li>
                                <li><strong>Current Phone Number:</strong> {{ $application->current_phone }}</li>
                                <li><strong>Loan Type:</strong> {{ $application->loan_type }}</li>
                                <li><strong>Loan Purpose:</strong> {{ $application->loan_purpose }}</li>
                                <li><strong>Referral Notes:</strong> {{ $application->referral_notes }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Assign Form --}}
                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Assign Loan</h3>
                        </div>
                        {!!Form::open()!!}
                        <div class="box-body">
                            <div class="form-group @if($errors->has('lender_id')) {{'has-error'}} @endif">
                                {!!Form::label('Assign To') !!}
                                {!!Form::select('lender_id', $lender, null, array('class' => 'form-control'))!!}
                                @if($errors->has('lender_id'))
                                    {!! $errors->first('lender_id', '<label class="control-label"
                                                                                for="inputError">:message</label>') !!}
                                @endif
                            </div>
                            <div class="form-group @if($errors->has('description')) {{'has-error'}} @endif">
                                {!!Form::label('Description') !!}
                                {!!Form::textarea('description','',array('class' => 'form-control'))!!}
                                @if($errors->has('description'))
                                    {!! $errors->first('description', '<label class="control-label"
                                                                           for="inputError">:message</label>') !!}
                                @endif
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Assign Now"/>
                        </div>
                        {!!Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

{{ EX::js("$('.date-picker').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});") }}
