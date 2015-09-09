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
                <div class="box-header">
                    <h3 class="box-title">Properties</h3>
                </div>

                <div class="box-body property-details">
                    <div class="new-property">
                        <div class="box no-border">
                            <div class="box-header with-border">
                                <h3 class="box-title">Property <span class="property-num">1</span> Details</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="form-group remove-block">
                                    <div class='col-md-2 control-label'>{!!Form::label('Added this by mistake?') !!}</div>
                                    <div class='col-md-6'>
                                        <button type="button" class="btn btn-danger remove-property">Remove this
                                            property
                                        </button>
                                    </div>
                                </div>

                                {{-- General Application details --}}
                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Taken As Security') !!}</div>
                                    <div class='col-md-6'>
                                        <label><input type="radio" name="taken_as_security[]" value=1 checked="checked" /> Yes</label>
                                        <label><input type="radio" name="taken_as_security[]" value=0 /> No</label>
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('market_value')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Market Value') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" name="market_value[]" class="form-control" />
                                        @if($errors->has('market_value'))
                                            {!! $errors->first('market_value', '<label class="control-label"
                                                                                       for="inputError">:message</label>') !!}
                                        @endif
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

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Property Usage') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="property_usage[]" class="form-control">
                                            @foreach(config('general.property_usage') as $key => $usage)
                                                <option value="{{$key}}">{{$usage}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Property Type') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="property_type[]" class="form-control">
                                            @foreach(config('general.property_type') as $key => $type)
                                                <option value="{{$key}}">{{$type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Number Of Bedrooms') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="number_of_bedrooms[]" class="form-control">
                                            @foreach(config('general.zero_to_ten') as $key => $usage)
                                                <option value="{{$key}}">{{$usage}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Number Of Bathrooms') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="number_of_bathrooms[]" class="form-control">
                                            @foreach(config('general.zero_to_ten') as $key => $usage)
                                                <option value="{{$key}}">{{$usage}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class='col-md-2 control-label'>{!!Form::label('Number Of Car Spaces') !!}</div>
                                    <div class='col-md-6'>
                                        <select name="number_of_car_spaces[]" class="form-control">
                                            @foreach(config('general.zero_to_ten') as $key => $usage)
                                                <option value="{{$key}}">{{$usage}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('size')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Size (land in sqm)') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" name="size[]" class="form-control" />
                                        @if($errors->has('size'))
                                            {!! $errors->first('size', '<label class="control-label"
                                                                               for="inputError">:message</label>') !!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('title_particulars')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Title Particulars') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" name="title_particulars[]" class="form-control" />
                                        @if($errors->has('title_particulars'))
                                            {!! $errors->first('title_particulars', '<label class="control-label"
                                                                                            for="inputError">:message</label>') !!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('title_type')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Title Type') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" name="title_type[]" class="form-control" />
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
                                        <input type="text" name="line1[]" class="form-control" />
                                        @if($errors->has('line1'))
                                            {!! $errors->first('line1', '<label class="control-label"
                                                                                for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('line2')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Line 2') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" name="line2[]" class="form-control" />
                                        @if($errors->has('line2'))
                                            {!! $errors->first('line2', '<label class="control-label"
                                                                                for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('suburb')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Suburb') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" name="suburb[]" class="form-control" />
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
                                            @foreach(config('general.state') as $key => $state)
                                                <option value="{{$key}}">{{$state}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('postcode')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Postcode') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" name="postcode[]" class="form-control" />
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
                                            @foreach(config('general.countries') as $key => $country)
                                                <option value="{{$key}}">{{$country}}</option>
                                            @endforeach
                                        </select>
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
                                        <label><input type="radio" name="rental_income[]" value=1 checked="checked" /> Yes</label>
                                        <label><input type="radio" name="rental_income[]" value=0 /> No</label>
                                    </div>
                                </div>

                                <div class="rental-details">

                                    <div class="form-group @if($errors->has('weekly_rental')) {{'has-error'}} @endif">
                                        <div class='col-md-2 control-label'>{!!Form::label('Weekly Rental') !!}</div>
                                        <div class='col-md-6'>
                                            <input type="text" name="weekly_rental[]" class="form-control" />
                                            @if($errors->has('weekly_rental'))
                                                {!! $errors->first('weekly_rental', '<label class="control-label"
                                                                                            for="inputError">:message</label>')!!}
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group @if($errors->has('credit_to')) {{'has-error'}} @endif">
                                        <div class='col-md-2 control-label'>{!!Form::label('Credit To') !!}</div>
                                        <div class='col-md-6'>
                                            <input type="text" name="credit_to[]" class="form-control" />
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
                                        <select name="access_party[]" class="form-control">
                                            @foreach(config('general.valuation_access_party') as $key => $access_party)
                                                <option value="{{$key}}">{{$access_party}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('contact_person')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Contact Person') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" name="contact_person[]" class="form-control" />
                                        @if($errors->has('contact_person'))
                                            {!! $errors->first('contact_person', '<label class="control-label"
                                                                                         for="inputError">:message</label>')!!}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group @if($errors->has('phone_number')) {{'has-error'}} @endif">
                                    <div class='col-md-2 control-label'>{!!Form::label('Phone Number') !!}</div>
                                    <div class='col-md-6'>
                                        <input type="text" name="phone_number[]" class="form-control" />
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
                                        <label><input type="radio" name="existing_loans[]" value=1 /> Yes</label>
                                        <label><input type="radio" name="existing_loans[]" value=0 checked="checked" /> No</label>
                                    </div>
                                </div>

                                <div class="loans-details" style="display:none">

                                    <div class="form-group">
                                        <div class='col-md-2 control-label'>{!!Form::label('Ownership') !!}</div>
                                        <div class='col-md-6'>
                                            <select name="ownership[]" class="form-control">
                                                @foreach($applicants as $key => $$applicant)
                                                    <option value="{{$key}}">{{$$applicant}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class='col-md-2 control-label'>{!!Form::label('To Be Cleared') !!}</div>
                                        <div class='col-md-6'>
                                            <label><input type="radio" name="to_be_cleared[]" value=1 checked="checked" /> Yes</label>
                                            <label><input type="radio" name="to_be_cleared[]" value=0 /> No</label>
                                        </div>
                                    </div>

                                    <div class="form-group @if($errors->has('lender')) {{'has-error'}} @endif">
                                        <div class='col-md-2 control-label'>{!!Form::label('Lender') !!}</div>
                                        <div class='col-md-6'>
                                            <input type="text" name="lender[]" class="form-control" />
                                            @if($errors->has('lender'))
                                                {!! $errors->first('lender', '<label class="control-label"
                                                                                     for="inputError">:message</label>')!!}
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class='col-md-2 control-label'>{!!Form::label('Loan Type') !!}</div>
                                        <div class='col-md-6'>
                                            <select name="loan_type[]" class="form-control">
                                                <option value="variable">Variable</option>
                                                <option value="fixed">Fixed</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group @if($errors->has('fixed_rate_term')) {{'has-error'}} @endif">
                                        <div class='col-md-2 control-label'>{!!Form::label('Fixed Rate Term') !!}</div>
                                        <div class='col-md-6'>
                                            <input type="text" name="fixed_rate_term[]" class="form-control" />
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
                                                <span class="input-group-addon"><span
                                                            class="glyphicon glyphicon-calendar"></span>
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
                                            <input type="text" name="limit[]" class="form-control" />
                                            @if($errors->has('limit'))
                                                {!! $errors->first('limit', '<label class="control-label"
                                                                                    for="inputError">:message</label>')!!}
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group @if($errors->has('balance')) {{'has-error'}} @endif">
                                        <div class='col-md-2 control-label'>{!!Form::label('Balance') !!}</div>
                                        <div class='col-md-6'>
                                            <input type="text" name="balance[]" class="form-control" />
                                            @if($errors->has('balance'))
                                                {!! $errors->first('balance', '<label class="control-label"
                                                                                      for="inputError">:message</label>')!!}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="add-property-div">
                        <hr/>
                        <div class="form-group">
                            <div class='col-md-2 control-label'>{!!Form::label('Add up to ten properties') !!}</div>
                            <div class='col-md-6'>
                                <button type="button" class="btn btn-success add-property">Add an Property
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer col-lg-12 clear-both">
                    <input type="submit" class="btn btn-primary" value="Next" name="submit"/>
                </div>
            </div>

        </div>
        {!!Form::close()!!}
    </div>
    {{ EX::js('assets/js/application/property.js') }}
@stop