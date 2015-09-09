@extends('system.layouts.main')

@section('heading')
    Change Password
@stop

@section('breadcrumb')
    @parent
    <li>Change password</li>
@stop

@section('content')
    <div class="box">
        <div class="box-body">
            {!!Form::open(['class' => 'form-horizontal'])!!}
                <input type="hidden" name="_token" value="{{csrf_token()}}">

                <div class="box-body">
                    <div class="form-group @if($errors->has('password')) {{'has-error'}} @endif">
                        {!!Form::label('password', 'Old Password', ['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!!Form::password('password', array('class' => 'form-control', 'id'=>'password'))!!}
                                @if($errors->has('password'))
                                    {!! $errors->first('password', '<label for="inputError" class="control-label has-error"><i
                                                class="fa fa-times-circle-o"></i> :message</label>') !!}
                                @endif
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('new_password')) {{'has-error'}} @endif">
                        {!!Form::label('new_password', 'Old Password', ['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!!Form::password('new_password', array('class' => 'form-control', 'id'=>'new_password'))!!}
                                @if($errors->has('new_password'))
                                    {!! $errors->first('new_password', '<label for="inputError" class="control-label has-error"><i
                                                class="fa fa-times-circle-o"></i> :message</label>') !!}
                                @endif
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('new_password_confirmation')) {{'has-error'}} @endif">
                        {!!Form::label('new_password_confirmation', 'Confirm password', ['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!!Form::password('new_password_confirmation', array('class' => 'form-control', 'id'=>'password'))!!}
                            @if($errors->has('new_password_confirmation'))
                                    {!! $errors->first('new_password_confirmation', '<label for="inputError" class="control-label has-error"><i
                                                class="fa fa-times-circle-o"></i> :message</label>') !!}
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-primary" type="submit">Change Password</button>
                </div>
            {!!Form::close()!!}

        </div>
    </div>
@stop