@extends('system.layouts.main')
@section('title')
Template Settings
@stop
@section('heading')
Template Settings
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-cog"></i> Setting</li>
    <li><i class="fa fa-cog"></i> Template</li>
@stop

@section('content')

    <div class="box box-solid">
        <div class="box-body">
         
        	<form role="form" method="post" action="{{url('system/setting/update')}}" >
                <input type="hidden" name="_token" value="{{csrf_token()}}">

                <input type="hidden" name="group"  class="form-control" value="template">


            <div class="form-group">
                <label>Account confirmation email</label><br>
                <label>Subject : </label>
                <input type="name" name="confirmation_email_subject" class="form-control" value="{{ $setting->confirmation_email_subject or old('confirmation_email_subject') }}"><br>
                 <label>Body : </label>
                    <textarea id="confirmation_email" rows="3" name="confirmation_email" class="form-control">{{ $setting->confirmation_email or old('confirmation_email') }}</textarea>
            </div>
            <div class="form-group">
                <label>User Account setup complete</label><br>
                <label>Subject : </label>
                <input type="name" name="domain_setup_subject" class="form-control" value="{{ $setting->domain_setup_subject or old('domain_setup_subject') }}"><br>
                 <label>Body : </label>
                    <textarea id="domain_setup" rows="3" name="domain_setup" class="form-control">{{ $setting->domain_setup or old('domain_setup') }}</textarea>
            </div>


            <div class="form-group">
                <label>User request APP url</label><br>
                <label>Subject : </label>
                <input type="name" name="request_url_subject" class="form-control" value="{{ $setting->request_url_subject or old('request_url_subject') }}"><br>
                 <label>Body : </label>
                    <textarea id="request_url" rows="3" name="request_url" class="form-control">{{ $setting->request_url or old('request_url') }}</textarea>
            </div>



            <div class="form-group">
                <label>Forgot password request</label><br>
                 <label>Subject : </label>
                <input type="name" name="forgot_password_subject" class="form-control" value="{{ $setting->forgot_password_subject or old('forgot_password_subject') }}"><br>
                 <label>Body : </label>
                    <textarea id="forgot_password" rows="3" name="forgot_password" class="form-control">{{ $setting->forgot_password or old('forgot_password') }}</textarea>
            </div>

               <div class="form-group">
                <label>Password Reset Confirm</label><br>
                 <label>Subject : </label>
                <input type="name" name="password_confirm_subject" class="form-control" value="{{ $setting->password_confirm_subject or old('password_confirm_subject') }}"><br>
                 <label>Body : </label>
                    <textarea id="password_confirm" rows="3" name="password_confirm" class="form-control">{{ $setting->password_confirm or old('password_confirm') }}</textarea>
            </div>
            <div class="box-footer">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
        </div>
    <div>


    {{FB::js('assets/plugins/ckeditor/ckeditor.js')}}
    {{FB::js('assets/plugins/ckeditor/styles.js')}}
    {{FB::js("
    $(function () {
        CKEDITOR.replace('password_confirm');
        CKEDITOR.replace('confirmation_email');
        CKEDITOR.replace('domain_setup');
        CKEDITOR.replace('forgot_password');
        CKEDITOR.replace('request_url');
      });
    ")}}

@stop