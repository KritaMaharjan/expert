@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Income Details - Applications
@stop

@section('breadcrumb')
    @parent
    <li>Applications</li>
    <li>Income Details</li>
@stop

@section('content')
    @include('system.application.steps')
    <div class="row">
        @include('flash::message')
        {!!Form::open(['class' => 'form-horizontal'])!!}
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            {{-- Income Details --}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Income Details</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Any Income?') !!}</div>
                        <div class='col-md-6'>
                            <label>{!! Form::radio('income', 1) !!} Yes</label>
                            <label>{!! Form::radio('income', 0, true) !!} No</label>
                        </div>
                    </div>

                    <div class="income-details" style="display:none">
                        <div class="new-income">
                            <h2>Current Employment <span class="income-num">1</span> Details</h2>
                            <hr/>
                            Employment Income
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
                                    <select name="applicant_id[]" class="form-control">
                                        @foreach($applicants as $key => $applicant)
                                            <option value="{{$key}}">{{$applicant}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('annual_gross_income')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Annual Gross Income') !!}</div>
                                <div class='col-md-6'>
                                    <input name="annual_gross_income[]" class="form-control"/>
                                    @if($errors->has('annual_gross_income'))
                                        {!! $errors->first('annual_gross_income', '<label class="control-label"
                                                                                 for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Pay Frequency') !!}</div>
                                <div class='col-md-6'>
                                    <select name="pay_frequency[]" class="form-control">
                                        @foreach(config('general.pay_frequency') as $key => $type)
                                            <option value="{{$key}}">{{$type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Salary Crediting') !!}</div>
                                <div class='col-md-6'>
                                    <label><input type="radio" name="salary_crediting[]" value=1 checked="checked"/> Yes</label>
                                    <label><input type="radio" name="salary_crediting[]" value=0"> No</label>
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('credit_to_where')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Credits to Where') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="credit_to_where[]" class="form-control"/>
                                    @if($errors->has('credit_to_where'))
                                        {!! $errors->first('credit_to_where', '<label class="control-label"
                                                                                 for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group clearfix {{ ($errors->has('latest_pay_date'))? 'has-error': '' }}">
                                <div class='col-md-2 control-label'>{!! Form::label('Latest Pay Date') !!}</div>
                                <div class='col-md-6'>
                                    <div id="latest_pay_date" class="input-group date">
                                        {!! Form:: text('latest_pay_date[]', null, array('class' => 'form-control date-picker')) !!}
                                        <span class="input-group-addon"><span
                                                    class="glyphicon glyphicon-calendar"></span>
                                </span>
                                    </div>
                                    @if($errors->has('latest_pay_date'))
                                        {!! $errors->first('latest_pay_date', '<label class="control-label"
                                                                          for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group clearfix {{ ($errors->has('latest_payslip_period_from'))? 'has-error': '' }}">
                                <div class='col-md-2 control-label'>{!! Form::label('Latest Payslip Period From') !!}</div>
                                <div class='col-md-6'>
                                    <div id="payslip_from" class="input-group date">
                                        {!! Form:: text('latest_payslip_period_from[]', null, array('class' => 'form-control date-picker')) !!}
                                        <span class="input-group-addon"><span
                                                    class="glyphicon glyphicon-calendar"></span>
                                </span>
                                    </div>
                                    @if($errors->has('latest_payslip_period_from'))
                                        {!! $errors->first('latest_payslip_period_from', '<label class="control-label"
                                                                          for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group clearfix {{ ($errors->has('latest_payslip_period_to'))? 'has-error': '' }}">
                                <div class='col-md-2 control-label'>{!! Form::label('Latest Payslip Period To') !!}</div>
                                <div class='col-md-6'>
                                    <div id="payslip_to" class="input-group date">
                                        {!! Form:: text('latest_payslip_period_to[]', null, array('class' => 'form-control date-picker')) !!}
                                        <span class="input-group-addon"><span
                                                    class="glyphicon glyphicon-calendar"></span>
                                </span>
                                    </div>
                                    @if($errors->has('latest_payslip_period_to'))
                                        {!! $errors->first('latest_payslip_period_to', '<label class="control-label"
                                                                          for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                            Employment Details
                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Employment Type') !!}</div>
                                <div class='col-md-6'>
                                    <select name="employment_type[]" class="form-control">
                                        @foreach(config('general.employment_type') as $key => $type)
                                            <option value="{{$key}}">{{$type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('job_title')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Job Title') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="job_title[]" class="form-control"/>
                                    @if($errors->has('job_title'))
                                        {!! $errors->first('job_title', '<label class="control-label"
                                                                                 for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group clearfix {{ ($errors->has('starting_date'))? 'has-error': '' }}">
                                <div class='col-md-2 control-label'>{!! Form::label('Starting Date') !!}</div>
                                <div class='col-md-6'>
                                    <div id="starting_date" class="input-group date">
                                        {!! Form:: text('starting_date[]', null, array('class' => 'form-control date-picker')) !!}
                                        <span class="input-group-addon"><span
                                                    class="glyphicon glyphicon-calendar"></span>
                                </span>
                                    </div>
                                    @if($errors->has('starting_date'))
                                        {!! $errors->first('starting_date', '<label class="control-label"
                                                                          for="inputError">:message</label>') !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('business_name')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Employer Business Name') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="business_name[]" class="form-control"/>
                                    @if($errors->has('business_name'))
                                        {!! $errors->first('business_name', '<label class="control-label"
                                                                                 for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('abn')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Employer ABN') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="abn[]" class="form-control"/>
                                    @if($errors->has('abn'))
                                        {!! $errors->first('abn', '<label class="control-label"
                                                                                 for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            Current Employer address
                            <div class="form-group @if($errors->has('line1')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Line 1') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="line1[]" class="form-control"/>
                                    @if($errors->has('line1'))
                                        {!! $errors->first('line1', '<label class="control-label"
                                                                            for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('line2')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Line 2') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="line2[]" class="form-control"/>
                                    @if($errors->has('line2'))
                                        {!! $errors->first('line2', '<label class="control-label"
                                                                            for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('suburb')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Suburb') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="suburb[]" class="form-control"/>
                                    @if($errors->has('suburb'))
                                        {!! $errors->first('suburb', '<label class="control-label"
                                                                             for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('State') !!}</div>
                                <div class='col-md-6'>
                                    <select name="state[]" class="form-control">
                                        @foreach(config('general.state') as $key => $type)
                                            <option value="{{$key}}">{{$type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('postcode')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Postcode') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="postcode[]" class="form-control"/>
                                    @if($errors->has('postcode'))
                                        {!! $errors->first('postcode', '<label class="control-label"
                                                                               for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Country') !!}</div>
                                <div class='col-md-6'>
                                    <select name="country[]" class="form-control">
                                        @foreach(config('general.countries') as $key => $type)
                                            <option value="{{$key}}">{{$type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('contact_person')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Contact Person') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="contact_person[]" class="form-control"/>
                                    @if($errors->has('contact_person'))
                                        {!! $errors->first('contact_person', '<label class="control-label"
                                                                                     for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('contact_person_job_title')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Contact Person Job Title') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="contact_person_job_title[]" class="form-control"/>
                                    @if($errors->has('contact_person_job_title'))
                                        {!! $errors->first('contact_person_job_title', '<label class="control-label"
                                                                                               for="inputError">:message</label>
                                        ')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('contact_number')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Contact Number') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="contact_number[]" class="form-control"/>
                                    @if($errors->has('contact_number'))
                                        {!! $errors->first('contact_number', '<label class="control-label"
                                                                                     for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            Accountant Details
                            <div class="form-group @if($errors->has('accountant_business_name')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Accountant Business Name') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="accountant_business_name[]" class="form-control"/>
                                    @if($errors->has('accountant_business_name'))
                                        {!! $errors->first('accountant_business_name', '<label class="control-label"
                                                                            for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('accountant_contact_person')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Contact Person') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="accountant_contact_person[]" class="form-control"/>
                                    @if($errors->has('accountant_contact_person'))
                                        {!! $errors->first('accountant_contact_person', '<label class="control-label"
                                                                            for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('phone_number')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Phone Number') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="accountant_phone_number[]" class="form-control"/>
                                    @if($errors->has('phone_number'))
                                        {!! $errors->first('phone_number', '<label class="control-label"
                                                                            for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            Accountant Address
                            <div class="form-group @if($errors->has('line1')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Line 1') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="accountant_line1[]" class="form-control"/>
                                    @if($errors->has('line1'))
                                        {!! $errors->first('line1', '<label class="control-label"
                                                                            for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('line2')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Line 2') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="accountant_line2[]" class="form-control"/>
                                    @if($errors->has('line2'))
                                        {!! $errors->first('line2', '<label class="control-label"
                                                                            for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('suburb')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Suburb') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="accountant_suburb[]" class="form-control"/>
                                    @if($errors->has('suburb'))
                                        {!! $errors->first('suburb', '<label class="control-label"
                                                                             for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('State') !!}</div>
                                <div class='col-md-6'>
                                    <select name="accountant_state[]" class="form-control">
                                        @foreach(config('general.state') as $key => $type)
                                            <option value="{{$key}}">{{$type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('postcode')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Postcode') !!}</div>
                                <div class='col-md-6'>
                                    <input type="text" name="accountant_postcode[]" class="form-control"/>
                                    @if($errors->has('postcode'))
                                        {!! $errors->first('postcode', '<label class="control-label"
                                                                               for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Country') !!}</div>
                                <div class='col-md-6'>
                                    <select name="accountant_country[]" class="form-control">
                                        @foreach(config('general.countries') as $key => $type)
                                            <option value="{{$key}}">{{$type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="add-income-div">
                        <hr/>
                        <div class="form-group">
                            <div class='col-md-2 control-label'>{!!Form::label('Add up to ten income sources') !!}</div>
                            <div class='col-md-6'>
                                <button type="button" class="btn btn-success add-income">Add an Income Source</button>
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
    {{ EX::js('assets/js/application/income.js') }}
@stop