<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Credit Card Details</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
            <div class='col-md-2 control-label'>{!!Form::label('Any Credit Card?') !!}</div>
            <div class='col-md-6'>
                <label>{!! Form::radio('cards', 1) !!} Yes</label>
                <label>{!! Form::radio('cards', 0, true) !!} No</label>
            </div>
        </div>

        <div class="card-details" style="display:none">
            <div class="new-card">
                <h2>Credit Card <span class="card-num">1</span> Details</h2>
                <hr/>
                <div class="form-group">
                    <div class='col-md-2 control-label'>{!!Form::label('Added this by mistake?') !!}</div>
                    <div class='col-md-6'>
                        <button type="button" class="btn btn-danger remove-card">Remove this card
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <div class='col-md-2 control-label'>{!!Form::label('Ownership') !!}</div>
                    <div class='col-md-6'>
                        <select name="card_applicant_id[]" class="form-control">
                            @foreach($applicants as $key => $applicant)
                                <option value="{{$key}}">{{$applicant}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group card_types">
                    <div class="field">
                        <div class='col-md-2 control-label'>{!!Form::label('Credit Card Type') !!}</div>
                        <div class='col-md-6'>
                            <select name="card_type[]" class="form-control card_type">
                                @foreach(config('general.credit_card_type') as $key => $type)
                                    <option value="{{$key}}">{{$type}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="field other-name" style="display: none">
                        <div class="col-md-2">&nbsp;</div>
                        <div class="col-md-6">
                            <input type="text" class="form-control others_text" name="others[]">
                        </div>
                    </div>
                </div>

                <div class="form-group others">
                    <div class='col-md-2 control-label'>{!!Form::label('To Be Cleared') !!}</div>
                    <div class='col-md-6'>
                        <label><input type="radio" class="card_to_be_cleared" name="card_to_be_cleared[]" value=1 checked="checked" /> Yes</label>
                        <label><input type="radio" class="card_to_be_cleared" name="card_to_be_cleared[]" value=0 /> No</label>
                    </div>
                </div>

                <div class="form-group @if($errors->has('lender')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Lender') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control" name="card_lender[]">
                        @if($errors->has('lender'))
                            {!! $errors->first('lender', '<label class="control-label"
                                                                 for="inputError">:message</label>')!!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('debit_from')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Debit From') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control" name="card_debit_from[]">
                        @if($errors->has('debit_from'))
                            {!! $errors->first('debit_from', '<label class="control-label"
                                                                     for="inputError">:message</label>')!!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('limit')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Limit') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control" name="card_limit[]">
                        @if($errors->has('limit'))
                            {!! $errors->first('limit', '<label class="control-label"
                                                                for="inputError">:message</label>')!!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('balance')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Balance') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control" name="card_balance[]">
                        @if($errors->has('balance'))
                            {!! $errors->first('balance', '<label class="control-label"
                                                                  for="inputError">:message</label>')!!}
                        @endif
                    </div>
                </div>
            </div>
            <div class="add-card-div">
                <hr/>
                <div class="form-group">
                    <div class='col-md-2 control-label'>{!!Form::label('Add up to ten cards') !!}</div>
                    <div class='col-md-6'>
                        <button type="button" class="btn btn-success add-card">Add a Credit Card</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>