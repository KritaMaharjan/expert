@extends('system.layouts.main')

@section('title')
Email Settings
@stop 

@section('heading')
Email Settings
@stop

@section('breadcrumb')
    @parent
    <li>Setting</li>
    <li>Email</li>
@stop

@section('content')

    <div class="box box-solid">
        <div class="box-body">
            

    <form role="form" method="post" action="{{url('system/setting/update')}}" >
    <input type="hidden" name="_token" value="{{csrf_token()}}">

    <input type="hidden" name="group"  class="form-control" value="email">

        <div class="box-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Sender Name</label>
                <input type="name" name="name" class="form-control" value="{{ $setting->name or old('name') }}">
                @if($errors->has('name'))
                    {!! $errors->first('name', '<label for="inputError" class="control-label has-error"><i class="fa fa-times-circle-o"></i> :message</label>') !!}
                @endif
            </div>
             <div class="form-group">
                <label for="exampleInputEmail1">Sender Email</label>
                <input type="email" name="email" id="exampleInputEmail1" class="form-control" value="{{ $setting->email or old('email') }}" >
                @if($errors->has('email'))
                    {!! $errors->first('email', '<label for="inputError" class="control-label has-error"><i class="fa fa-times-circle-o"></i> :message</label>') !!}
                @endif
            </div>
             <div class="form-group">
                <label for="exampleInputEmail1">Sender Password</label>
                <input type="password" name="password"  class="form-control" value="{{ $setting->password or old('password') }}">
                @if($errors->has('password'))
                    {!! $errors->first('password', '<label for="inputError" class="control-label has-error"><i class="fa fa-times-circle-o"></i> :message</label>') !!}
                @endif
            </div>
             <div class="form-group">
                <label for="exampleInputEmail1">Email Notify</label>
                <input type="email" name="notify" id="exampleInputEmail2" class="form-control" value="{{ $setting->notify or  old('notify') }}">
                @if($errors->has('notify'))
                    {!! $errors->first('notify', '<label for="inputError" class="control-label has-error"><i class="fa fa-times-circle-o"></i> :message</label>') !!}
                @endif
            </div>
        </div><!-- /.box-body -->

    <div class="box-footer">
        <button class="btn btn-primary" type="submit">Submit</button>
    </div>
</form>

        </div>
    <div>

    
@stop