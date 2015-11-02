<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Other Assets</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
            <div class='col-md-2 control-label'>{!!Form::label('Any Other Assets?') !!}</div>
            <div class='col-md-6'>
                <label>{!! Form::radio('assets', 1) !!} Yes</label>
                <label>{!! Form::radio('assets', 0, true) !!} No</label>
            </div>
        </div>

        <div class="asset-details" style="display:none">
            <div class="new-asset">
                <h2>Asset <span class="asset-num">1</span> Details</h2>
                <hr/>
                <div class="form-group">
                    <div class='col-md-2 control-label'>{!!Form::label('Added this by mistake?') !!}</div>
                    <div class='col-md-6'>
                        <button type="button" class="btn btn-danger remove-asset">Remove this asset
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <div class='col-md-2 control-label'>{!!Form::label('Ownership') !!}</div>
                    <div class='col-md-6'>
                        <select name="other_applicant_id[]" class="form-control">
                            @foreach($applicants as $key => $applicant)
                                <option value="{{$key}}">{{$applicant}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group @if($errors->has('type')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Type') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control" name="other_type[]">
                        @if($errors->has('type'))
                            {!! $errors->first('type', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('value')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Value') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control" name="other_value[]">
                        @if($errors->has('value'))
                            {!! $errors->first('value', '<label class="control-label"
                                                                for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('home_content')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Home Content') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control" name="home_content[]">
                        @if($errors->has('home_content'))
                            {!! $errors->first('home_content', '<label class="control-label"
                                                                       for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('superannuation')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Superannuation') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control" name="superannuation[]">
                        @if($errors->has('superannuation'))
                            {!! $errors->first('superannuation', '<label class="control-label"
                                                                         for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('deposit_paid')) {{'has-error'}} @endif">
                    <div class='col-md-2 control-label'>{!!Form::label('Deposit Paid') !!}</div>
                    <div class='col-md-6'>
                        <input type="text" class="form-control" name="deposit_paid[]">
                        @if($errors->has('deposit_paid'))
                            {!! $errors->first('deposit_paid', '<label class="control-label"
                                                                       for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                </div>
            </div>
            <div class="add-asset-div">
                <hr/>
                <div class="form-group">
                    <div class='col-md-2 control-label'>{!!Form::label('Add up to ten assets') !!}</div>
                    <div class='col-md-6'>
                        <button type="button" class="btn btn-success add-asset">Add a Asset</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>