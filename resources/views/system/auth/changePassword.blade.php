@extends('system.layouts.main')

@section('heading')
Change Password
@stop

@section('breadcrumb')
@parent
<li><i class="fa fa-users"></i> Change password</li>
@stop

@section('content')
<div class="box box-solid">
        <div class="box-body">
            

    <form role="form" method="post" action="{{url('system/change-password')}}" >
    <input type="hidden" name="_token" value="{{csrf_token()}}">

    <input type="hidden" name="group"  class="form-control" value="email">

        <div class="box-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Old password</label>
                <input type="password" name="password" class="form-control" value="">
                 @if($errors->has('password'))
                    {!! $errors->first('password', '<label for="inputError" class="control-label has-error"><i class="fa fa-times-circle-o"></i> :message</label>') !!}
                @endif
               
            </div>
             <div class="form-group">
                <label for="exampleInputEmail1">New password</label>
                <input type="password" name="new_password" class="form-control" value="">
                
            </div>
             <div class="form-group">
                <label for="exampleInputEmail1">Confirm password</label>
                <input type="password" name="new_password_confirmation" class="form-control" value="">
                 @if($errors->has('new_password_confirmation'))
                    {!! $errors->first('new_password_confirmation', '<label for="inputError" class="control-label has-error"><i class="fa fa-times-circle-o"></i> :message</label>') !!}
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