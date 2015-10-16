{{-- Address Details--}}
@foreach($applicant->address as $address)
    <div class="box no-border">
        <div class="box-header">
            <h3 class="box-title">{{$address->type}} Address Details</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php $name_pref = strtolower($address->type) ?>
            <div class="form-group @if($errors->has('home_line1')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Line 1') !!}</div>
                <div class='col-md-6'>
                    <input type="text" value="{{$address->line1}}" class="form-control"
                           name="{{$name_pref}}_line1[{{$app_key}}]"/>
                </div>
            </div>

            <div class="form-group @if($errors->has('home_line2')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Line 2') !!}</div>
                <div class='col-md-6'>
                    <input type="text" value="{{$address->line2}}" class="form-control"
                           name="{{$name_pref}}_line2[{{$app_key}}]"/>
                </div>
            </div>

            <div class="form-group @if($errors->has('home_suburb')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Suburb') !!}</div>
                <div class='col-md-6'>
                    <input type="text" value="{{$address->suburb}}" class="form-control"
                           name="{{$name_pref}}_suburb[{{$app_key}}]"/>
                </div>
            </div>

            <div class="form-group">
                <div class='col-md-2 control-label'>{!!Form::label('State') !!}</div>
                <div class='col-md-6'>
                    <select name="{{$name_pref}}_state[{{$app_key}}]" class="form-control">
                        @foreach(config('general.state') as $key => $state)
                            <option value="{{$key}}" {{($address->state == $key)? 'selected="selected"' : ""}}>{{$state}}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="form-group @if($errors->has('home_postcode')) {{'has-error'}} @endif">
                <div class='col-md-2 control-label'>{!!Form::label('Postcode') !!}</div>
                <div class='col-md-6'>
                    <input type="text" value="{{$address->postcode}}" class="form-control"
                           name="{{$name_pref}}_postcode[{{$app_key}}]"/>
                </div>
            </div>

            <div class="form-group">
                <div class='col-md-2 control-label'>{!!Form::label('Country') !!}</div>
                <div class='col-md-6'>
                    <select name="{{$name_pref}}_country[{{$app_key}}]" class="form-control">
                        @foreach(config('general.countries') as $key => $countries)
                            <option value="{{$key}}" {{($address->country == $key)? 'selected="selected"' : ""}}>{{$countries}}</option>
                        @endforeach
                    </select>

                </div>
            </div> {{--housing status--}}

            @if($address->type == 'Home')

                <div class="form-group clearfix {{ ($errors->has('live_there_since'))? 'has-error': '' }}">
                    <div class='col-md-2 control-label'>{!! Form::label('Living there since') !!}</div>
                    <div class='col-md-6'>
                        <div id="due_date" class="input-group date">
                            <input type="text" value="{{$address->live_there_since}}"
                                   name="live_there_since[{{$app_key}}]"
                                   class="form-control date-picker[{{$app_key}}]"/>
                                            <span class="input-group-addon"><span
                                                        class="glyphicon glyphicon-calendar"></span>
                                </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endforeach