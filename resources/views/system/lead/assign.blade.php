@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Assign Lead
@stop

@section('breadcrumb')
    @parent
    <li>Lead</li>
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
                            <h3 class="box-title">Loan Details</h3>
                        </div>
                        <div class="box-body">
                            <ul class="list-unstyled">
                                <li><strong>{{ get_client_name($lead->ex_clients_id) }}</strong></li>
                                <li><strong>Loan Amount:</strong> {{ $lead->loan->amount }}</li>
                                <li><strong>Due Date:</strong> {{ $lead->loan->interest_date_till }}</li>
                                <li><strong>Loan Type:</strong> {{ $lead->loan->loan_type }}</li>
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
                            <div class="form-group @if($errors->has('assign_to')) {{'has-error'}} @endif">
                                {!!Form::label('Assign To') !!}
                                {!!Form::select('assign_to', $sales_people, null, array('class' => 'form-control'))!!}
                                @if($errors->has('assign_to'))
                                    {!! $errors->first('assign_to', '<label class="control-label"
                                                                                for="inputError">:message</label>') !!}
                                @endif
                            </div>
                            <div class="form-group clearfix {{ ($errors->has('meeting_datetime'))? 'has-error': '' }}">
                                {!! Form::label('Meeting Time/Date') !!}
                                <div id="due_date" class="input-group date">
                                    {!! Form:: text('meeting_datetime', null, array('class' => 'form-control date-picker')) !!}
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                </div>
                                @if($errors->has('meeting_datetime'))
                                    {!! $errors->first('meeting_datetime', '<label class="control-label"
                                                                                     for="inputError">:message</label>') !!}
                                @endif
                            </div>
                            <div class="form-group @if($errors->has('meeting_place')) {{'has-error'}} @endif">
                                {!!Form::label('Meeting Place') !!}
                                {!!Form::text('meeting_place','',array('class' => 'form-control'))!!}
                                @if($errors->has('meeting_place'))
                                    {!! $errors->first('meeting_place', '<label class="control-label"
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

{{ EX::js("$('.date-picker').datepicker({format: 'yyyy-mm-dd', startDate: new Date()});") }}
