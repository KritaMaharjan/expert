@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Prepare Applications
@stop

@section('breadcrumb')
    @parent
    <li>Applications</li>
    <li>Prepare</li>
@stop

@section('content')
    @include('system.application.steps')

    <div class="row">
        {!!Form::open(['class' => 'form-horizontal'])!!}
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Applicant {{$total_applicants + 1}} Details</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    {{-- General Application details --}}
                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Title') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('title', config('general.title'), null, array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('given_name')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('First Name') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('given_name','',array('class' => 'form-control'))!!}
                            @if($errors->has('given_name'))
                                {!! $errors->first('given_name', '<label class="control-label"
                                                                         for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('surname')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Family Name') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('surname','',array('class' => 'form-control'))!!}
                            @if($errors->has('surname'))
                                {!! $errors->first('surname', '<label class="control-label"
                                                                      for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('mother_maiden_name')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Mother Maiden Name') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('mother_maiden_name','',array('class' => 'form-control'))!!}
                            @if($errors->has('mother_maiden_name'))
                                {!! $errors->first('mother_maiden_name', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('email')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Email Address') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('email','',array('class' => 'form-control'))!!}
                            @if($errors->has('email'))
                                {!! $errors->first('email', '<label class="control-label"
                                                                    for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group clearfix {{ ($errors->has('dob'))? 'has-error': '' }}">
                        <div class='col-md-2 control-label'>{!! Form::label('Date of Birth') !!}</div>
                        <div class='col-md-6'>
                            <div id="due_date" class="input-group date">
                                {!! Form:: text('dob', null, array('class' => 'form-control date-picker')) !!}
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            @if($errors->has('dob'))
                                {!! $errors->first('dob', '<label class="control-label"
                                                                  for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Residency Status') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('residency_status', config('general.residency_status'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('years_in_au')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Years in AU') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('years_in_au','',array('class' => 'form-control'))!!}
                            @if($errors->has('years_in_au'))
                                {!! $errors->first('years_in_au', '<label class="control-label"
                                                                          for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Marital Status') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('marital_status', config('general.marital_status'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Credit Cards Issue') !!}</div>
                        <div class='col-md-6'>
                            <label>{!! Form::radio('credit_card_issue', 1, true) !!} Yes</label>
                            <label>{!! Form::radio('credit_card_issue', 0) !!} No</label>
                        </div>
                    </div>
                    <div class="issue-comments form-group @if($errors->has('issue_comments')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Issue Comments') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('issue_comments','',array('class' => 'form-control'))!!}
                            @if($errors->has('issue_comments'))
                                {!! $errors->first('issue_comments', '<label class="control-label"
                                                                             for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('driver_licence_number')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Driver licence number') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('driver_licence_number','',array('class' => 'form-control'))!!}
                            @if($errors->has('driver_licence_number'))
                                {!! $errors->first('driver_licence_number', '<label class="control-label"
                                                                                    for="inputError">:message</label>
                                ')!!}
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Licence State') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('licence_state', config('general.licence_state'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>
                    <div class="form-group clearfix {{ ($errors->has('licence_expiry_date'))? 'has-error': '' }}">
                        <div class='col-md-2 control-label'>{!! Form::label('Licence Expiry Dtae') !!}</div>
                        <div class='col-md-6'>
                            <div id="due_date" class="input-group date">
                                {!! Form:: text('licence_expiry_date', null, array('class' => 'form-control
                                expiry_date')) !!}
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            @if($errors->has('licence_expiry_date'))
                                {!! $errors->first('licence_expiry_date', '<label class="control-label"
                                                                                  for="inputError">:message</label>')
                                !!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Dependants') !!}</div>
                        <div class='col-md-6'>
                            <label>{!! Form::radio('dependent', 'yes') !!} Yes</label>
                            <label>{!! Form::radio('dependent', 'no', true) !!} No</label>
                        </div>
                    </div>
                    <div class="form-group dependant hide">
                        <div class='col-md-2 control-label'>{!!Form::label('Age of Dependants') !!}</div>
                        <div class='col-md-6'>
                            <span class="ages"><input type="text" name="age[]" class="form-control text-digit"/></span>
                            <a href="#" class="add-dependant"><i class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box -->

            {{-- Contact Details--}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Contact Details</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group @if($errors->has('mobile')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Mobile Number') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('mobile','',array('class' => 'form-control'))!!}
                            @if($errors->has('mobile'))
                                {!! $errors->first('mobile', '<label class="control-label"
                                                                     for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('home')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Home Phone Number') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('home','',array('class' => 'form-control'))!!}
                            @if($errors->has('home'))
                                {!! $errors->first('home', '<label class="control-label"
                                                                   for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('work')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Work Phone Number') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('work','',array('class' => 'form-control'))!!}
                            @if($errors->has('work'))
                                {!! $errors->first('work', '<label class="control-label"
                                                                   for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('fax')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Fax Number') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('fax','',array('class' => 'form-control'))!!}
                            @if($errors->has('fax'))
                                {!! $errors->first('fax', '<label class="control-label"
                                                                  for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>
                    {{-- Additional Phone Numbers --}}
                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Additional Phone') !!}
                            <a class="add-phone pull-right"><i class="fa fa-plus-circle"></i></a>
                        </div>

                        <div class="phone-group col-md-6">
                            <div class="row phone-row form-group">
                                <div class="col-sm-3">
                                    <select name="phonetype[]" class="form-control">
                                        @foreach(config('general.phone_type') as $key => $phone)
                                            <option value="{{$key}}">{{$phone}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="phone[]" class="form-control"/>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-danger btn-small remove-phone pull-right"><i
                                                class="glyphicon glyphicon-remove"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Address Details--}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Current Home Address Details</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    {{--<div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Current Home Address') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('residency_status', config('general.residency_status'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>--}}

                    <div class="form-group @if($errors->has('home_line1')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Line 1') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('home_line1','',array('class' => 'form-control'))!!}
                            @if($errors->has('home_line1'))
                                {!! $errors->first('home_line1', '<label class="control-label"
                                                                         for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('home_line2')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Line 2') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('home_line2','',array('class' => 'form-control'))!!}
                            @if($errors->has('home_line2'))
                                {!! $errors->first('home_line2', '<label class="control-label"
                                                                         for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('home_suburb')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Suburb') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('home_suburb','',array('class' => 'form-control'))!!}
                            @if($errors->has('home_suburb'))
                                {!! $errors->first('home_suburb', '<label class="control-label"
                                                                          for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('State') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('home_state', config('general.state'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('home_postcode')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Postcode') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('home_postcode','',array('class' => 'form-control'))!!}
                            @if($errors->has('home_postcode'))
                                {!! $errors->first('home_postcode', '<label class="control-label"
                                                                            for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Country') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('home_country', config('general.countries'), 'AU',
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div> {{--housing status--}}

                    <div class="form-group @if($errors->has('weekly_rent_expense')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Weekly Rent Expense') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('weekly_rent_expense','',array('class' => 'form-control'))!!}
                            @if($errors->has('weekly_rent_expense'))
                                {!! $errors->first('weekly_rent_expense', '<label class="control-label"
                                                                                  for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('To be cleared') !!}</div>
                        <div class='col-md-6'>
                            <label>{!! Form::radio('to_be_cleared', 1) !!} Yes</label>
                            <label>{!! Form::radio('to_be_cleared', 0, true) !!} No</label>
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('debit_from')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Debit From') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('debit_from','',array('class' => 'form-control'))!!}
                            @if($errors->has('debit_from'))
                                {!! $errors->first('debit_from', '<label class="control-label"
                                                                         for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group clearfix {{ ($errors->has('live_there_since'))? 'has-error': '' }}">
                        <div class='col-md-2 control-label'>{!! Form::label('Living there since') !!}</div>
                        <div class='col-md-6'>
                            <div id="due_date" class="input-group date">
                                {!! Form:: text('live_there_since', null, array('class' => 'form-control date-picker'))
                                !!}
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            @if($errors->has('live_there_since'))
                                {!! $errors->first('live_there_since', '<label class="control-label"
                                                                               for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Postal Address Details--}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Postal Address Details</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    {{--<div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Current Home Address') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('residency_status', config('general.residency_status'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>--}}

                    <div class="form-group @if($errors->has('postal_line1')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Line 1') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('postal_line1','',array('class' => 'form-control'))!!}
                            @if($errors->has('postal_line1'))
                                {!! $errors->first('postal_line1', '<label class="control-label"
                                                                           for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('postal_line2')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Line 2') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('postal_line2','',array('class' => 'form-control'))!!}
                            @if($errors->has('postal_line2'))
                                {!! $errors->first('postal_line2', '<label class="control-label"
                                                                           for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('postal_suburb')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Suburb') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('postal_suburb','',array('class' => 'form-control'))!!}
                            @if($errors->has('postal_suburb'))
                                {!! $errors->first('postal_suburb', '<label class="control-label"
                                                                            for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('State') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('postal_state', config('general.state'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('postal_postcode')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Postcode') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('postal_postcode','',array('class' => 'form-control'))!!}
                            @if($errors->has('postal_postcode'))
                                {!! $errors->first('postal_postcode', '<label class="control-label"
                                                                              for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Country') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('postal_country', config('general.countries'), 'AU',
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Previous Address Details--}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Previous Address Details</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    {{--<div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Current Home Address') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('residency_status', config('general.residency_status'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>--}}

                    <div class="form-group @if($errors->has('previous_line1')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Line 1') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('previous_line1','',array('class' => 'form-control'))!!}
                            @if($errors->has('previous_line1'))
                                {!! $errors->first('previous_line1', '<label class="control-label"
                                                                             for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('previous_line2')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Line 2') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('previous_line2','',array('class' => 'form-control'))!!}
                            @if($errors->has('previous_line2'))
                                {!! $errors->first('previous_line2', '<label class="control-label"
                                                                             for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('previous_suburb')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Suburb') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('previous_suburb','',array('class' => 'form-control'))!!}
                            @if($errors->has('previous_suburb'))
                                {!! $errors->first('previous_suburb', '<label class="control-label"
                                                                              for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('State') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('previous_state', config('general.state'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('previous_postcode')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Postcode') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('previous_postcode','',array('class' => 'form-control'))!!}
                            @if($errors->has('previous_postcode'))
                                {!! $errors->first('previous_postcode', '<label class="control-label"
                                                                                for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Country') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('previous_country', config('general.countries'), 'AU',
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Previous Employment Details--}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Previous Employment</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Employment Type') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('employment_type', config('general.employment_type'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('job_title')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Job Title') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('job_title','',array('class' => 'form-control'))!!}
                            @if($errors->has('job_title'))
                                {!! $errors->first('job_title', '<label class="control-label"
                                                                        for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group clearfix {{ ($errors->has('starting_date'))? 'has-error': '' }}">
                        <div class='col-md-2 control-label'>{!! Form::label('Starting Date') !!}</div>
                        <div class='col-md-6'>
                            <div id="due_date" class="input-group date">
                                {!! Form:: text('starting_date', null, array('class' => 'form-control starting_date'))
                                !!}
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
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
                            {!!Form::text('business_name','',array('class' => 'form-control'))!!}
                            @if($errors->has('business_name'))
                                {!! $errors->first('business_name', '<label class="control-label"
                                                                            for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('abn')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Employer ABN') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('abn','',array('class' => 'form-control'))!!}
                            @if($errors->has('abn'))
                                {!! $errors->first('abn', '<label class="control-label"
                                                                  for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('contact_person')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Contact Person') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('contact_person','',array('class' => 'form-control'))!!}
                            @if($errors->has('contact_person'))
                                {!! $errors->first('contact_person', '<label class="control-label"
                                                                             for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('contact_person_job_title')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Contact Person Job Title') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('contact_person_job_title','',array('class' => 'form-control'))!!}
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
                            {!!Form::text('contact_number','',array('class' => 'form-control'))!!}
                            @if($errors->has('contact_number'))
                                {!! $errors->first('contact_number', '<label class="control-label"
                                                                             for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    {{--Employment address details--}}
                    <div class="form-group @if($errors->has('employment_line1')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Line 1') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('employment_line1','',array('class' => 'form-control'))!!}
                            @if($errors->has('employment_line1'))
                                {!! $errors->first('employment_line1', '<label class="control-label"
                                                                               for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('employment_line2')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Line 2') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('employment_line2','',array('class' => 'form-control'))!!}
                            @if($errors->has('employment_line2'))
                                {!! $errors->first('employment_line2', '<label class="control-label"
                                                                               for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('employment_suburb')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Suburb') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('employment_suburb','',array('class' => 'form-control'))!!}
                            @if($errors->has('employment_suburb'))
                                {!! $errors->first('employment_suburb', '<label class="control-label"
                                                                                for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('State') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('employment_state', config('general.state'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('employment_postcode')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Postcode') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('employment_postcode','',array('class' => 'form-control'))!!}
                            @if($errors->has('employment_postcode'))
                                {!! $errors->first('employment_postcode', '<label class="control-label"
                                                                                  for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Country') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('employment_country', config('general.countries'), 'AU',
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>

                </div>

                <div class="box-footer col-lg-12 clear-both">
                    @if($total_applicants < 9)
                        <input type="submit" value="Submit and Add Another Applicant" class="btn btn-success pull-left"
                           name="new"/>
                    @endif
                    <input type="submit" class="btn btn-primary" value="Next" name="submit"/>
                </div>
            </div>

        </div>
        {!!Form::close()!!}
    </div>
    {{ EX::js('assets/js/application/prepare.js') }}
@stop