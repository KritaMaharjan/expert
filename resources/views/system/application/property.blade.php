@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Properties - Applications
@stop

@section('breadcrumb')
    @parent
    <li>Applications</li>
    <li>Properties</li>
@stop

@section('content')

    @include('system.application.steps')
    <div class="row">
        @include('flash::message')
        {!!Form::open(['class' => 'form-horizontal'])!!}
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Property {{$total_properties + 1}} Details</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    {{-- General Application details --}}
                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Taken As Security') !!}</div>
                        <div class='col-md-6'>
                            <label>{!! Form::radio('taken_as_security', 1, true) !!} Yes</label>
                            <label>{!! Form::radio('taken_as_security', 0) !!} No</label>
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('market_value')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Market Value') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('market_value','',array('class' => 'form-control'))!!}
                            @if($errors->has('market_value'))
                                {!! $errors->first('market_value', '<label class="control-label"
                                                                           for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Ownership') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('applicant_id', $applicants, null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Property Usage') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('property_usage', config('general.property_usage'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Property Type') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('property_type', config('general.property_type'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Number Of Bedrooms') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('number_of_bedrooms', config('general.zero_to_ten'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Number Of Bathrooms') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('number_of_bathrooms', config('general.zero_to_ten'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Number Of Car Spaces') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('number_of_car_spaces', config('general.zero_to_ten'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('size')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Size (land in sqm)') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('size','',array('class' => 'form-control'))!!}
                            @if($errors->has('size'))
                                {!! $errors->first('size', '<label class="control-label"
                                                                   for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('title_particulars')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Title Particulars') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('title_particulars','',array('class' => 'form-control'))!!}
                            @if($errors->has('title_particulars'))
                                {!! $errors->first('title_particulars', '<label class="control-label"
                                                                                for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('title_type')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Title Type') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('title_type','',array('class' => 'form-control'))!!}
                            @if($errors->has('title_type'))
                                {!! $errors->first('title_type', '<label class="control-label"
                                                                         for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.box -->

            {{-- Address Details--}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Address Details</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    {{-- Same as applicant ? --}}
                    {{--<div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Current Home Address') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('residency_status', config('general.residency_status'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>--}}

                    <div class="form-group @if($errors->has('line1')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Line 1') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('line1','',array('class' => 'form-control'))!!}
                            @if($errors->has('line1'))
                                {!! $errors->first('line1', '<label class="control-label"
                                                                    for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('line2')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Line 2') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('line2','',array('class' => 'form-control'))!!}
                            @if($errors->has('line2'))
                                {!! $errors->first('line2', '<label class="control-label"
                                                                    for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('suburb')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Suburb') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('suburb','',array('class' => 'form-control'))!!}
                            @if($errors->has('suburb'))
                                {!! $errors->first('suburb', '<label class="control-label"
                                                                     for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('State') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('state', config('general.state'), null,
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('postcode')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Postcode') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('postcode','',array('class' => 'form-control'))!!}
                            @if($errors->has('postcode'))
                                {!! $errors->first('postcode', '<label class="control-label"
                                                                       for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Country') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('country', config('general.countries'), 'AU',
                            array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rental Income --}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Rental Income</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Receive Rental Income') !!}</div>
                        <div class='col-md-6'>
                            <label>{!! Form::radio('rental_income', 1, true) !!} Yes</label>
                            <label>{!! Form::radio('rental_income', 0) !!} No</label>
                        </div>
                    </div>

                    <div class="rental-details">

                        <div class="form-group @if($errors->has('weekly_rental')) {{'has-error'}} @endif">
                            <div class='col-md-2 control-label'>{!!Form::label('Weekly Rental') !!}</div>
                            <div class='col-md-6'>
                                {!!Form::text('weekly_rental','',array('class' => 'form-control'))!!}
                                @if($errors->has('weekly_rental'))
                                    {!! $errors->first('weekly_rental', '<label class="control-label"
                                                                                for="inputError">:message</label>')!!}
                                @endif
                            </div>
                        </div>

                        <div class="form-group @if($errors->has('credit_to')) {{'has-error'}} @endif">
                            <div class='col-md-2 control-label'>{!!Form::label('Credit To') !!}</div>
                            <div class='col-md-6'>
                                {!!Form::text('credit_to','',array('class' => 'form-control'))!!}
                                @if($errors->has('credit_to'))
                                    {!! $errors->first('credit_to', '<label class="control-label"
                                                                            for="inputError">:message</label>')!!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Valuation Access Details--}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Valuation Access Details</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Valuation access party') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::select('access_party', config('general.valuation_access_party'), null,
                            array('class' =>
                            'form-control'))!!}
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

                    <div class="form-group @if($errors->has('phone_number')) {{'has-error'}} @endif">
                        <div class='col-md-2 control-label'>{!!Form::label('Phone Number') !!}</div>
                        <div class='col-md-6'>
                            {!!Form::text('phone_number','',array('class' => 'form-control'))!!}
                            @if($errors->has('phone_number'))
                                {!! $errors->first('phone_number', '<label class="control-label"
                                                                           for="inputError">:message</label>')!!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Existing Loans --}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Existing Loans</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Any Existing Loans') !!}</div>
                        <div class='col-md-6'>
                            <label>{!! Form::radio('existing_loans', 1) !!} Yes</label>
                            <label>{!! Form::radio('existing_loans', 0, true) !!} No</label>
                        </div>
                    </div>

                    <div class="loans-details" style="display:none">

                        <div class="form-group">
                            <div class='col-md-2 control-label'>{!!Form::label('Ownership') !!}</div>
                            <div class='col-md-6'>
                                {!!Form::select('ownership', $applicants, null,
                                array('class' =>
                                'form-control'))!!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class='col-md-2 control-label'>{!!Form::label('To Be Cleared') !!}</div>
                            <div class='col-md-6'>
                                <label>{!! Form::radio('to_be_cleared', 1, true) !!} Yes</label>
                                <label>{!! Form::radio('to_be_cleared', 0) !!} No</label>
                            </div>
                        </div>

                        <div class="form-group @if($errors->has('lender')) {{'has-error'}} @endif">
                            <div class='col-md-2 control-label'>{!!Form::label('Lender') !!}</div>
                            <div class='col-md-6'>
                                {!!Form::text('lender','',array('class' => 'form-control'))!!}
                                @if($errors->has('lender'))
                                    {!! $errors->first('lender', '<label class="control-label"
                                                                         for="inputError">:message</label>')!!}
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class='col-md-2 control-label'>{!!Form::label('Loan Type') !!}</div>
                            <div class='col-md-6'>
                                {!!Form::select('loan_type', array('variable' => 'variable', 'fixed' => 'Fixed'), null,
                                array('class' =>
                                'form-control'))!!}
                            </div>
                        </div>

                        <div class="form-group @if($errors->has('fixed_rate_term')) {{'has-error'}} @endif">
                            <div class='col-md-2 control-label'>{!!Form::label('Fixed Rate Term') !!}</div>
                            <div class='col-md-6'>
                                {!!Form::text('fixed_rate_term','',array('class' => 'form-control'))!!}
                                @if($errors->has('fixed_rate_term'))
                                    {!! $errors->first('fixed_rate_term', '<label class="control-label"
                                                                                  for="inputError">:message</label>')!!}
                                @endif
                            </div>
                        </div>

                        <div class="form-group clearfix {{ ($errors->has('fixed_rate_expiry_date'))? 'has-error': '' }}">
                            <div class='col-md-2 control-label'>{!! Form::label('Fixed Rate Expiry Date') !!}</div>
                            <div class='col-md-6'>
                                <div id="due_date" class="input-group date">
                                    {!! Form:: text('fixed_rate_expiry_date', null, array('class' => 'form-control
                                    expiry_date')) !!}
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                </div>
                                @if($errors->has('fixed_rate_expiry_date'))
                                    {!! $errors->first('fixed_rate_expiry_date', '<label class="control-label"
                                                                                         for="inputError">:message</label>
                                    ') !!}
                                @endif
                            </div>
                        </div>

                        <div class="form-group @if($errors->has('limit')) {{'has-error'}} @endif">
                            <div class='col-md-2 control-label'>{!!Form::label('Limit') !!}</div>
                            <div class='col-md-6'>
                                {!!Form::text('limit','',array('class' => 'form-control'))!!}
                                @if($errors->has('limit'))
                                    {!! $errors->first('limit', '<label class="control-label"
                                                                        for="inputError">:message</label>')!!}
                                @endif
                            </div>
                        </div>

                        <div class="form-group @if($errors->has('balance')) {{'has-error'}} @endif">
                            <div class='col-md-2 control-label'>{!!Form::label('Balance') !!}</div>
                            <div class='col-md-6'>
                                {!!Form::text('balance','',array('class' => 'form-control'))!!}
                                @if($errors->has('balance'))
                                    {!! $errors->first('balance', '<label class="control-label"
                                                                          for="inputError">:message</label>')!!}
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="box-footer col-lg-12 clear-both">
                    @if($total_properties < 9)
                        <input type="submit" value="Submit and Add Another Property" class="btn btn-success pull-left"
                               name="new"/>
                    @endif
                    <input type="submit" class="btn btn-primary" value="Next" name="submit"/>
                </div>
            </div>

        </div>
        {!!Form::close()!!}
    </div>
    {{ EX::js('assets/js/application/property.js') }}
@stop