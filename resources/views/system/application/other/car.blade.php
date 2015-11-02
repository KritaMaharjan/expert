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