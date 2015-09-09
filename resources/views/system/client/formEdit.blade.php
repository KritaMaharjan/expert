<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Personal Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="form-group @if($errors->has('preferred_name')) {{'has-error'}} @endif">
                    {!!Form::label('Preferred Name') !!}
                    {!!Form::text('preferred_name', null, array('class' => 'form-control', 'id'=>'preferred_name'))!!}
                    @if($errors->has('preferred_name'))
                        {!! $errors->first('preferred_name', '<label class="control-label"
                                                                     for="inputError">:message</label>') !!}
                    @endif
                </div>
                <div class="form-group @if($errors->has('given_name')) {{'has-error'}} @endif">
                    {!!Form::label('Given Name') !!}
                    {!!Form::text('given_name', null, array('class' => 'form-control', 'id'=>'given_name'))!!}
                    @if($errors->has('given_name'))
                        {!! $errors->first('given_name', '<label class="control-label"
                                                                 for="inputError">:message</label>') !!}
                    @endif
                </div>
                <div class="form-group @if($errors->has('surname')) {{'has-error'}} @endif">
                    {!!Form::label('Surname') !!}
                    {!!Form::text('surname', null, array('class' => 'form-control', 'id'=>'surname'))!!}
                    @if($errors->has('surname'))
                        {!! $errors->first('surname', '<label class="control-label"
                                                              for="inputError">:message</label>') !!}
                    @endif
                </div>

                {{--Phone Numbers go here--}}
                <div class="form-group">
                    {!!Form::label('Phone') !!}
                    <a class="add-phone pull-right"><i class="glyphicon glyphicon-plus"></i></a>

                    <div class="phone-group">
                        @foreach($client->client_phones as $client_phone)
                            <div class="row phone-row">
                                <div class="col-sm-3">
                                    <select name="phonetype[]" class="form-control">
                                        @foreach(config('general.phone_type') as $key => $phone)
                                            <option value="{{$key}}" {{($key == $client_phone->phone->type)? 'selected="selected"':''}}>{{$phone}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="phone[]" value="{{$client_phone->phone->number}}"
                                           class="form-control"/>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-danger btn-small remove-phone pull-right"><i
                                                class="glyphicon glyphicon-remove"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group @if($errors->has('email')) {{'has-error'}} @endif">
                    {!!Form::label('Email Address') !!}
                    {!!Form::text('email', null, array('class' => 'form-control', 'id'=>'email'))!!}
                    @if($errors->has('email'))
                        {!! $errors->first('email', '<label class="control-label"
                                                            for="inputError">:message</label>
                        ') !!}
                    @endif
                </div>
                <div class="form-group @if($errors->has('salary')) {{'has-error'}} @endif">
                    {!!Form::label('Annual Salary') !!}
                    {!!Form::text('salary', null, array('class' => 'form-control', 'id'=>'salary'))!!}
                    @if($errors->has('salary'))
                        {!! $errors->first('salary', '<label class="control-label"
                                                             for="inputError">:message</label>
                        ') !!}
                    @endif
                </div>

                <div class="form-group @if($errors->has('occupation')) {{'has-error'}} @endif">
                    {!!Form::label('Occupation') !!}
                    {!!Form::text('occupation', null, array('class' => 'form-control', 'id'=>'occupation'))!!}
                    @if($errors->has('occupation'))
                        {!! $errors->first('occupation', '<label class="control-label"
                                                                 for="inputError">:message</label>') !!}
                    @endif
                </div>

                <div class="form-group @if($errors->has('salary_type')) {{'has-error'}} @endif">
                    {!!Form::label('Salary Type') !!}
                    {!!Form::select('salary_type', array(1 => 'PayG', 2 => 'Self-employed'), null, array('class' =>
                    'form-control'));!!}
                    @if($errors->has('salary_type'))
                        {!! $errors->first('salary_type', '<label class="control-label"
                                                                  for="inputError">:message</label>') !!}
                    @endif
                </div>

                <div class="form-group">
                    {!!Form::label('Introduced By') !!}
                    {!!Form::select('introducer', $users, null, array('class' => 'form-control', 'id'=>'introducer'))!!}
                </div>

                <div class="form-group @if($errors->has('title')) {{'has-error'}} @endif">
                    {!!Form::label('Title') !!}
                    {!!Form::text('title', null, array('class' => 'form-control', 'id'=>'title'))!!}
                    @if($errors->has('title'))
                        {!! $errors->first('title', '<label class="control-label"
                                                            for="inputError">:message</label>
                        ') !!}
                    @endif
                </div>
            </div>

            {{--<div class="box-footer">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>--}}
        </div>
        <!-- /.box -->

    </div>
    <!--/.col (left) -->
    <!-- right column -->
    <div class="col-md-6">
        {{--Adresses--}}
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Address Details</h3>
            </div>
            <!-- /.box-header -->
            @foreach($client->client_addresses as $client_address)
                <div class="box-body">
                    <div class="form-group">
                        {!!Form::label('Type') !!}
                        <select name="type" class="form-control">
                            @foreach(config('general.address_type') as $key => $address_type)
                                <option value="{{$key}}" {{($key == $client_address->address_type_id)? 'selected="selected"':''}}>{{$address_type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group @if($errors->has('line1')) {{'has-error'}} @endif">
                        {!!Form::label('Line 1') !!}
                        {!!Form::text('line1', Input::old('line1') ? Input::old('line1') :
                        $client_address->address->line1, array('class' => 'form-control', 'id'=>'line1'))!!}
                        @if($errors->has('line1'))
                            {!! $errors->first('line1', '<label class="control-label"
                                                                for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('line2')) {{'has-error'}} @endif">
                        {!!Form::label('Line 2') !!}
                        {!!Form::text('line2', Input::old('line2') ? Input::old('line2') :
                        $client_address->address->line2, array('class' => 'form-control', 'id'=>'line2'))!!}
                        @if($errors->has('line2'))
                            {!! $errors->first('line2', '<label class="control-label"
                                                                for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('suburb')) {{'has-error'}} @endif">
                        {!!Form::label('Suburb') !!}
                        {!!Form::text('suburb', Input::old('suburb') ? Input::old('suburb') :
                        $client_address->address->suburb, array('class' => 'form-control', 'id'=>'suburb'))!!}
                        @if($errors->has('suburb'))
                            {!! $errors->first('suburb', '<label class="control-label"
                                                                 for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('state')) {{'has-error'}} @endif">
                        {!!Form::label('State') !!}
                        {!!Form::text('state', Input::old('state') ? Input::old('state') :
                        $client_address->address->state, array('class' => 'form-control', 'id'=>'state'))!!}
                        @if($errors->has('state'))
                            {!! $errors->first('state', '<label class="control-label"
                                                                for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('postcode')) {{'has-error'}} @endif">
                        {!!Form::label('Postcode') !!}
                        {!!Form::text('postcode', Input::old('postcode') ? Input::old('postcode') :
                        $client_address->address->postcode, array('class' => 'form-control', 'id'=>'postcode'))!!}
                        @if($errors->has('postcode'))
                            {!! $errors->first('postcode', '<label class="control-label"
                                                                   for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>

                    <div class="form-group @if($errors->has('country')) {{'has-error'}} @endif">
                        {!!Form::label('Country') !!}
                        {!!Form::select('country', config('general.countries'), Input::old('country') ?
                        Input::old('country') : $client_address->address->country, array('class' =>
                        'form-control'))!!}
                        @if($errors->has('country'))
                            {!! $errors->first('country', '<label class="control-label"
                                                                  for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>

                    <!-- /.box-body -->
                    {{--<div class="box-footer">
                        <button class="btn btn-primary" type="submit">Add Address</button>
                    </div>--}}
                </div>
                @endforeach
                        <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
</div>

{{EX::js('assets/js/client/client-form.js')}}