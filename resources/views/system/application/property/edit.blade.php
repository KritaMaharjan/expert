<div class="new-property">
    <div class="box no-border">
        <div class="box-header with-border">
            <h3 class="box-title">Property <span class="property-num">{{$prop_key + 1}}</span> Details</h3>
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
                    <label><input type="radio" name="taken_as_security[{{$prop_key}}]" value=1 {{($property->taken_as_security == 1) ? 'checked="checked"' : ''}} /> Yes</label>
                    <label><input type="radio" name="taken_as_security[{{$prop_key}}]" value=0 {{($property->taken_as_security == 0) ? 'checked="checked"' : ''}} /> No</label>
                </div>
            </div>

            <div class="form-group @if($errors->has('market_value')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Market Value') !!}</div>
                <div class='col-md-6'>
                    <input type="text" name="market_value[{{$prop_key}}]" value="{{$property->market_value}}" class="form-control" />
                    @if($errors->has('market_value'))
                        {!! $errors->first('market_value', '<label class="control-label"
                                                                   for="inputError">:message</label>') !!}
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class='col-md-2 control-label'>{!!Form::label('Ownership') !!}</div>
                <div class='col-md-6'>
                    <select name="applicant_id[{{$prop_key}}]" class="form-control">
                        @foreach($applicants as $key => $applicant)
                            <option value="{{$key}}"  {{($property->applicant_id == $key)? 'selected="selected"' : ""}}>{{$applicant}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class='col-md-2 control-label'>{!!Form::label('Property Usage') !!}</div>
                <div class='col-md-6'>
                    <select name="property_usage[{{$prop_key}}]" class="form-control">
                        @foreach(config('general.property_usage') as $key => $usage)
                            <option value="{{$key}}"  {{($property->property_usage == $key)? 'selected="selected"' : ""}}>{{$usage}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class='col-md-2 control-label'>{!!Form::label('Property Type') !!}</div>
                <div class='col-md-6'>
                    <select name="property_type[{{$prop_key}}]" class="form-control">
                        @foreach(config('general.property_type') as $key => $type)
                            <option value="{{$key}}"  {{($property->property_type == $key)? 'selected="selected"' : ""}}>{{$type}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class='col-md-2 control-label'>{!!Form::label('Number Of Bedrooms') !!}</div>
                <div class='col-md-6'>
                    <select name="number_of_bedrooms[{{$prop_key}}]" class="form-control">
                        @foreach(config('general.zero_to_ten') as $key => $usage)
                            <option value="{{$key}}"  {{($property->number_of_bedrooms == $key)? 'selected="selected"' : ""}}>{{$usage}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class='col-md-2 control-label'>{!!Form::label('Number Of Bathrooms') !!}</div>
                <div class='col-md-6'>
                    <select name="number_of_bathrooms[{{$prop_key}}]" class="form-control">
                        @foreach(config('general.zero_to_ten') as $key => $usage)
                            <option value="{{$key}}"  {{($property->number_of_bathrooms == $key)? 'selected="selected"' : ""}}>{{$usage}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class='col-md-2 control-label'>{!!Form::label('Number Of Car Spaces') !!}</div>
                <div class='col-md-6'>
                    <select name="number_of_car_spaces[{{$prop_key}}]" class="form-control">
                        @foreach(config('general.zero_to_ten') as $key => $usage)
                            <option value="{{$key}}"  {{($property->number_of_car_spaces == $key)? 'selected="selected"' : ""}}>{{$usage}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group @if($errors->has('size')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Size (land in sqm)') !!}</div>
                <div class='col-md-6'>
                    <input type="text" name="size[{{$prop_key}}]" value="{{$property->size}}" class="form-control" />
                    @if($errors->has('size'))
                        {!! $errors->first('size', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
                    @endif
                </div>
            </div>

            <div class="form-group @if($errors->has('title_particulars')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Title Particulars') !!}</div>
                <div class='col-md-6'>
                    <input type="text" name="title_particulars[{{$prop_key}}]" value="{{$property->title_particulars}}" class="form-control" />
                    @if($errors->has('title_particulars'))
                        {!! $errors->first('title_particulars', '<label class="control-label"
                                                                        for="inputError">:message</label>') !!}
                    @endif
                </div>
            </div>

            <div class="form-group @if($errors->has('title_type')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Title Type') !!}</div>
                <div class='col-md-6'>
                    <input type="text" name="title_type[{{$prop_key}}]" value="{{$property->title_type}}" class="form-control" />
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
                    <input type="text" name="line1[{{$prop_key}}]" value="{{$property->line1}}" class="form-control" />
                    @if($errors->has('line1'))
                        {!! $errors->first('line1', '<label class="control-label"
                                                            for="inputError">:message</label>')!!}
                    @endif
                </div>
            </div>

            <div class="form-group @if($errors->has('line2')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Line 2') !!}</div>
                <div class='col-md-6'>
                    <input type="text" name="line2[{{$prop_key}}]" value="{{$property->line2}}" class="form-control" />
                    @if($errors->has('line2'))
                        {!! $errors->first('line2', '<label class="control-label"
                                                            for="inputError">:message</label>')!!}
                    @endif
                </div>
            </div>

            <div class="form-group @if($errors->has('suburb')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Suburb') !!}</div>
                <div class='col-md-6'>
                    <input type="text" name="suburb[{{$prop_key}}]" value="{{$property->suburb}}" class="form-control" />
                    @if($errors->has('suburb'))
                        {!! $errors->first('suburb', '<label class="control-label"
                                                             for="inputError">:message</label>')!!}
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class='col-md-2 control-label'>{!!Form::label('State') !!}</div>
                <div class='col-md-6'>
                    <select name="state[{{$prop_key}}]" class="form-control">
                        @foreach(config('general.state') as $key => $state)
                            <option value="{{$key}}"  {{($property->state == $key)? 'selected="selected"' : ""}}>{{$state}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group @if($errors->has('postcode')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Postcode') !!}</div>
                <div class='col-md-6'>
                    <input type="text" name="postcode[{{$prop_key}}]" value="{{$property->postcode}}" class="form-control" />
                    @if($errors->has('postcode'))
                        {!! $errors->first('postcode', '<label class="control-label"
                                                               for="inputError">:message</label>')!!}
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class='col-md-2 control-label'>{!!Form::label('Country') !!}</div>
                <div class='col-md-6'>
                    <select name="country[{{$prop_key}}]" class="form-control">
                        @foreach(config('general.countries') as $key => $country)
                            <option value="{{$key}}"  {{($property->country == $key)? 'selected="selected"' : ""}}>{{$country}}</option>
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
                    <label><input type="radio" name="rental_income[{{$prop_key}}]" value=1 {{!empty($property->income)? 'checked="checked"' : ''}} /> Yes</label>
                    <label><input type="radio" name="rental_income[{{$prop_key}}]" value=0 {{empty($property->income)? 'checked="checked"' : ''}} /> No</label>
                </div>
            </div>

            <div class="rental-details">

                <div class="form-group @if($errors->has('weekly_rental')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Weekly Rental') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" name="weekly_rental[{{$prop_key}}]" value="{{$property->income->weekly_rental or ''}}" class="form-control" />
                        @if($errors->has('weekly_rental'))
                            {!! $errors->first('weekly_rental', '<label class="control-label"
                                                                        for="inputError">:message</label>')!!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('credit_to')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Credit To') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" name="credit_to[{{$prop_key}}]" value="{{$property->income->credit_to or ''}}" class="form-control" />
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
                    <select name="access_party[{{$prop_key}}]" class="form-control">
                        @foreach(config('general.valuation_access_party') as $key => $access_party)
                            <option value="{{$key}}"  {{($property->access_party == $key)? 'selected="selected"' : ""}}>{{$access_party}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group @if($errors->has('contact_person')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Contact Person') !!}</div>
                <div class='col-md-6'>
                    <input type="text" name="contact_person[{{$prop_key}}]" value="{{$property->contact_person or ''}}" class="form-control" />
                </div>
            </div>

            <div class="form-group @if($errors->has('phone_number')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Phone Number') !!}</div>
                <div class='col-md-6'>
                    <input type="text" name="phone_number[{{$prop_key}}]" value="{{$property->phone_number}}" class="form-control" />
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
                    <label><input type="radio" name="existing_loans[{{$prop_key}}]" value=1 {{!empty($property->existing_loans)? 'checked="checked"' : ''}} /> Yes</label>
                    <label><input type="radio" name="existing_loans[{{$prop_key}}]" value=0 {{empty($property->existing_loans)? 'checked="checked"' : ''}} /> No</label>
                </div>
            </div>

            <div class="loans-details" style="display:none">

                <div class="form-group">
                    <div class='col-md-2 control-label'>{!!Form::label('Ownership') !!}</div>
                    <div class='col-md-6'>
                        <select name="ownership[{{$prop_key}}]" class="form-control">
                            @foreach($applicants as $key => $applicant)
                                <option value="{{$key}}" {{($property->existing_loans->applicant_id == $key)? 'selected="selected"' : ""}}>{{$applicant}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class='col-md-2 control-label'>{!!Form::label('To Be Cleared') !!}</div>
                    <div class='col-md-6'>
                        <label><input type="radio" name="to_be_cleared[{{$prop_key}}]" value=1 checked="checked" /> Yes</label>
                        <label><input type="radio" name="to_be_cleared[{{$prop_key}}]" value=0 /> No</label>
                    </div>
                </div>

                <div class="form-group @if($errors->has('lender')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Lender') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" name="lender[{{$prop_key}}]" value="{{$property->existing_loans->lender or ''}}" class="form-control" />
                        @if($errors->has('lender'))
                            {!! $errors->first('lender', '<label class="control-label"
                                                                 for="inputError">:message</label>')!!}
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class='col-md-2 control-label'>{!!Form::label('Loan Type') !!}</div>
                    <div class='col-md-6'>
                        <select name="loan_type[{{$prop_key}}]" class="form-control">
                            <option value="variable">Variable</option>
                            <option value="fixed">Fixed</option>
                        </select>
                    </div>
                </div>

                <div class="form-group @if($errors->has('fixed_rate_term')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Fixed Rate Term') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" name="fixed_rate_term[{{$prop_key}}]" value="{{$property->existing_loans->fixed_rate_term or ''}}" class="form-control" />
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
                        <input type="text" name="limit[{{$prop_key}}]" value="{{$property->existing_loans->limit or ''}}" class="form-control" />
                        @if($errors->has('limit'))
                            {!! $errors->first('limit', '<label class="control-label"
                                                                for="inputError">:message</label>')!!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('balance')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Balance') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" name="balance[{{$prop_key}}]" value="{{$property->existing_loans->balance or ''}}" class="form-control" />
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