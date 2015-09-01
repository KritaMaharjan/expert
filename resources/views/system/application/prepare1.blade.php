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

                <div class="box-header">
                    <h3 class="box-title">Applicants</h3>
                </div>

                <div class="box-body applicant-details">
                    <div class="new-applicant">
                        <div class="box no-border">
                            <div class="box-header">
                                <h3 class="box-title">Applicant <span class="applicant-num">1</span> Details</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                                {{-- General Application details --}}

                                <div class="form-group remove-block">
                                    <div class='col-md-2 control-label'>{!!Form::label('Added this by mistake?') !!}</div>
                                    <div class='col-md-6'>
                                        <button type="button" class="btn btn-danger remove-applicant">Remove this
                                            applicant
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Title') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="title[]" class="form-control">
                                            @foreach(config('general.title') as $key => $title)
                                                <option value="{{$key}}">{{$title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('given_name')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('First Name') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="given_name[]" />
                                        @if($errors->has('given_name'))
                                            {!! $errors->first('given_name', '<label class="control-label"
                                                                                     for="inputError">:message</label>') !!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('surname')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Family Name') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="surname[]" />
                                        @if($errors->has('surname'))
                                            {!! $errors->first('surname', '<label class="control-label"
                                                                                  for="inputError">:message</label>') !!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('mother_maiden_name')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Mother Maiden Name') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="mother_maiden_name[]" />
                                        @if($errors->has('mother_maiden_name'))
                                            {!! $errors->first('mother_maiden_name', '<label class="control-label"
                                                                                             for="inputError">:message</label>') !!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('email')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Email Address') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="email[]" />
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
                                            <input type="text" class="form-control date-picker" name="dob[]" />
                                            <span class="input-group-addon"><span
                                                        class="glyphicon glyphicon-calendar"></span>
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
                                        <select name="residency_status[]" class="form-control">
                                            @foreach(config('general.residency_status') as $key => $residency_status)
                                                <option value="{{$key}}">{{$residency_status}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group @if($errors->has('years_in_au')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Years in AU') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="years_in_au[]" />
                                        @if($errors->has('years_in_au'))
                                            {!! $errors->first('years_in_au', '<label class="control-label"
                                                                                      for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Marital Status') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="marital_status[]" class="form-control">
                                            @foreach(config('general.marital_status') as $key => $marital_status)
                                                <option value="{{$key}}">{{$marital_status}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Credit Cards Issue') !!}</div>
                                    <div class='col-md-6'>
                                        <label><input type="radio" name="credit_card_issue[]" value=1 checked="checked" /> Yes</label>
                                        <label><input type="radio" name="credit_card_issue[]" value=0 /> No</label>
                                    </div>
                                </div>
                                <div class="issue-comments form-group @if($errors->has('issue_comments')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Issue Comments') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="issue_comments[]" />
                                        @if($errors->has('issue_comments'))
                                            {!! $errors->first('issue_comments', '<label class="control-label"
                                                                                         for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group @if($errors->has('driver_licence_number')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Driver licence number') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="driver_licence_number[]" />
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
                                        <select name="licence_state[]" class="form-control">
                                            @foreach(config('general.licence_state') as $key => $licence_state)
                                                <option value="{{$key}}">{{$licence_state}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group clearfix {{ ($errors->has('licence_expiry_date'))? 'has-error': '' }}">
                                    <div class='col-md-2 control-label'>{!! Form::label('Licence Expiry Dtae') !!}</div>
                                    <div class='col-md-6'>
                                        <div id="due_date" class="input-group date">
                                            <input type="text" name="licence_expiry_date[]" class="form-control expiry_date" />
                                            <span class="input-group-addon"><span
                                                        class="glyphicon glyphicon-calendar"></span>
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
                                        <label><input type="radio" name="dependent[]" value=1 /> Yes</label>
                                        <label><input type="radio" name="dependent[]" value=0 checked="checked" /> No</label>
                                    </div>
                                </div>
                                <div class="form-group dependant hide">
                                    <div class='col-md-2 control-label'>{!!Form::label('Age of Dependants') !!}</div>
                                    <div class='col-md-6'>
                                <span class="ages"><input type="text" name="age[]"
                                                          class="form-control text-digit"/></span>
                                        <a href="#" class="add-dependant"><i class="fa fa-plus-circle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box -->

                        {{-- Contact Details--}}
                        <div class="box no-border">
                            <div class="box-header">
                                <h3 class="box-title">Contact Details</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="form-group @if($errors->has('mobile')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Mobile Number') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="mobile[]" />
                                        @if($errors->has('mobile'))
                                            {!! $errors->first('mobile', '<label class="control-label"
                                                                                 for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group @if($errors->has('home')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Home Phone Number') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="home[]" />
                                        @if($errors->has('home'))
                                            {!! $errors->first('home', '<label class="control-label"
                                                                               for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group @if($errors->has('work')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Work Phone Number') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="work[]" />
                                        @if($errors->has('work'))
                                            {!! $errors->first('work', '<label class="control-label"
                                                                               for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group @if($errors->has('fax')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Fax Number') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="fax[]" />
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
                        <div class="box no-border">
                            <div class="box-header">
                                <h3 class="box-title">Current Home Address Details</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                                <div class="form-group @if($errors->has('home_line1')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Line 1') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="home_line1[]" />
                                        @if($errors->has('home_line1'))
                                            {!! $errors->first('home_line1', '<label class="control-label"
                                                                                     for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('home_line2')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Line 2') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="home_line2[]" />
                                        @if($errors->has('home_line2'))
                                            {!! $errors->first('home_line2', '<label class="control-label"
                                                                                     for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('home_suburb')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Suburb') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="home_suburb[]" />
                                        @if($errors->has('home_suburb'))
                                            {!! $errors->first('home_suburb', '<label class="control-label"
                                                                                      for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('State') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="home_state[]" class="form-control">
                                            @foreach(config('general.state') as $key => $state)
                                                <option value="{{$key}}">{{$state}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('home_postcode')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Postcode') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="home_postcode[]" />
                                        @if($errors->has('home_postcode'))
                                            {!! $errors->first('home_postcode', '<label class="control-label"
                                                                                        for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Country') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="home_country[]" class="form-control">
                                            @foreach(config('general.countries') as $key => $countries)
                                                <option value="{{$key}}">{{$countries}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div> {{--housing status--}}

                                <div class="form-group @if($errors->has('weekly_rent_expense')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Weekly Rent Expense') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="weekly_rent_expense[]" />
                                        @if($errors->has('weekly_rent_expense'))
                                            {!! $errors->first('weekly_rent_expense', '<label class="control-label"
                                                                                              for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('To be cleared') !!}</div>
                                    <div class='col-md-6'>
                                        <label><input type="radio" name="to_be_cleared[]" value=1 /> Yes</label>
                                        <label><input type="radio" name="to_be_cleared[]" value=0 checked="checked" /> No</label>
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('debit_from')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Debit From') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="debit_from[]" />
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
                                            <input type="text" name="live_there_since[]" class="form-control date-picker[]" />
                                            <span class="input-group-addon"><span
                                                        class="glyphicon glyphicon-calendar"></span>
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
                        <div class="box no-border">
                            <div class="box-header">
                                <h3 class="box-title">Postal Address Details</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                                <div class="form-group @if($errors->has('postal_line1')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Line 1') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="postal_line1[]" />
                                        @if($errors->has('postal_line1'))
                                            {!! $errors->first('postal_line1', '<label class="control-label"
                                                                                       for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('postal_line2')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Line 2') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="postal_line2[]" />
                                        @if($errors->has('postal_line2'))
                                            {!! $errors->first('postal_line2', '<label class="control-label"
                                                                                       for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('postal_suburb')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Suburb') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="postal_suburb[]" />
                                        @if($errors->has('postal_suburb'))
                                            {!! $errors->first('postal_suburb', '<label class="control-label"
                                                                                        for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('State') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="postal_state[]" class="form-control">
                                            @foreach(config('general.state') as $key => $state)
                                                <option value="{{$key}}">{{$state}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('postal_postcode')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Postcode') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="postal_postcode[]" />
                                        @if($errors->has('postal_postcode'))
                                            {!! $errors->first('postal_postcode', '<label class="control-label"
                                                                                          for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Country') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="postal_country[]" class="form-control">
                                            @foreach(config('general.countries') as $key => $countries)
                                                <option value="{{$key}}">{{$countries}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Previous Address Details--}}
                        <div class="box no-border">
                            <div class="box-header">
                                <h3 class="box-title">Previous Address Details</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                                <div class="form-group @if($errors->has('previous_line1')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Line 1') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="previous_line1[]" />
                                        @if($errors->has('previous_line1'))
                                            {!! $errors->first('previous_line1', '<label class="control-label"
                                                                                         for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('previous_line2')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Line 2') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="previous_line2[]" />
                                        @if($errors->has('previous_line2'))
                                            {!! $errors->first('previous_line2', '<label class="control-label"
                                                                                         for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('previous_suburb')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Suburb') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="previous_suburb[]" />
                                        @if($errors->has('previous_suburb'))
                                            {!! $errors->first('previous_suburb', '<label class="control-label"
                                                                                          for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('State') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="previous_state[]" class="form-control">
                                            @foreach(config('general.state') as $key => $state)
                                                <option value="{{$key}}">{{$state}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('previous_postcode')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Postcode') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="previous_postcode[]" />
                                        @if($errors->has('previous_postcode'))
                                            {!! $errors->first('previous_postcode', '<label class="control-label"
                                                                                            for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Country') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="previous_country[]" class="form-control">
                                            @foreach(config('general.countries') as $key => $countries)
                                                <option value="{{$key}}">{{$countries}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Previous Employment Details--}}
                        <div class="box no-border">
                            <div class="box-header">
                                <h3 class="box-title">Previous Employment</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Employment Type') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="employment_type[]" class="form-control">
                                            @foreach(config('general.employment_type') as $key => $employment_type)
                                                <option value="{{$key}}">{{$employment_type}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('job_title')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Job Title') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="job_title[]" />
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
                                            <input type="text" name="starting_date[]" class="form-control starting_date" />
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
                                        <input type="text" class="form-control" name="business_name[]" />
                                        @if($errors->has('business_name'))
                                            {!! $errors->first('business_name', '<label class="control-label"
                                                                                        for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('abn')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Employer ABN') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="abn[]" />
                                        @if($errors->has('abn'))
                                            {!! $errors->first('abn', '<label class="control-label"
                                                                              for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('contact_person')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Contact Person') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="contact_person[]" />
                                        @if($errors->has('contact_person'))
                                            {!! $errors->first('contact_person', '<label class="control-label"
                                                                                         for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('contact_person_job_title')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Contact Person Job Title') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="contact_person_job_title[]" />
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
                                        <input type="text" class="form-control" name="contact_number[]" />
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
                                        <input type="text" class="form-control" name="employment_line1[]" />
                                        @if($errors->has('employment_line1'))
                                            {!! $errors->first('employment_line1', '<label class="control-label"
                                                                                           for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('employment_line2')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Line 2') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="employment_line2[]" />
                                        @if($errors->has('employment_line2'))
                                            {!! $errors->first('employment_line2', '<label class="control-label"
                                                                                           for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('employment_suburb')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Suburb') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="employment_suburb[]" />
                                        @if($errors->has('employment_suburb'))
                                            {!! $errors->first('employment_suburb', '<label class="control-label"
                                                                                            for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('State') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="employment_state[]" class="form-control">
                                            @foreach(config('general.state') as $key => $state)
                                                <option value="{{$key}}">{{$state}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('employment_postcode')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Postcode') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" class="form-control" name="employment_postcode[]" />
                                        @if($errors->has('employment_postcode'))
                                            {!! $errors->first('employment_postcode', '<label class="control-label"
                                                                                              for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Country') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="employment_country[]" class="form-control">
                                            @foreach(config('general.countries') as $key => $countries)
                                                <option value="{{$key}}">{{$countries}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                            </div>

                            {{--<div class="box-footer col-lg-12 clear-both">
                                @if($total_applicants < 9)
                                    <input type="submit" value="Submit and Add Another Applicant"
                                           class="btn btn-success pull-left"
                                           name="new"/>
                                @endif
                                <input type="submit" class="btn btn-primary" value="Next" name="submit"/>
                            </div>--}}
                        </div>

                    </div>
                    <div class="add-applicant-div">
                        <hr/>
                        <div class="form-group">
                            <div class='col-md-2 control-label'>{!!Form::label('Add up to ten applicants') !!}</div>
                            <div class='col-md-6'>
                                <button type="button" class="btn btn-success add-applicant">Add an Applicant</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="submit" class="btn btn-primary" value="Next" name="submit"/>
                </div>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
    {{ EX::js('assets/js/application/prepare.js') }}
@stop