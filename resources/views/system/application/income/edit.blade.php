@foreach($income_details as $inc_key => $income_detail)
    <div class="new-income">
        <h2>Current Employment <span class="income-num">{{$inc_key + 1}}</span> Details</h2>
        <hr/>
        Employment Income
        <div class="form-group">
            <div class='col-md-2 control-label'>{!!Form::label('Added this by mistake?') !!}</div>
            <div class='col-md-6'>
                <button type="button" class="btn btn-danger remove-income">Remove this income
                </button>
            </div>
        </div>
        <input type="hidden" name="income_id[{{$inc_key}}]" value="{{$income_detail->income_id}}"/>
        <div class="form-group">
            <div class='col-md-2 control-label'>{!!Form::label('Ownership') !!}</div>
            <div class='col-md-6'>
                <select name="applicant_id[{{$inc_key}}]" class="form-control">
                    @foreach($applicants as $key => $applicant)
                        <option value="{{$key}}" {{($income_detail->applicant_id == $key)? 'selected = "selected"' : ''}}>{{$applicant}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class='col-md-2 control-label'>{!!Form::label('Annual Gross Income') !!}</div>
            <div class='col-md-6'>
                <input type="text" name="annual_gross_income[{{$inc_key}}]" class="form-control" value="{{$income_detail->annual_gross_income}}"/>
            </div>
        </div>

        <div class="form-group">
            <div class='col-md-2 control-label'>{!!Form::label('Pay Frequency') !!}</div>
            <div class='col-md-6'>
                <select name="pay_frequency[{{$inc_key}}]" class="form-control">
                    @foreach(config('general.pay_frequency') as $key => $type)
                        <option value="{{$key}}" {{($income_detail->pay_frequency == $key)? 'selected = "selected"' : ''}}>{{$type}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class='col-md-2 control-label'>{!!Form::label('Salary Crediting') !!}</div>
            <div class='col-md-6'>
                <label><input type="radio" class="salary_credit" name="salary_crediting[{{$inc_key}}]" value=1 checked="checked"/>
                    Yes</label>
                <label><input type="radio" class="salary_credit" name="salary_crediting[{{$inc_key}}]" value=0"> No</label>
            </div>
        </div>

        <div class="form-group @if($errors->has('credit_to_where')) {{'has-error'}} @endif">
            <div class='col-md-2 control-label'>{!!Form::label('Credits to Where') !!}</div>
            <div class='col-md-6'>
                <input type="text" name="credit_to_where[{{$inc_key}}]" class="form-control" value="{{$income_detail->credit_to_where}}"/>
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
                    {!! Form:: text('latest_pay_date['.$inc_key.']', $income_detail->latest_pay_date, array('class' => 'form-control date-picker')) !!}
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
                    {!! Form:: text('latest_payslip_period_from['.$inc_key.']', $income_detail->latest_payslip_period_from, array('class' => 'form-control date-picker')) !!}
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
                    {!! Form:: text('latest_payslip_period_to['.$inc_key.']', $income_detail->latest_payslip_period_to, array('class' => 'form-control date-picker')) !!}
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
                <select name="employment_type[{{$inc_key}}]" class="form-control">
                    @foreach(config('general.employment_type') as $key => $type)
                        <option value="{{$key}}" {{($income_detail->employment_type == $key)? 'selected = "selected"' : ''}}>{{$type}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group @if($errors->has('job_title')) {{'has-error'}} @endif">
            <div class='col-md-2 control-label'>{!!Form::label('Job Title') !!}</div>
            <div class='col-md-6'>
                <input type="text" name="job_title[{{$inc_key}}]" class="form-control" value="{{$income_detail->job_title}}"/>
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
                    {!! Form:: text('starting_date['.$inc_key.']', $income_detail->starting_date, array('class' => 'form-control date-picker')) !!}
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
                <input type="text" name="business_name[{{$inc_key}}]" class="form-control" value="{{$income_detail->business_name}}"/>
                @if($errors->has('business_name'))
                    {!! $errors->first('business_name', '<label class="control-label"
                                                             for="inputError">:message</label>')!!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('abn')) {{'has-error'}} @endif">
            <div class='col-md-2 control-label'>{!!Form::label('Employer ABN') !!}</div>
            <div class='col-md-6'>
                <input type="text" name="abn[{{$inc_key}}]" class="form-control" value="{{$income_detail->abn}}"/>
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
                <input type="text" name="line1[{{$inc_key}}]" class="form-control" value="{{$income_detail->line1}}"/>
                @if($errors->has('line1'))
                    {!! $errors->first('line1', '<label class="control-label"
                                                        for="inputError">:message</label>')!!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('line2')) {{'has-error'}} @endif">
            <div class='col-md-2 control-label'>{!!Form::label('Line 2') !!}</div>
            <div class='col-md-6'>
                <input type="text" name="line2[{{$inc_key}}]" class="form-control" value="{{$income_detail->line2}}"/>
                @if($errors->has('line2'))
                    {!! $errors->first('line2', '<label class="control-label"
                                                        for="inputError">:message</label>')!!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('suburb')) {{'has-error'}} @endif">
            <div class='col-md-2 control-label'>{!!Form::label('Suburb') !!}</div>
            <div class='col-md-6'>
                <input type="text" name="suburb[{{$inc_key}}]" class="form-control" value="{{$income_detail->suburb}}"/>
                @if($errors->has('suburb'))
                    {!! $errors->first('suburb', '<label class="control-label"
                                                         for="inputError">:message</label>')!!}
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class='col-md-2 control-label'>{!!Form::label('State') !!}</div>
            <div class='col-md-6'>
                <select name="state[{{$inc_key}}]" class="form-control">
                    @foreach(config('general.state') as $key => $type)
                        <option value="{{$key}}" {{($income_detail->state == $key)? 'selected = "selected"' : ''}}>{{$type}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group @if($errors->has('postcode')) {{'has-error'}} @endif">
            <div class='col-md-2 control-label'>{!!Form::label('Postcode') !!}</div>
            <div class='col-md-6'>
                <input type="text" name="postcode[{{$inc_key}}]" class="form-control" value="{{$income_detail->postcode}}"/>
                @if($errors->has('postcode'))
                    {!! $errors->first('postcode', '<label class="control-label"
                                                           for="inputError">:message</label>')!!}
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class='col-md-2 control-label'>{!!Form::label('Country') !!}</div>
            <div class='col-md-6'>
                <select name="country[{{$inc_key}}]" class="form-control">
                    @foreach(config('general.countries') as $key => $type)
                        <option value="{{$key}}" {{($income_detail->country == $key)? 'selected = "selected"' : ''}}>{{$type}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group @if($errors->has('contact_person')) {{'has-error'}} @endif">
            <div class='col-md-2 control-label'>{!!Form::label('Contact Person') !!}</div>
            <div class='col-md-6'>
                <input type="text" name="contact_person[{{$inc_key}}]" class="form-control" value="{{$income_detail->contact_person}}"/>
                @if($errors->has('contact_person'))
                    {!! $errors->first('contact_person', '<label class="control-label"
                                                                 for="inputError">:message</label>')!!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('contact_person_job_title')) {{'has-error'}} @endif">
            <div class='col-md-2 control-label'>{!!Form::label('Contact Person Job Title') !!}</div>
            <div class='col-md-6'>
                <input type="text" name="contact_person_job_title[{{$inc_key}}]" class="form-control" value="{{$income_detail->contact_person_job_title}}"/>
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
                <input type="text" name="contact_number[{{$inc_key}}]" class="form-control" value="{{$income_detail->contact_number}}"/>
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
                <input type="text" name="accountant_business_name[{{$inc_key}}]" class="form-control" value="{{$income_detail->accountant_details->accountant_business_name or ''}}"/>
                @if($errors->has('accountant_business_name'))
                    {!! $errors->first('accountant_business_name', '<label class="control-label"
                                                        for="inputError">:message</label>')!!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('accountant_contact_person')) {{'has-error'}} @endif">
            <div class='col-md-2 control-label'>{!!Form::label('Contact Person') !!}</div>
            <div class='col-md-6'>
                <input type="text" name="accountant_contact_person[{{$inc_key}}]" class="form-control" value="{{$income_detail->accountant_details->contact_person or ''}}"/>
                @if($errors->has('accountant_contact_person'))
                    {!! $errors->first('accountant_contact_person', '<label class="control-label"
                                                        for="inputError">:message</label>')!!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('phone_number')) {{'has-error'}} @endif">
            <div class='col-md-2 control-label'>{!!Form::label('Phone Number') !!}</div>
            <div class='col-md-6'>
                <input type="text" name="accountant_phone_number[{{$inc_key}}]" class="form-control" value="{{$income_detail->accountant_details->phone_number or ''}}"/>
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
                <input type="text" name="accountant_line1[{{$inc_key}}]" class="form-control" value="{{$income_detail->accountant_details->line1 or ''}}"/>
                @if($errors->has('line1'))
                    {!! $errors->first('line1', '<label class="control-label"
                                                        for="inputError">:message</label>')!!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('line2')) {{'has-error'}} @endif">
            <div class='col-md-2 control-label'>{!!Form::label('Line 2') !!}</div>
            <div class='col-md-6'>
                <input type="text" name="accountant_line2[{{$inc_key}}]" class="form-control" value="{{$income_detail->accountant_details->line2 or ''}}"/>
                @if($errors->has('line2'))
                    {!! $errors->first('line2', '<label class="control-label"
                                                        for="inputError">:message</label>')!!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('suburb')) {{'has-error'}} @endif">
            <div class='col-md-2 control-label'>{!!Form::label('Suburb') !!}</div>
            <div class='col-md-6'>
                <input type="text" name="accountant_suburb[{{$inc_key}}]" class="form-control" value="{{$income_detail->accountant_details->suburb or ''}}"/>
                @if($errors->has('suburb'))
                    {!! $errors->first('suburb', '<label class="control-label"
                                                         for="inputError">:message</label>')!!}
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class='col-md-2 control-label'>{!!Form::label('State') !!}</div>
            <div class='col-md-6'>
                <select name="accountant_state[{{$inc_key}}]" class="form-control">
                    @foreach(config('general.state') as $key => $type)
                        <option value="{{$key}}" {{(isset($income_detail->accountant_details->state) && $income_detail->accountant_details->state == $key)? 'selected = "selected"' : ''}}>{{$type}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group @if($errors->has('postcode')) {{'has-error'}} @endif">
            <div class='col-md-2 control-label'>{!!Form::label('Postcode') !!}</div>
            <div class='col-md-6'>
                <input type="text" name="accountant_postcode[{{$inc_key}}]" class="form-control" value="{{$income_detail->accountant_details->postcode or ''}}"/>
                @if($errors->has('postcode'))
                    {!! $errors->first('postcode', '<label class="control-label"
                                                           for="inputError">:message</label>')!!}
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class='col-md-2 control-label'>{!!Form::label('Country') !!}</div>
            <div class='col-md-6'>
                <select name="accountant_country[{{$inc_key}}]" class="form-control">
                    @foreach(config('general.countries') as $key => $type)
                        <option value="{{$key}}" {{(isset($income_detail->accountant_details->country) && $income_detail->accountant_details->country == $key)? 'selected = "selected"' : ''}}>{{$type}}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
@endforeach