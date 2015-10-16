@foreach($loan_details as $key => $loan_detail)
    <div class="new-loan">
        <div class="box no-border">
            <div class="box-header with-border">
                <h3 class="box-title">Loan <span class="loan-num">{{$key + 1}}</span> Details</h3>
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

                <input type="hidden" name="loan_id[{{$key}}]" value="{{$loan_detail->id}}"/>
                <div class="form-group @if($errors->has('amount')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Amount') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" name="amount[{{$key}}]" value="{{$loan_detail->amount}}"
                               class="form-control"/>
                        @if($errors->has('amount'))
                            {!! $errors->first('amount', '<label class="control-label"
                                                                       for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class='col-md-2 control-label'>{!!Form::label('Loan Purpose') !!}</div>
                    <div class='col-md-6'>
                        <select name="loan_purpose[{{$key}}]" class="form-control">
                            @foreach(config('general.new_loan_purpose') as $pur_key => $purpose)
                                <option value="{{$pur_key}}" {{($loan_detail->loan_purpose == $pur_key)? 'selected = "selected"' : ''}}>{{$purpose}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group @if($errors->has('deposit_paid')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Deposit Paid') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" name="deposit_paid[{{$key}}]" value="{{$loan_detail->deposit_paid}}"
                               class="form-control"/>
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
                            <input type="text" name="settlement_date[{{$key}}]" class="form-control expiry_date"
                                   value="{{$loan_detail->settlement_date}}"/>
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
                        <select name="loan_usage[{{$key}}]" class="form-control">
                            @foreach(config('general.loan_usage') as $usage_key => $usage)
                                <option value="{{$usage_key}}" {{($loan_detail->loan_usage == $usage_key)? 'selected = "selected"' : ''}}>{{$usage}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group @if($errors->has('total_loan_term')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Total loan term') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" name="total_loan_term[{{$key}}]" value="{{$loan_detail->total_loan_term}}"
                               class="form-control"/>
                        @if($errors->has('total_loan_term'))
                            {!! $errors->first('total_loan_term', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class='col-md-2 control-label'>{!!Form::label('Loan Type') !!}</div>
                    <div class='col-md-6'>
                        <label><input type="radio" name="loan_type[{{$key}}]" value='variable'
                                      checked="checked"
                                      {{($loan_detail->loan_type == 'variable')? 'checked = "checked"' : ''}} class="loan_type"/>
                            Variable</label>
                        <label><input type="radio" name="loan_type[{{$key}}]" value='fixed'
                                      {{($loan_detail->loan_type == 'fixed')? 'checked = "checked"' : ''}} class="loan_type"/>
                            Fixed</label>
                    </div>
                </div>

                <div class="form-group @if($errors->has('fixed_rate_term')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Fixed Rate Terms') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" name="fixed_rate_term[{{$key}}]" value="{{$loan_detail->fixed_rate_term}}"
                               class="form-control"/>
                        @if($errors->has('fixed_rate_term'))
                            {!! $errors->first('fixed_rate_term', '<label class="control-label"
                                                                            for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class='col-md-2 control-label'>{!!Form::label('Repayment Type') !!}</div>
                    <div class='col-md-6'>
                        <label><input type="radio" name="repayment_type[{{$key}}]" value='IO'
                                      {{($loan_detail->repayment_type == 'IO')? 'checked = "checked"' : ''}} class="repayment_type"/>
                            IO</label>
                        <label><input type="radio" name="repayment_type[{{$key}}]" value='P&I'
                                      {{($loan_detail->repayment_type == 'P&I')? 'checked = "checked"' : ''}} class="repayment_type"/>
                            P&I</label>
                    </div>
                </div>

                <div class="form-group @if($errors->has('io_term')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('IO Term') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" name="io_term[{{$key}}]" value="{{$loan_detail->io_term}}"
                               class="form-control"/>
                        @if($errors->has('io_term'))
                            {!! $errors->first('io_term', '<label class="control-label"
                                                                            for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('interest_rate')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Interest rate') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" name="interest_rate[{{$key}}]" value="{{$loan_detail->interest_rate}}"
                               class="form-control"/>
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
@endforeach