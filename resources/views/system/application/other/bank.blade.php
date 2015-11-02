<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Bank Accounts</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
            <div class='col-md-2 control-label'>{!!Form::label('Any Bank Accounts?') !!}</div>

            <div class='col-md-6'>
                <label>{!! Form::radio('banks', 1) !!} Yes</label>
                <label>{!! Form::radio('banks', 0, true) !!} No</label>
            </div>
        </div>

        <div class="bank-details" style="display:none">
            <div class="new-bank">
                <h2>Bank <span class="bank-num">1</span> Details</h2>
                <hr/>
                <div class="form-group">
                    <div class='col-md-2 control-label'>{!!Form::label('Added this by mistake?') !!}</div>
                    <div class='col-md-6'>
                        <button type="button" class="btn btn-danger remove-bank">Remove this account
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <div class='col-md-2 control-label'>{!!Form::label('Ownership') !!}</div>
                    <div class='col-md-6'>
                        <select name="bank_applicant_id[]" class="form-control">
                            @foreach($applicants as $key => $applicant)
                                <option value="{{$key}}">{{$applicant}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group @if($errors->has('bank')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Bank') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control" name="bank[]">
                        @if($errors->has('bank'))
                            {!! $errors->first('bank', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('balance')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('balance') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control" name="bank_balance[]">
                        @if($errors->has('balance'))
                            {!! $errors->first('balance', '<label class="control-label"
                                                                  for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>
            </div>
            <div class="add-bank-div">
                <hr/>
                <div class="form-group">
                    <div class='col-md-2 control-label'>{!!Form::label('Add up to ten accounts') !!}</div>
                    <div class='col-md-6'>
                        <button type="button" class="btn btn-success add-bank">Add a Bank Account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>