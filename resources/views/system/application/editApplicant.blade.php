<div class="new-applicant">
    <div class="box no-border">
        <div class="box-header">
            <h3 class="box-title">Applicant <span class="applicant-num">{{$app_key + 1}}</span> Details</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            {{-- General Application details --}}
            <div class="form-group remove-block">
                <div class='col-md-2 control-label'>{!!Form::label('Added this by mistake?') !!}</div>
                <div class='col-md-6'>
                    <button type="button" class="btn btn-danger remove-applicant">Remove this
                        applicant
                    </button>
                </div>
            </div>
            <div class="form-group">
                <div class='col-md-2 control-label'>{!!Form::label('Title') !!}</div>
                <div class='col-md-6'>
                    <select name="title[{{$app_key}}]" class="form-control">
                        @foreach(config('general.title') as $key => $title)
                            <option value="{{$key}}" {{($applicant->title == $key)? 'selected="selected"' : ""}}}>{{$title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group @if($errors->has('given_name')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('First Name') !!}</div>
                <div class='col-md-6'>
                    <input type="text" value="{{$applicant->given_name}}" class="form-control" name="given_name[{{$app_key}}]" />
                    @if($errors->has('given_name'))
                        {!! $errors->first('given_name', '<label class="control-label"
                                                                 for="inputError">:message</label>') !!}
                    @endif
                </div>
            </div>

            <div class="form-group @if($errors->has('surname')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Family Name') !!}</div>
                <div class='col-md-6'>
                    <input type="text" value="{{$applicant->surname}}" class="form-control" name="surname[{{$app_key}}]" />
                    @if($errors->has('surname'))
                        {!! $errors->first('surname', '<label class="control-label"
                                                              for="inputError">:message</label>') !!}
                    @endif
                </div>
            </div>

            <div class="form-group @if($errors->has('mother_maiden_name')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Mother Maiden Name') !!}</div>
                <div class='col-md-6'>
                    <input type="text" value="{{$applicant->mother_maiden_name}}" class="form-control" name="mother_maiden_name[{{$app_key}}]" />
                    @if($errors->has('mother_maiden_name'))
                        {!! $errors->first('mother_maiden_name', '<label class="control-label"
                                                                         for="inputError">:message</label>') !!}
                    @endif
                </div>
            </div>

            <div class="form-group @if($errors->has('email')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Email Address') !!}</div>
                <div class='col-md-6'>
                    <input type="text" value="{{$applicant->email}}" class="form-control" name="email[{{$app_key}}]" />
                    @if($errors->has('email'))
                        {!! $errors->first('email', '<label class="control-label"
                                                            for="inputError">:message</label>')!!}
                    @endif
                </div>
            </div>

            <div class="form-group clearfix {{ ($errors->has('dob'))? 'has-error': '' }}">
                <div class='col-md-2 control-label'>{!! Form::label('Date of Birth') !!}</div>
                <div class='col-md-6'>
                    <div id="due_date" class="input-group date">
                        <input type="text" value="{{$applicant->dob}}" class="form-control date-picker" name="dob[{{$app_key}}]" />
                                            <span class="input-group-addon"><span
                                                        class="glyphicon glyphicon-calendar"></span>
                                </span>
                    </div>
                    @if($errors->has('dob'))
                        {!! $errors->first('dob', '<label class="control-label"
                                                          for="inputError">:message</label>') !!}
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class='col-md-2 control-label'>{!!Form::label('Residency Status') !!}</div>
                <div class='col-md-6'>
                    <select name="residency_status[{{$app_key}}]" class="form-control">
                        @foreach(config('general.residency_status') as $key => $residency_status)
                            <option value="{{$key}}" {{($applicant->residency_status == $key)? 'selected="selected"' : ""}}>{{$residency_status}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="form-group @if($errors->has('years_in_au')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Years in AU') !!}</div>
                <div class='col-md-6'>
                    <input type="text" value="{{$applicant->years_in_au}}" class="form-control" name="years_in_au[{{$app_key}}]" />
                    @if($errors->has('years_in_au'))
                        {!! $errors->first('years_in_au', '<label class="control-label"
                                                                  for="inputError">:message</label>')!!}
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class='col-md-2 control-label'>{!!Form::label('Marital Status') !!}</div>
                <div class='col-md-6'>
                    <select name="marital_status[{{$app_key}}]" class="form-control">
                        @foreach(config('general.marital_status') as $key => $marital_status)
                            <option value="{{$key}}" {{($applicant->marital_status == $key)? 'selected="selected"' : ""}}>{{$marital_status}}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="form-group">
                <div class='col-md-2 control-label'>{!!Form::label('Credit Cards Issue') !!}</div>
                <div class='col-md-6'>
                    <label><input type="radio" name="credit_card_issue[{{$app_key}}]" value=1 checked="checked" /> Yes</label>
                    <label><input type="radio" name="credit_card_issue[{{$app_key}}]" value=0 /> No</label>
                </div>
            </div>
            <div class="issue-comments form-group @if($errors->has('issue_comments')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Issue Comments') !!}</div>
                <div class='col-md-6'>
                    <input type="text" value="{{$applicant->issue_comments}}" class="form-control" name="issue_comments[{{$app_key}}]" />
                    @if($errors->has('issue_comments'))
                        {!! $errors->first('issue_comments', '<label class="control-label"
                                                                     for="inputError">:message</label>')!!}
                    @endif
                </div>
            </div>
            <div class="form-group @if($errors->has('driver_licence_number')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Driver licence number') !!}</div>
                <div class='col-md-6'>
                    <input type="text" value="{{$applicant->driver_licence_number}}" class="form-control" name="driver_licence_number[{{$app_key}}]" />
                    @if($errors->has('driver_licence_number'))
                        {!! $errors->first('driver_licence_number', '<label class="control-label"
                                                                            for="inputError">:message</label>
                        ')!!}
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class='col-md-2 control-label'>{!!Form::label('Licence State') !!}</div>
                <div class='col-md-6'>
                    <select name="licence_state[{{$app_key}}]" class="form-control">
                        @foreach(config('general.licence_state') as $key => $licence_state)
                            <option value="{{$key}}" {{($applicant->licence_state == $key)? 'selected="selected"' : ""}}>{{$licence_state}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="form-group clearfix {{ ($errors->has('licence_expiry_date'))? 'has-error': '' }}">
                <div class='col-md-2 control-label'>{!! Form::label('Licence Expiry Dtae') !!}</div>
                <div class='col-md-6'>
                    <div id="due_date" class="input-group date">
                        <input type="text" value="{{$applicant->licence_expiry_date}}" name="licence_expiry_date[{{$app_key}}]" class="form-control expiry_date" />
                                            <span class="input-group-addon"><span
                                                        class="glyphicon glyphicon-calendar"></span>
                                </span>
                    </div>
                    @if($errors->has('licence_expiry_date'))
                        {!! $errors->first('licence_expiry_date', '<label class="control-label"
                                                                          for="inputError">:message</label>')
                        !!}
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class='col-md-2 control-label'>{!!Form::label('Dependants') !!}</div>
                <div class='col-md-6'>
                    <label><input type="radio" name="dependent[{{$app_key}}]" value=1 /> Yes</label>
                    <label><input type="radio" name="dependent[{{$app_key}}]" value=0 checked="checked" /> No</label>
                </div>
            </div>
            <div class="form-group dependant" style="display: none">
                <div class='col-md-2 control-label'>{!!Form::label('Age of Dependants') !!}</div>
                <div class='col-md-6'>
                                <span class="ages" value="{{$applicant->age or '' }}"><input type="text" name="age[{{$app_key}}][{{$app_key}}]"
                                                          class="form-control text-digit"/></span>
                    <a href="#" class="add-dependant"><i class="fa fa-plus-circle"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box -->
    @include('system.application.applicantAddress')
    @include('system.application.applicantPhone')

</div>