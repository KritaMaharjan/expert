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