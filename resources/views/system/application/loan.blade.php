@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Loans - Applications
@stop

@section('breadcrumb')
    @parent
    <li>Applications</li>
    <li>Loans</li>
@stop

@section('content')

    @include('system.application.steps')
    <div class="row">
        @include('flash::message')
        {!!Form::open(['class' => 'form-horizontal'])!!}
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Loans</h3>
                </div>

                <div class="box-body loan-details">
                    <div class="new-loan">
                        <div class="box no-border">
                            <div class="box-header with-border">
                                <h3 class="box-title">Loan <span class="loan-num">1</span> Details</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="form-group remove-block">
                                    <div class='col-md-2 control-label'>{!!Form::label('Added this by mistake?') !!}</div>
                                    <div class='col-md-6'>
                                        <button type="button" class="btn btn-danger remove-loan">Remove this
                                            loan
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('amount')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Amount') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" name="amount[]" class="form-control"/>
                                        @if($errors->has('amount'))
                                            {!! $errors->first('amount', '<label class="control-label"
                                                                                       for="inputError">:message</label>') !!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Loan Purpose') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="loan_purpose[]" class="form-control">
                                            @foreach(config('general.new_loan_purpose') as $key => $purpose)
                                                <option value="{{$key}}">{{$purpose}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('deposit_paid')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Deposit Paid') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" name="deposit_paid[]" class="form-control"/>
                                        @if($errors->has('deposit_paid'))
                                            {!! $errors->first('deposit_paid', '<label class="control-label"
                                                                                     for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group clearfix {{ ($errors->has('settlement_date'))? 'has-error': '' }}">
                                    <div class='col-md-2 control-label'>{!! Form::label('Settlement Date') !!}</div>
                                    <div class='col-md-6'>
                                        <div id="settlement_date" class="input-group date">
                                            {!! Form:: text('settlement_date', null, array('class' => 'form-control
                                            expiry_date')) !!}
                                            <span class="input-group-addon"><span
                                                        class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                        @if($errors->has('settlement_date'))
                                            {!! $errors->first('settlement_date', '<label class="control-label"
                                                                                                 for="inputError">:message</label>
                                            ') !!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Loan Usage') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="loan_usage[]" class="form-control">
                                            @foreach(config('general.loan_usage') as $key => $usage)
                                                <option value="{{$key}}">{{$usage}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('total_loan_term')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Total loan term') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" name="total_loan_term[]" class="form-control"/>
                                        @if($errors->has('total_loan_term'))
                                            {!! $errors->first('total_loan_term', '<label class="control-label"
                                                                               for="inputError">:message</label>') !!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Loan Type') !!}</div>
                                    <div class='col-md-6'>
                                        <label><input type="radio" name="loan_type[]" value='variable'
                                                      checked="checked" class="loan_type"/>
                                            Variable</label>
                                        <label><input type="radio" name="loan_type[]" value='fixed' class="loan_type"/> Fixed</label>
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('fixed_rate_term')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Fixed Rate Terms') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" name="fixed_rate_term[]" class="form-control"/>
                                        @if($errors->has('fixed_rate_term'))
                                            {!! $errors->first('fixed_rate_term', '<label class="control-label"
                                                                                            for="inputError">:message</label>') !!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Repayment Type') !!}</div>
                                    <div class='col-md-6'>
                                        <label><input type="radio" name="repayment_type[]" value='IO'
                                                      checked="checked" class="repayment_type"/>
                                            IO</label>
                                        <label><input type="radio" name="repayment_type[]" value='P&I' class="repayment_type"/> P&I</label>
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('io_term')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('IO Term') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" name="io_term[]" class="form-control"/>
                                        @if($errors->has('io_term'))
                                            {!! $errors->first('io_term', '<label class="control-label"
                                                                                            for="inputError">:message</label>') !!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('interest_rate')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Interest rate') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" name="interest_rate[]" class="form-control"/>
                                        @if($errors->has('interest_rate'))
                                            {!! $errors->first('interest_rate', '<label class="control-label"
                                                                                            for="inputError">:message</label>') !!}
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="add-loan-div">
                        <hr/>
                        <div class="form-group">
                            <div class='col-md-2 control-label'>{!!Form::label('Add up to ten properties') !!}</div>
                            <div class='col-md-6'>
                                <button type="button" class="btn btn-success add-loan">Add an Loan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!!Form::submit('Add Loan', ['class' => 'btn btn-primary'])!!}
                </div>
            </div>

        </div>
        {!!Form::close()!!}
    </div>
    {{ EX::js('assets/js/application/loan.js') }}
@stop