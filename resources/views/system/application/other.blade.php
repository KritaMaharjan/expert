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
        @include('flash::message')
        {!!Form::open(['class' => 'form-horizontal'])!!}
        <div class="col-xs-12 mainContainer">
            @include('flash::message')

            {{-- Car Details --}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Car Details</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Any Cars?') !!}</div>
                        <div class='col-md-6'>
                            <label>{!! Form::radio('cars', 1) !!} Yes</label>
                            <label>{!! Form::radio('cars', 0, true) !!} No</label>
                        </div>
                    </div>

                    <div class="car-details" style="display:none">
                        <div class="new-car">
                            <h2>Car <span class="car-num">1</span> Details</h2>
                            <hr/>
                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Added this by mistake?') !!}</div>
                                <div class='col-md-6'>
                                    <button type="button" class="btn btn-danger remove-car">Remove this car</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Ownership') !!}</div>
                                <div class='col-md-6'>
                                    <select name="car_applicant_id[]" class="form-control">
                                        @foreach($applicants as $key => $applicant)
                                            <option value="{{$key}}">{{$applicant}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('make_model')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Make & Model') !!}</div>
                                <div class='col-md-6'>
                                    <input name="make_model[]" class="form-control" />
                                    @if($errors->has('make_model'))
                                        {!! $errors->first('make_model', '<label class="control-label"
                                                                                 for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('year_built')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Year Built') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" class="form-control" name="year_built[]">
                                    @if($errors->has('year_built'))
                                        {!! $errors->first('year_built', '<label class="control-label"
                                                                                 for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('value')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Value') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" class="form-control" name="value[]">
                                    @if($errors->has('value'))
                                        {!! $errors->first('value', '<label class="control-label"
                                                                            for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Car Loan') !!}</div>
                                <div class='col-md-6'>
                                    <label><input type="radio" class="car_loan" name="car_loan[]" value=1 /> Yes</label>
                                    <label><input type="radio" class="car_loan" name="car_loan[]" value=0 checked="checked" /> No</label>
                                </div>
                            </div>

                            <div class="car-loan-details">
                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('To Be Cleared') !!}</div>
                                    <div class='col-md-6'>
                                        <label><input type="radio" class="car_to_be_cleared" name="to_be_cleared[]" value=1 checked="checked" /> Yes</label>
                                        <label><input type="radio" class="car_to_be_cleared" name="to_be_cleared[]" value=0 /> No</label>
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('lender')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Lender') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="lender[]">
                                        @if($errors->has('lender'))
                                            {!! $errors->first('lender', '<label class="control-label"
                                                                                 for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('debit_from')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Debit From') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="debit_from[]">
                                        @if($errors->has('debit_from'))
                                            {!! $errors->first('debit_from', '<label class="control-label"
                                                                                     for="inputError">:message</label>
                                            ')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('limit')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Limit') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="limit[]">
                                        @if($errors->has('limit'))
                                            {!! $errors->first('limit', '<label class="control-label"
                                                                                for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('balance')) {{'has-error'}} @endif balance">
                                <div class='col-md-2 control-label'>{!!Form::label('Balance') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" class="form-control" name="balance[]">
                                    @if($errors->has('balance'))
                                        {!! $errors->first('balance', '<label class="control-label"
                                                                              for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="add-car-div">
                            <hr/>
                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Add up to ten cars') !!}</div>
                                <div class='col-md-6'>
                                    <button type="button" class="btn btn-success add-car">Add a Car</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Bank Accounts --}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Bank Accounts</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Any Bank Accounts?') !!}</div>

                        <div class='col-md-6'>
                            <label>{!! Form::radio('banks', 1) !!} Yes</label>
                            <label>{!! Form::radio('banks', 0, true) !!} No</label>
                        </div>
                    </div>

                    <div class="bank-details" style="display:none">
                        <div class="new-bank">
                            <h2>Bank <span class="bank-num">1</span> Details</h2>
                            <hr/>
                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Added this by mistake?') !!}</div>
                                <div class='col-md-6'>
                                    <button type="button" class="btn btn-danger remove-bank">Remove this account
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Ownership') !!}</div>
                                <div class='col-md-6'>
                                    <select name="bank_applicant_id[]" class="form-control">
                                        @foreach($applicants as $key => $applicant)
                                            <option value="{{$key}}">{{$applicant}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('bank')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Bank') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" class="form-control" name="bank[]">
                                    @if($errors->has('bank'))
                                        {!! $errors->first('bank', '<label class="control-label"
                                                                           for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('balance')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('balance') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" class="form-control" name="bank_balance[]">
                                    @if($errors->has('balance'))
                                        {!! $errors->first('balance', '<label class="control-label"
                                                                              for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="add-bank-div">
                            <hr/>
                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Add up to ten accounts') !!}</div>
                                <div class='col-md-6'>
                                    <button type="button" class="btn btn-success add-bank">Add a Bank Account</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Other Assets --}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Other Assets</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Any Other Assets?') !!}</div>
                        <div class='col-md-6'>
                            <label>{!! Form::radio('assets', 1) !!} Yes</label>
                            <label>{!! Form::radio('assets', 0, true) !!} No</label>
                        </div>
                    </div>

                    <div class="asset-details" style="display:none">
                        <div class="new-asset">
                            <h2>Asset <span class="asset-num">1</span> Details</h2>
                            <hr/>
                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Added this by mistake?') !!}</div>
                                <div class='col-md-6'>
                                    <button type="button" class="btn btn-danger remove-asset">Remove this asset
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Ownership') !!}</div>
                                <div class='col-md-6'>
                                    <select name="other_applicant_id[]" class="form-control">
                                        @foreach($applicants as $key => $applicant)
                                            <option value="{{$key}}">{{$applicant}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('type')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Type') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" class="form-control" name="other_type[]">
                                    @if($errors->has('type'))
                                        {!! $errors->first('type', '<label class="control-label"
                                                                           for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('value')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Value') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" class="form-control" name="other_value[]">
                                    @if($errors->has('value'))
                                        {!! $errors->first('value', '<label class="control-label"
                                                                            for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('home_content')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Home Content') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" class="form-control" name="home_content[]">
                                    @if($errors->has('home_content'))
                                        {!! $errors->first('home_content', '<label class="control-label"
                                                                                   for="inputError">:message</label>')
                                        !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('superannuation')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Superannuation') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" class="form-control" name="superannuation[]">
                                    @if($errors->has('superannuation'))
                                        {!! $errors->first('superannuation', '<label class="control-label"
                                                                                     for="inputError">:message</label>')
                                        !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('deposit_paid')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Deposit Paid') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" class="form-control" name="deposit_paid[]">
                                    @if($errors->has('deposit_paid'))
                                        {!! $errors->first('deposit_paid', '<label class="control-label"
                                                                                   for="inputError">:message</label>')
                                        !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="add-asset-div">
                            <hr/>
                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Add up to ten assets') !!}</div>
                                <div class='col-md-6'>
                                    <button type="button" class="btn btn-success add-asset">Add a Asset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Credit Card Details --}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Credit Card Details</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Any Credit Card?') !!}</div>
                        <div class='col-md-6'>
                            <label>{!! Form::radio('cards', 1) !!} Yes</label>
                            <label>{!! Form::radio('cards', 0, true) !!} No</label>
                        </div>
                    </div>

                    <div class="card-details" style="display:none">
                        <div class="new-card">
                            <h2>Credit Card <span class="card-num">1</span> Details</h2>
                            <hr/>
                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Added this by mistake?') !!}</div>
                                <div class='col-md-6'>
                                    <button type="button" class="btn btn-danger remove-card">Remove this card
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Ownership') !!}</div>
                                <div class='col-md-6'>
                                    <select name="card_applicant_id[]" class="form-control">
                                        @foreach($applicants as $key => $applicant)
                                            <option value="{{$key}}">{{$applicant}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group card_types">
                                <div class="field">
                                    <div class='col-md-2 control-label'>{!!Form::label('Credit Card Type') !!}</div>
                                    <div class='col-md-6'>
                                    <select name="card_type[]" class="form-control card_type">
                                            @foreach(config('general.credit_card_type') as $key => $type)
                                                <option value="{{$key}}">{{$type}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            <div class="field other-name" style="display: none">
                                    <div class="col-md-2">&nbsp;</div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control others_text" name="others[]">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group others">
                                <div class='col-md-2 control-label'>{!!Form::label('To Be Cleared') !!}</div>
                                <div class='col-md-6'>
                                    <label><input type="radio" class="card_to_be_cleared" name="card_to_be_cleared[]" value=1 checked="checked" /> Yes</label>
                                    <label><input type="radio" class="card_to_be_cleared" name="card_to_be_cleared[]" value=0 /> No</label>
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('lender')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Lender') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" class="form-control" name="card_lender[]">
                                    @if($errors->has('lender'))
                                        {!! $errors->first('lender', '<label class="control-label"
                                                                             for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('debit_from')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Debit From') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" class="form-control" name="card_debit_from[]">
                                    @if($errors->has('debit_from'))
                                        {!! $errors->first('debit_from', '<label class="control-label"
                                                                                 for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('limit')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Limit') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" class="form-control" name="card_limit[]">
                                    @if($errors->has('limit'))
                                        {!! $errors->first('limit', '<label class="control-label"
                                                                            for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('balance')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Balance') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" class="form-control" name="card_balance[]">
                                    @if($errors->has('balance'))
                                        {!! $errors->first('balance', '<label class="control-label"
                                                                              for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="add-card-div">
                            <hr/>
                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Add up to ten cards') !!}</div>
                                <div class='col-md-6'>
                                    <button type="button" class="btn btn-success add-card">Add a Credit Card</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Other Income Details --}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Other Income</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Any Other Income?') !!}</div>
                        <div class='col-md-6'>
                            <label>{!! Form::radio('incomes', 1) !!} Yes</label>
                            <label>{!! Form::radio('incomes', 0, true) !!} No</label>
                        </div>
                    </div>

                    <div class="income-details" style="display:none">
                        <div class="new-income">
                            <h2>Other Income <span class="income-num">1</span> Details</h2>
                            <hr/>
                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Added this by mistake?') !!}</div>
                                <div class='col-md-6'>
                                    <button type="button" class="btn btn-danger remove-income">Remove this income
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Ownership') !!}</div>
                                <div class='col-md-6'>
                                    <select name="income_applicant_id[]" class="form-control">
                                        @foreach($applicants as $key => $applicant)
                                            <option value="{{$key}}">{{$applicant}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('type')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Type') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" class="form-control" name="income_type[]">
                                    @if($errors->has('type'))
                                        {!! $errors->first('type', '<label class="control-label"
                                                                           for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('credit_to')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Credit To') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" class="form-control" name="income_credit_to[]">
                                    @if($errors->has('credit_to'))
                                        {!! $errors->first('credit_to', '<label class="control-label"
                                                                                for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('monthly_net_income')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Monthly Net Income') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" class="form-control" name="monthly_net_income[]">
                                    @if($errors->has('monthly_net_income'))
                                        {!! $errors->first('monthly_net_income', '<label class="control-label"
                                                                                         for="inputError">:message</label>
                                        ')!!}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="add-income-div">
                            <hr/>
                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Add up to ten incomes') !!}</div>
                                <div class='col-md-6'>
                                    <button type="button" class="btn btn-success add-income">Add Income</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer col-lg-12 clear-both">
                    <input type="submit" class="btn btn-primary" value="Next"/>
                </div>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
    {{ EX::js('assets/js/application/other.js') }}
@stop