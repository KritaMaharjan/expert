{!! Form::model($support_smtp, array('class' => 'form-horizontal', 'name' => 'support_email_setting')) !!}

{{--<form method="post" name="support_email_setting" class="form-horizontal">--}}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="group" value="support_smtp">
        <div class="form-group no-mg">
            <label class="control-label">Incoming Server</label>
            <div class="@if($errors->has('incoming_server')) {{'has-error'}} @endif">
            {!!Form::text('incoming_server', NULL, array('class' => 'form-control', 'id' => 'incoming_server'))!!}
            @if($errors->has('incoming_server'))
                {!! $errors->first('incoming_server', '<label class="control-label" for="inputError">:message</label>') !!}
            @endif
          </div>
        </div>
        <div class="form-group no-mg">
            <label class="control-label">Outgoing Server</label>
            <div class="@if($errors->has('outgoing_server')) {{'has-error'}} @endif">
                {!!Form::text('outgoing_server', NULL, array('class' => 'form-control', 'id' => 'outgoing_server'))!!}
            @if($errors->has('outgoing_server'))
                {!! $errors->first('outgoing_server', '<label class="control-label" for="inputError">:message</label>') !!}
            @endif
          </div>
        </div>

        <div class="form-group no-mg">
            <label class="control-label">Port Number</label>
            <div class="@if($errors->has('port')) {{'has-error'}} @endif">
            {!!Form::text('port', NULL, array('class' => 'form-control', 'id' => 'port'))!!}

            @if($errors->has('port'))
                {!! $errors->first('port', '<label class="control-label" for="inputError">:message</label>') !!}
            @endif
          </div>
        </div>
        <div class="form-group no-mg">
            <label class="control-label">Email</label>
            <div class="@if($errors->has('email')) {{'has-error'}} @endif">
            {!!Form::text('email', NULL, array('class' => 'form-control', 'id' => 'email'))!!}

            @if($errors->has('email'))
                {!! $errors->first('email', '<label class="control-label" for="inputError">:message</label>') !!}
            @endif
          </div>
        </div>
        <div class="form-group no-mg">
            <label class="control-label">Password</label>
            <div class="@if($errors->has('password')) {{'has-error'}} @endif">
            {!!Form::password('password', array('class' => 'form-control', 'id' => 'password'))!!}

            @if($errors->has('password'))
                {!! $errors->first('password', '<label class="control-label" for="inputError">:message</label>') !!}
            @endif
          </div>
        </div>
        <div class="form-group clearfix">
          <div class="col-sm-offset-2 col-sm-10">
            <button link="{{tenant_route('tenant.setting.email')}}" class="btn btn-success pull-right save">Save</button>
          </div>
        </div>
    {{--</form>--}}
{!! Form::close() !!}